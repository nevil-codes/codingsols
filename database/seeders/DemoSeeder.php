<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
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
            ['python', 'How do I read a CSV file into a pandas DataFrame?', "I have a `data.csv` file with a header row. What's the simplest way to load it?\n\n```python\nimport pandas as pd\n# ???\n```", "Use `read_csv`:\n\n```python\ndf = pd.read_csv(\"data.csv\")\nprint(df.head())\n```"],
            ['java', 'NullPointerException when calling a method on a list', "My code throws `NullPointerException` on `items.add(x)`:\n\n```java\nList<String> items;\nitems.add(\"a\");\n```", "You declared `items` but never created it. Initialize it first:\n\n```java\nList<String> items = new ArrayList<>();\n```"],
            ['javascript', 'Difference between let, const and var?', 'When should I use each one in modern JavaScript?', 'Default to `const`, use `let` when you need to reassign, and avoid `var` because it is function-scoped and hoisted.'],
            ['cpp', 'Why should I prefer std::vector over raw arrays?', 'Our course still uses `int arr[100]`. Is `std::vector` actually better?', '`std::vector` knows its size, grows on demand and frees its memory automatically. Use `std::array` when the size is fixed at compile time.'],
            ['django', 'How do I add a custom field to the Django User model?', 'I need to store a phone number for each user. Should I extend `User`?', 'For new projects, set `AUTH_USER_MODEL` to a custom model that extends `AbstractUser` before your first migration.'],
        ];

        foreach ($threads as $i => [$slug, $title, $body, $reply]) {
            $author = $i % 2 === 0 ? $demo : $others[$i % $others->count()];
            $thread = Category::where('slug', $slug)->firstOrFail()
                ->threads()->make(['title' => $title, 'body' => $body]);
            $thread->user()->associate($author);
            $thread->created_at = $thread->updated_at = now()->subHours(($i + 1) * 7);
            $thread->save();

            $comment = $thread->comments()->make(['body' => $reply]);
            $comment->user()->associate($others[($i + 1) % $others->count()]);
            $comment->created_at = $comment->updated_at = $thread->created_at->copy()->addMinutes(40);
            $comment->save();
        }
    }
}
