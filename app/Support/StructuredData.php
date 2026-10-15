<?php

namespace App\Support;

use App\Models\Comment;
use App\Models\Thread;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class StructuredData
{
    /**
     * schema.org QAPage data for a thread, so search engines can show the
     * question and its answers as a rich result.
     *
     * @param  Collection<int, Comment>  $comments
     */
    public static function qaPage(Thread $thread, Collection $comments): array
    {
        $accepted = $comments->firstWhere('id', $thread->accepted_comment_id);

        return [
            '@context' => 'https://schema.org',
            '@type' => 'QAPage',
            'mainEntity' => array_filter([
                '@type' => 'Question',
                'name' => $thread->title,
                'text' => self::plainText($thread->body),
                'answerCount' => $comments->count(),
                'upvoteCount' => $thread->score,
                'dateCreated' => $thread->created_at->toAtomString(),
                'author' => self::person($thread),
                'acceptedAnswer' => $accepted ? self::answer($thread, $accepted) : null,
                'suggestedAnswer' => $comments->reject(fn (Comment $comment) => $comment->is($accepted))
                    ->map(fn (Comment $comment) => self::answer($thread, $comment))
                    ->values()
                    ->all(),
            ], fn ($value) => $value !== null && $value !== []),
        ];
    }

    /**
     * Encode for a <script type="application/ld+json"> tag. JSON_HEX_TAG
     * escapes < and > so a post containing "</script>" can't break out.
     */
    public static function toScript(array $data): string
    {
        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_THROW_ON_ERROR);
    }

    private static function answer(Thread $thread, Comment $comment): array
    {
        return [
            '@type' => 'Answer',
            'text' => self::plainText($comment->body),
            'upvoteCount' => $comment->score,
            'dateCreated' => $comment->created_at->toAtomString(),
            'url' => route('threads.show', $thread).'#reply-'.$comment->id,
            'author' => self::person($comment),
        ];
    }

    private static function person(Thread|Comment $post): array
    {
        return ['@type' => 'Person', 'name' => $post->user->name];
    }

    private static function plainText(string $markdown): string
    {
        return Str::squish(html_entity_decode(strip_tags(Markdown::render($markdown)), ENT_QUOTES | ENT_HTML5));
    }
}
