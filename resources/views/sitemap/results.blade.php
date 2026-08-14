<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach($results as $result)
    <url>
        <loc>{{ $result['loc'] }}</loc>
        <lastmod>{{ $result['lastmod'] }}</lastmod>
        <changefreq>{{ $result['changefreq'] }}</changefreq>
        <priority>{{ $result['priority'] }}</priority>
    </url>
@endforeach
</urlset>