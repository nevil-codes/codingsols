import Alpine from 'alpinejs';
import hljs from 'highlight.js/lib/core';
import bash from 'highlight.js/lib/languages/bash';
import cpp from 'highlight.js/lib/languages/cpp';
import csharp from 'highlight.js/lib/languages/csharp';
import css from 'highlight.js/lib/languages/css';
import java from 'highlight.js/lib/languages/java';
import javascript from 'highlight.js/lib/languages/javascript';
import json from 'highlight.js/lib/languages/json';
import php from 'highlight.js/lib/languages/php';
import python from 'highlight.js/lib/languages/python';
import ruby from 'highlight.js/lib/languages/ruby';
import sql from 'highlight.js/lib/languages/sql';
import typescript from 'highlight.js/lib/languages/typescript';
import xml from 'highlight.js/lib/languages/xml';

Object.entries({ bash, cpp, csharp, css, java, javascript, json, php, python, ruby, sql, typescript, xml })
    .forEach(([name, language]) => hljs.registerLanguage(name, language));

window.highlightCode = (root = document) => {
    root.querySelectorAll('.prose pre code').forEach((block) => hljs.highlightElement(block));
};

document.addEventListener('DOMContentLoaded', () => window.highlightCode());

// Light/dark theme toggle. The initial class is set by an inline script in
// the layout head so the page never flashes the wrong theme.
Alpine.data('themeToggle', () => ({
    dark: document.documentElement.classList.contains('dark'),
    toggle() {
        this.dark = !this.dark;
        document.documentElement.classList.toggle('dark', this.dark);
        try {
            localStorage.setItem('theme', this.dark ? 'dark' : 'light');
        } catch (e) {
            // Storage unavailable (private mode); the choice lasts for this page only.
        }
    },
}));

window.Alpine = Alpine;

Alpine.start();
