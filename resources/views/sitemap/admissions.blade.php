<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach($admissions as $admission)
    <url>
        <loc>{{ $admission['loc'] }}</loc>
        <lastmod>{{ $admission['lastmod'] }}</lastmod>
        <changefreq>{{ $admission['changefreq'] }}</changefreq>
        <priority>{{ $admission['priority'] }}</priority>
    </url>
@endforeach
</urlset>