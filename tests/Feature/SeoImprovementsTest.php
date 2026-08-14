<?php

namespace Tests\Feature;

use Tests\TestCase;

class SeoImprovementsTest extends TestCase
{
    public function test_robots_file_uses_live_domain_and_sitemap_url(): void
    {
        $response = $this->get('/robots.txt');

        $response->assertOk();

        $content = $response->getContent();

        $this->assertStringContainsString('https://sarkariresult.mobi/sitemap.xml', $content);
        $this->assertStringNotContainsString('127.0.0.1', $content);
    }
}
