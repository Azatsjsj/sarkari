<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach($answerKeys as $answerKey)
    <url>
        <loc>{{ $answerKey['loc'] }}</loc>
        <lastmod>{{ $answerKey['lastmod'] }}</lastmod>
        <changefreq>{{ $answerKey['changefreq'] }}</changefreq>
        <priority>{{ $answerKey['priority'] }}</priority>
    </url>
@endforeach
</urlset>