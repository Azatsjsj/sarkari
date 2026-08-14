<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach($courses as $course)
    <url>
        <loc>{{ $course['loc'] }}</loc>
        <lastmod>{{ $course['lastmod'] }}</lastmod>
        <changefreq>{{ $course['changefreq'] }}</changefreq>
        <priority>{{ $course['priority'] }}</priority>
    </url>
@endforeach
</urlset>