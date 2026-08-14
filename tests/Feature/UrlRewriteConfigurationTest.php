<?php

namespace Tests\Feature;

use Tests\TestCase;

class UrlRewriteConfigurationTest extends TestCase
{
    public function test_root_htaccess_rewrites_requests_to_public_directory(): void
    {
        $rootHtaccessPath = base_path('.htaccess');
        $publicHtaccessPath = base_path('public/.htaccess');

        $this->assertFileExists($rootHtaccessPath);
        $this->assertFileExists($publicHtaccessPath);

        $rootContent = file_get_contents($rootHtaccessPath);
        $publicContent = file_get_contents($publicHtaccessPath);

        $this->assertNotEmpty($rootContent);
        $this->assertNotEmpty($publicContent);
        $this->assertStringContainsString('RewriteEngine On', $rootContent);
        $this->assertStringContainsString('public/', $rootContent);
        $this->assertStringContainsString('FallbackResource', $rootContent);
        $this->assertStringContainsString('FallbackResource', $publicContent);
    }
}
