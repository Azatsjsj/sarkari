<?php

namespace App\Http\Controllers;

use App\Services\StructuredDataGenerator;

class PageController extends Controller
{
    public function privacyPolicy()
    {
        $data = [
            'pageType' => 'privacy-policy',
            'pageTitle' => 'Privacy Policy',
            'pageDescription' => 'Official privacy policy of SarkariResult.Mobi',
            'structuredData' => StructuredDataGenerator::generate('privacy-policy', [
                'site_name' => 'SarkariResult.Mobi',
                'site_url' => url('/'),
                'date_modified' => now()->toDateString(),
            ]),
        ];

        return view('Privacy.privacy-policy', $data);
    }

    public function termsOfService()
    {
        return view('Privacy.tos', [
            'pageType' => 'terms-of-service',
            'structuredData' => StructuredDataGenerator::generate('terms-of-service'),
        ]);
    }

    public function disclaimer()
    {
        return view('Privacy.disclaimer', [
            'pageType' => 'disclaimer',
            'structuredData' => StructuredDataGenerator::generate('disclaimer'),
        ]);
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }
}
