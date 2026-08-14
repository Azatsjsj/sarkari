<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach($admitCards as $admitCard)
    <url>
        <loc>{{ $admitCard['loc'] }}</loc>
        <lastmod>{{ $admitCard['lastmod'] }}</lastmod>
        <changefreq>{{ $admitCard['changefreq'] }}</changefreq>
        <priority>{{ $admitCard['priority'] }}</priority>
    </url>
@endforeach
</urlset>