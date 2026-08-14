<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach($documents as $document)
    <url>
        <loc>{{ $document['loc'] }}</loc>
        <lastmod>{{ $document['lastmod'] }}</lastmod>
        <changefreq>{{ $document['changefreq'] }}</changefreq>
        <priority>{{ $document['priority'] }}</priority>
    </url>
@endforeach
</urlset>