<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach($jobs as $job)
    <url>
        <loc>{{ $job['loc'] }}</loc>
        <lastmod>{{ $job['lastmod'] }}</lastmod>
        <changefreq>{{ $job['changefreq'] }}</changefreq>
        <priority>{{ $job['priority'] }}</priority>
    </url>
@endforeach
</urlset>