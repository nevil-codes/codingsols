{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url><loc>{{ route('home') }}</loc></url>
    <url><loc>{{ route('tags.index') }}</loc></url>
    <url><loc>{{ route('about') }}</loc></url>
@foreach ($categories as $category)
    <url><loc>{{ route('categories.show', $category) }}</loc></url>
@endforeach
@foreach ($tags as $tag)
    <url><loc>{{ route('tags.show', $tag) }}</loc></url>
@endforeach
@foreach ($threads as $thread)
    <url><loc>{{ route('threads.show', $thread) }}</loc><lastmod>{{ $thread->last_modified->toAtomString() }}</lastmod></url>
@endforeach
</urlset>
