<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tag;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StarterContentSeeder extends Seeder
{
    /**
     * The account that posts the starter questions. The .invalid domain can
     * never receive mail, and the random password means nobody can log in.
     */
    public const AUTHOR_EMAIL = 'team@codingsols.invalid';

    /**
     * Seed a handful of common questions with answers, so a new forum
     * doesn't look empty.
     *
     * Only runs when there are no questions yet, so it never duplicates or
     * mixes with real content. Not part of the deploy; run it once with
     * `php artisan db:seed --class=StarterContentSeeder --force`.
     */
    public function run(): void
    {
        if (Thread::exists()) {
            $this->command?->warn('Questions already exist: skipping starter content.');

            return;
        }

        $team = User::firstOrCreate(['email' => self::AUTHOR_EMAIL], [
            'name' => 'Codingsols Team',
            'password' => Str::password(64),
        ]);
        $team->forceFill(['email_verified_at' => $team->email_verified_at ?? now()])->save();

        foreach ($this->questions() as $i => [$category, $title, $body, $answer, $tags]) {
            $thread = Category::where('slug', $category)->firstOrFail()
                ->threads()->make(['title' => $title, 'body' => $body]);
            $thread->user()->associate($team);
            // Spread over the past few days so "Latest" doesn't show them all at the same minute.
            $thread->created_at = $thread->updated_at = now()->subHours(6 * (count($this->questions()) - $i));
            $thread->save();
            $thread->tags()->sync(Tag::findOrCreateMany($tags)->modelKeys());

            $comment = $thread->comments()->make(['body' => $answer]);
            $comment->user()->associate($team);
            $comment->created_at = $comment->updated_at = $thread->created_at->copy()->addMinutes(5);
            $comment->save();

            $thread->acceptedAnswer()->associate($comment)->save();
        }

        $this->command?->info('Added '.count($this->questions()).' starter questions.');
    }

    /**
     * @return list<array{string, string, string, string, list<string>}>
     */
    private function questions(): array
    {
        return [
            [
                'python',
                'What is the difference between a list and a tuple in Python?',
                <<<'MD'
                Both hold an ordered sequence of values and both can be indexed and looped over:

                ```python
                point_list = [3, 4]
                point_tuple = (3, 4)
                ```

                When should I pick one over the other?
                MD,
                <<<'MD'
                The key difference is that **lists are mutable and tuples are not**.

                - Use a **list** for a collection that grows, shrinks or changes: items in a cart, lines read from a file.
                - Use a **tuple** for a fixed group of related values: coordinates, an RGB colour, a row returned from a database.

                Because tuples can't change, they can be used as dictionary keys and set members, while lists can't:

                ```python
                distances = {(0, 0): 0, (3, 4): 5}   # works
                distances = {[0, 0]: 0}              # TypeError: unhashable type: 'list'
                ```

                A good rule of thumb: if each position has its own meaning (`x`, `y`), it's a tuple. If every item means the same kind of thing, it's a list.
                MD,
                ['lists', 'tuples', 'data-structures'],
            ],
            [
                'python',
                'How do I create and use a virtual environment?',
                <<<'MD'
                Installing packages with `pip install` puts them in my system Python, and different projects need different versions. How do I keep each project's packages separate?
                MD,
                <<<'MD'
                Use the built-in `venv` module. In your project folder:

                ```bash
                python3 -m venv .venv          # create it once
                source .venv/bin/activate      # macOS / Linux
                .venv\Scripts\activate         # Windows
                ```

                Your prompt now shows `(.venv)`, and `pip install` only affects this project. Save and restore the exact packages with:

                ```bash
                pip freeze > requirements.txt
                pip install -r requirements.txt
                ```

                Run `deactivate` to leave it. Add `.venv/` to `.gitignore`: commit `requirements.txt`, never the environment itself.
                MD,
                ['venv', 'pip'],
            ],
            [
                'javascript',
                'Why is "this" undefined inside my callback?',
                <<<'MD'
                `this.count` works in the method but is `undefined` inside the timer:

                ```js
                class Counter {
                  count = 0;
                  start() {
                    setTimeout(function () {
                      this.count++; // TypeError: Cannot read properties of undefined
                    }, 1000);
                  }
                }
                ```
                MD,
                <<<'MD'
                A regular `function` gets its own `this`, decided by **how it is called**, not where it is written. `setTimeout` calls your function without an object, so `this` is `undefined` (in strict mode and classes).

                Use an **arrow function**. Arrow functions don't have their own `this`; they use the one from the surrounding code:

                ```js
                start() {
                  setTimeout(() => {
                    this.count++; // works: `this` is the Counter
                  }, 1000);
                }
                ```

                The same applies to event listeners and array methods like `.map()` and `.forEach()`. The older fix, `function () {...}.bind(this)`, also works but is rarely needed now.
                MD,
                ['this', 'arrow-functions', 'callbacks'],
            ],
            [
                'javascript',
                'How do I wait for several promises at once?',
                <<<'MD'
                I fetch three API endpoints one after another with `await`, and the page is slow:

                ```js
                const user = await fetch('/api/user').then(r => r.json());
                const posts = await fetch('/api/posts').then(r => r.json());
                const tags = await fetch('/api/tags').then(r => r.json());
                ```

                They don't depend on each other. Can they run at the same time?
                MD,
                <<<'MD'
                Yes. Start all of them first, then wait for them together with `Promise.all`:

                ```js
                const [user, posts, tags] = await Promise.all([
                  fetch('/api/user').then(r => r.json()),
                  fetch('/api/posts').then(r => r.json()),
                  fetch('/api/tags').then(r => r.json()),
                ]);
                ```

                The total time is now roughly the slowest request instead of the sum of all three.

                `Promise.all` rejects as soon as **any** promise fails. If you want every result even when some fail, use `Promise.allSettled`, which gives you `{ status, value }` or `{ status, reason }` for each one.
                MD,
                ['promises', 'async-await'],
            ],
            [
                'java',
                'Why does == return false when comparing two equal strings in Java?',
                <<<'MD'
                ```java
                String input = scanner.nextLine(); // user types "yes"
                if (input == "yes") {
                    System.out.println("Confirmed"); // never prints
                }
                ```
                MD,
                <<<'MD'
                For objects, `==` checks whether both variables point to **the same object in memory**, not whether they contain the same text. The string from `nextLine()` is a new object, so it's never the same object as the `"yes"` literal.

                Compare contents with `equals`:

                ```java
                if ("yes".equals(input)) {
                    System.out.println("Confirmed");
                }
                ```

                Putting the literal first avoids a `NullPointerException` if `input` is `null`. Use `equalsIgnoreCase` to accept `"YES"` too.

                You may see `==` "work" sometimes, because Java reuses identical string literals. Don't rely on it.
                MD,
                ['strings', 'equality'],
            ],
            [
                'cpp',
                'What is the difference between a pointer and a reference in C++?',
                <<<'MD'
                Both of these let a function change the caller's variable. Which one should I use?

                ```cpp
                void addOne(int* n) { (*n)++; }
                void addOne(int& n) { n++; }
                ```
                MD,
                <<<'MD'
                A **reference** is another name for an existing object. It must be initialised, can't be null and can't be changed to refer to something else.

                A **pointer** is a variable that holds an address. It can be `nullptr`, can be re-pointed, and you dereference it with `*` or `->`.

                In practice:

                - Prefer **references** for function parameters that must refer to an object: `void addOne(int& n)`. Use `const T&` to pass large objects without copying.
                - Use a **pointer** when "no object" is a valid value, or when you need to re-point it.
                - For owning memory, use `std::unique_ptr` or `std::shared_ptr` instead of raw `new`/`delete`.
                MD,
                ['pointers', 'references'],
            ],
            [
                'csharp',
                'Why does my app freeze when I use .Result on an async method?',
                <<<'MD'
                ```csharp
                private void LoadButton_Click(object sender, EventArgs e)
                {
                    var data = LoadDataAsync().Result; // the window stops responding
                    label.Text = data;
                }
                ```
                MD,
                <<<'MD'
                `.Result` (and `.Wait()`) block the current thread until the task finishes. On a UI thread that's a **deadlock**: `LoadDataAsync` wants to resume on the UI thread after its `await`, but that thread is stuck waiting for it.

                Make the caller async and `await` the task instead:

                ```csharp
                private async void LoadButton_Click(object sender, EventArgs e)
                {
                    var data = await LoadDataAsync();
                    label.Text = data;
                }
                ```

                `async void` is fine for event handlers. Everywhere else return `Task` or `Task<T>`, and let `async` flow all the way up instead of mixing blocking and async code.
                MD,
                ['async-await', 'deadlock'],
            ],
            [
                'ruby',
                'What is the difference between a symbol and a string in Ruby?',
                <<<'MD'
                Hashes in tutorials use `:name`, but I could also write `"name"`. Is there a difference?

                ```ruby
                user = { name: "Ada" }
                user = { "name" => "Ada" }
                ```
                MD,
                <<<'MD'
                A **symbol** (`:name`) is an immutable identifier, and every `:name` in your program is the same object. A **string** (`"name"`) is text that can be changed, and each literal can be a new object.

                Use symbols for names and labels: hash keys, method names, options like `sort_by(&:age)`. Use strings for data: user input, file contents, messages.

                The two key styles are **not interchangeable**:

                ```ruby
                user = { name: "Ada" }
                user[:name]   # => "Ada"
                user["name"]  # => nil
                ```

                Pick one style per hash; symbols are the usual choice.
                MD,
                ['symbols', 'strings', 'hashes'],
            ],
            [
                'django',
                'How do I stop Django from running a query for every row in my template?',
                <<<'MD'
                The debug toolbar shows over 100 queries on a page that lists 100 books:

                ```python
                books = Book.objects.all()
                ```

                ```django
                {% for book in books %}{{ book.title }} by {{ book.author.name }}{% endfor %}
                ```
                MD,
                <<<'MD'
                That's the **N+1 query problem**: one query for the books, then one more for each `book.author`. Tell Django to load the related rows up front:

                ```python
                books = Book.objects.select_related("author")
                ```

                - `select_related` is for **ForeignKey** and **OneToOne** relations. It uses a SQL join, so it's still one query.
                - `prefetch_related` is for **ManyToMany** and reverse ForeignKey relations (e.g. `author.book_set`). It runs one extra query per relation and joins the results in Python.

                ```python
                Author.objects.prefetch_related("book_set")
                ```

                The query count should now stay the same however many rows you show.
                MD,
                ['orm', 'performance', 'n-plus-one'],
            ],
            [
                'flask',
                'How do I keep my Flask secret key and database password out of my code?',
                <<<'MD'
                My `app.py` has this, and I'm about to push the project to GitHub:

                ```python
                app.config["SECRET_KEY"] = "my-secret-123"
                app.config["SQLALCHEMY_DATABASE_URI"] = "postgresql://admin:hunter2@localhost/shop"
                ```
                MD,
                <<<'MD'
                Read them from **environment variables**, so the values live on each machine and never in Git:

                ```python
                import os

                app.config["SECRET_KEY"] = os.environ["SECRET_KEY"]
                app.config["SQLALCHEMY_DATABASE_URI"] = os.environ["DATABASE_URL"]
                ```

                For local development, put them in a `.env` file, install `python-dotenv`, and Flask loads it automatically when you use `flask run`. Add `.env` to `.gitignore`, and commit a `.env.example` with empty values so others know what to set.

                Generate a strong key with `python -c "import secrets; print(secrets.token_hex(32))"`.

                If a real secret was ever committed, **change it**: it stays in the Git history even after you delete the line.
                MD,
                ['configuration', 'security', 'environment-variables'],
            ],
        ];
    }
}
