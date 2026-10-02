<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Seed the forum categories carried over from the original app.
     */
    public function run(): void
    {
        $categories = [
            ['C++', 'cpp', 'cplusplus', 'C++ is a high-level, general-purpose programming language created by Bjarne Stroustrup as an extension of the C programming language, or "C with Classes".'],
            ['Flask', 'flask', 'flask', 'Flask is a micro web framework written in Python. It does not require particular tools or libraries and leaves database, form validation and similar components to third-party extensions.'],
            ['Java', 'java', 'openjdk', 'Java is a high-level, class-based, object-oriented programming language designed to have as few implementation dependencies as possible.'],
            ['Django', 'django', 'django', 'Django is a free and open-source, Python-based web framework that follows the model-template-views architectural pattern.'],
            ['Python', 'python', 'python', 'Python is a high-level, general-purpose programming language. Its design philosophy emphasizes code readability with the use of significant indentation.'],
            ['C#', 'csharp', 'dotnet', 'C# is a general-purpose, multi-paradigm programming language with static and strong typing, used across the .NET ecosystem.'],
            ['Ruby', 'ruby', 'ruby', 'Ruby is an interpreted, high-level, general-purpose programming language designed with an emphasis on programming productivity and simplicity.'],
            ['JavaScript', 'javascript', 'javascript', 'JavaScript is one of the core technologies of the web alongside HTML and CSS, running in every browser and on servers through Node.js.'],
        ];

        foreach ($categories as [$name, $slug, $icon, $description]) {
            Category::updateOrCreate(
                ['slug' => $slug],
                ['name' => $name, 'icon' => $icon, 'description' => $description],
            );
        }
    }
}
