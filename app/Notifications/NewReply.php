<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\User;
use App\Support\Markdown;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

/**
 * Tells a question's author that someone replied.
 */
class NewReply extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * At most one email per thread in this window, so a busy thread doesn't
     * flood the author's inbox. Every reply still shows in the app.
     */
    public const EMAIL_COOLDOWN_MINUTES = 15;

    public function __construct(public Comment $comment) {}

    /**
     * @return list<string>
     */
    public function via(User $notifiable): array
    {
        $channels = ['database'];

        if ($notifiable->notify_replies
            && $notifiable->hasVerifiedEmail()
            && Cache::add($this->cooldownKey($notifiable), true, now()->addMinutes(self::EMAIL_COOLDOWN_MINUTES))) {
            $channels[] = 'mail';
        }

        return $channels;
    }

    public function toMail(User $notifiable): MailMessage
    {
        $thread = $this->comment->thread;

        return (new MailMessage)
            ->subject('New reply to "'.Str::limit($thread->title, 60).'"')
            // User-written text is escaped so it can't add links or formatting to the email.
            ->greeting('Hi '.Markdown::escape($notifiable->name).',')
            ->line(Markdown::escape($this->comment->user->name).' replied to your question **'.Markdown::escape($thread->title).'**:')
            ->line('> '.Markdown::escape($this->comment->excerpt()))
            ->action('View the reply', $this->url())
            ->line('Don\'t want these emails? Turn them off in your [profile settings]('.route('profile.edit').'#notifications).');
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(User $notifiable): array
    {
        return [
            'thread_id' => $this->comment->thread_id,
            'thread_title' => $this->comment->thread->title,
            'comment_id' => $this->comment->id,
            'replier_name' => $this->comment->user->name,
            'excerpt' => $this->comment->excerpt(140),
        ];
    }

    private function url(): string
    {
        return route('threads.show', $this->comment->thread_id).'#reply-'.$this->comment->id;
    }

    private function cooldownKey(User $notifiable): string
    {
        return "reply-email:{$notifiable->id}:{$this->comment->thread_id}";
    }
}
