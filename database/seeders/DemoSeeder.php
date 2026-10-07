<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    /**
     * Seed demo users, threads and replies for local development.
     */
    public function run(): void
    {
        $demo = User::factory()->create([
            'name' => 'Demo User',
            'email' => 'demo@codingsols.test',
        ]);
        $others = User::factory(4)->create();

        $threads = [
            ['python', 'How do I read a CSV file into a pandas DataFrame?', "I have a `data.csv` file with a header row. What's the simplest way to load it?\n\n```python\nimport pandas as pd\n# ???\n```", "Use `read_csv`:\n\n```python\ndf = pd.read_csv(\"data.csv\")\nprint(df.head())\n```", ['pandas', 'csv']],
            ['java', 'NullPointerException when calling a method on a list', "My code throws `NullPointerException` on `items.add(x)`:\n\n```java\nList<String> items;\nitems.add(\"a\");\n```", "You declared `items` but never created it. Initialize it first:\n\n```java\nList<String> items = new ArrayList<>();\n```", ['collections', 'nullpointerexception']],
            ['javascript', 'Difference between let, const and var?', 'When should I use each one in modern JavaScript?', 'Default to `const`, use `let` when you need to reassign, and avoid `var` because it is function-scoped and hoisted.', ['es6', 'variables']],
            ['cpp', 'Why should I prefer std::vector over raw arrays?', 'Our course still uses `int arr[100]`. Is `std::vector` actually better?', '`std::vector` knows its size, grows on demand and frees its memory automatically. Use `std::array` when the size is fixed at compile time.', ['stl', 'arrays']],
            ['django', 'How do I add a custom field to the Django User model?', 'I need to store a phone number for each user. Should I extend `User`?', 'For new projects, set `AUTH_USER_MODEL` to a custom model that extends `AbstractUser` before your first migration.', ['auth', 'models']],
        ];

        foreach ($threads as $i => [$slug, $title, $body, $reply, $tags]) {
            $author = $i % 2 === 0 ? $demo : $others[$i % $others->count()];
            $thread = Category::where('slug', $slug)->firstOrFail()
                ->threads()->make(['title' => $title, 'body' => $body]);
            $thread->user()->associate($author);
            $thread->created_at = $thread->updated_at = now()->subHours(($i + 1) * 7);
            $thread->save();
            $thread->tags()->sync(Tag::findOrCreateMany($tags)->modelKeys());

            $comment = $thread->comments()->make(['body' => $reply]);
            $comment->user()->associate($others[($i + 1) % $others->count()]);
            $comment->created_at = $comment->updated_at = $thread->created_at->copy()->addMinutes(40);
            $comment->save();

            // Some votes from other members, and an accepted answer on the first few.
            foreach ($others->reject(fn (User $user) => $user->is($author))->take(3 - $i % 3) as $voter) {
                $thread->vote($voter, Vote::UP);
            }
            if (! $comment->user->is($demo)) {
                $comment->vote($demo, Vote::UP);
            }
            if ($i < 2) {
                $thread->acceptedAnswer()->associate($comment)->save();
            }
        }
    }
}
