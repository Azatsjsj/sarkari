<?php
// app/Services/StructuredDataGenerator.php

namespace App\Services;

class StructuredDataGenerator
{
    /**
     * Generate dynamic JSON-LD based on page type
     */
    public static function generate($pageType, $data = [])
    {
        $schema = [];
        
        switch ($pageType) {
            case 'home':
                $schema = self::websiteSchema($data);
                break;
            case 'privacy-policy':
                $schema = self::privacyPolicySchema($data);
                break;
            case 'terms-of-service':
                $schema = self::termsOfServiceSchema($data);
                break;
            case 'disclaimer':
                $schema = self::disclaimerSchema($data);
                break;
            case 'about':
                $schema = self::aboutPageSchema($data);
                break;
            case 'contact':
                $schema = self::contactPageSchema($data);
                break;
            case 'job':
                $schema = self::jobPostingSchema($data);
                break;
            case 'result':
                $schema = self::resultSchema($data);
                break;
            case 'admit-card':
                $schema = self::admitCardSchema($data);
                break;
            case 'article':
                $schema = self::articleSchema($data);
                break;
            case 'breadcrumb':
                $schema = self::breadcrumbSchema($data);
                break;
            case 'faq':
                $schema = self::faqSchema($data);
                break;
            default:
                $schema = self::webPageSchema($data);
        }
        
        return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
    }
    
    /**
     * Website / Organization Schema
     */
    private static function websiteSchema($data)
    {
        return [
            "@context" => "https://schema.org",
            "@type" => "WebSite",
            "name" => $data['site_name'] ?? "SarkariResult.Mobi",
            "url" => $data['site_url'] ?? "https://sarkariresult.mobi",
            "description" => $data['description'] ?? "India's No.1 job information portal for government exams, results, admit cards, and answer keys.",
            "potentialAction" => [
                "@type" => "SearchAction",
                "target" => [
                    "@type" => "EntryPoint",
                    "urlTemplate" => ($data['site_url'] ?? "https://sarkariresult.mobi") . "/search?q={search_term_string}"
                ],
                "query-input" => "required name=search_term_string"
            ],
            "publisher" => self::getOrganizationSchema($data)
        ];
    }
    
    /**
     * Privacy Policy Schema
     */
    private static function privacyPolicySchema($data)
    {
        return [
            "@context" => "https://schema.org",
            "@type" => "WebPage",
            "name" => "Privacy Policy",
            "description" => "Official privacy policy of " . ($data['site_name'] ?? "SarkariResult.Mobi") . " – covering data collection, cookies, GDPR rights, security measures, and grievance redressal.",
            "url" => ($data['site_url'] ?? "https://sarkariresult.mobi") . "/privacy-policy",
            "datePublished" => $data['date_published'] ?? "2025-01-15",
            "dateModified" => $data['date_modified'] ?? date('Y-m-d'),
            "publisher" => self::getOrganizationSchema($data),
            "mainEntity" => [
                "@type" => "PrivacyPolicy",
                "name" => "Privacy Policy of " . ($data['site_name'] ?? "SarkariResult.Mobi"),
                "policyText" => $data['policy_text'] ?? "This policy explains how we collect, uses, stores, and protects user data in compliance with applicable laws including GDPR, CCPA, and Indian IT Act 2000."
            ]
        ];
    }
    
    /**
     * Terms of Service Schema
     */
    private static function termsOfServiceSchema($data)
    {
        return [
            "@context" => "https://schema.org",
            "@type" => "WebPage",
            "name" => "Terms of Service",
            "description" => "Legal terms and conditions governing the use of " . ($data['site_name'] ?? "SarkariResult.Mobi") . " website and services.",
            "url" => ($data['site_url'] ?? "https://sarkariresult.mobi") . "/terms-of-service",
            "datePublished" => $data['date_published'] ?? "2025-01-15",
            "dateModified" => $data['date_modified'] ?? date('Y-m-d'),
            "publisher" => self::getOrganizationSchema($data),
            "mainEntity" => [
                "@type" => "TermsOfService",
                "name" => "Terms of Service Agreement",
                "text" => $data['terms_text'] ?? "These Terms govern your access to and use of all content, services, and features provided by our platform."
            ]
        ];
    }
    
    /**
     * Disclaimer Schema
     */
    private static function disclaimerSchema($data)
    {
        return [
            "@context" => "https://schema.org",
            "@type" => "WebPage",
            "name" => "Disclaimer",
            "description" => "Legal disclaimer regarding the accuracy, completeness, and reliability of information published on " . ($data['site_name'] ?? "SarkariResult.Mobi"),
            "url" => ($data['site_url'] ?? "https://sarkariresult.mobi") . "/disclaimer",
            "datePublished" => $data['date_published'] ?? "2025-01-20",
            "dateModified" => $data['date_modified'] ?? date('Y-m-d'),
            "publisher" => self::getOrganizationSchema($data),
            "mainEntity" => [
                "@type" => "Disclaimer",
                "name" => "Disclaimer of Liability and Warranties",
                "text" => $data['disclaimer_text'] ?? "This website provides information for general purposes only and should not be considered as official or legal advice."
            ]
        ];
    }
    
    /**
     * About Page Schema
     */
    private static function aboutPageSchema($data)
    {
        return [
            "@context" => "https://schema.org",
            "@type" => "AboutPage",
            "name" => "About Us",
            "description" => $data['description'] ?? "Learn about " . ($data['site_name'] ?? "SarkariResult.Mobi") . " - our mission, vision, and team.",
            "url" => ($data['site_url'] ?? "https://sarkariresult.mobi") . "/about",
            "datePublished" => $data['date_published'] ?? "2012-01-01",
            "dateModified" => $data['date_modified'] ?? date('Y-m-d'),
            "publisher" => self::getOrganizationSchema($data),
            "mainEntity" => self::getOrganizationSchema($data)
        ];
    }
    
    /**
     * Contact Page Schema
     */
    private static function contactPageSchema($data)
    {
        return [
            "@context" => "https://schema.org",
            "@type" => "ContactPage",
            "name" => "Contact Us",
            "description" => "Get in touch with " . ($data['site_name'] ?? "SarkariResult.Mobi") . " team for support, feedback, or inquiries.",
            "url" => ($data['site_url'] ?? "https://sarkariresult.mobi") . "/contact",
            "publisher" => self::getOrganizationSchema($data),
            "mainEntity" => [
                "@type" => "ContactPoint",
                "contactType" => "customer support",
                "email" => $data['contact_email'] ?? "support@sarkariresult.mobi",
                "telephone" => $data['contact_phone'] ?? "+91-XXXXXXXXXX",
                "availableLanguage" => ["English", "Hindi"],
                "areaServed" => "IN"
            ]
        ];
    }
    
    /**
     * Job Posting Schema
     */
    private static function jobPostingSchema($data)
    {
        return [
            "@context" => "https://schema.org",
            "@type" => "JobPosting",
            "title" => $data['job_title'] ?? "",
            "description" => $data['job_description'] ?? "",
            "datePosted" => $data['date_posted'] ?? date('Y-m-d'),
            "validThrough" => $data['last_date'] ?? "",
            "employmentType" => $data['employment_type'] ?? "FULL_TIME",
            "hiringOrganization" => [
                "@type" => "Organization",
                "name" => $data['organization'] ?? "",
                "sameAs" => $data['org_website'] ?? "",
                "logo" => $data['org_logo'] ?? ""
            ],
            "jobLocation" => [
                "@type" => "Place",
                "address" => [
                    "@type" => "PostalAddress",
                    "addressLocality" => $data['location'] ?? "India",
                    "addressCountry" => "IN"
                ]
            ],
            "applicantLocationRequirements" => [
                "@type" => "Country",
                "name" => "India"
            ],
            "baseSalary" => $data['salary'] ?? null
        ];
    }
    
    /**
     * Result / Exam Result Schema
     */
    private static function resultSchema($data)
    {
        return [
            "@context" => "https://schema.org",
            "@type" => "EducationEvent",
            "name" => $data['exam_name'] ?? "Exam Result",
            "description" => $data['description'] ?? "Check your exam results and scorecard",
            "startDate" => $data['result_date'] ?? date('Y-m-d'),
            "eventStatus" => "https://schema.org/EventScheduled",
            "eventAttendanceMode" => "https://schema.org/OnlineEventAttendanceMode",
            "location" => [
                "@type" => "VirtualLocation",
                "url" => $data['result_url'] ?? ""
            ],
            "organizer" => [
                "@type" => "Organization",
                "name" => $data['organizer'] ?? ""
            ]
        ];
    }
    
    /**
     * Admit Card Schema
     */
    private static function admitCardSchema($data)
    {
        return [
            "@context" => "https://schema.org",
            "@type" => "CreativeWork",
            "name" => $data['exam_name'] ?? "Admit Card",
            "description" => $data['description'] ?? "Download admit card / hall ticket for examination",
            "datePublished" => $data['release_date'] ?? date('Y-m-d'),
            "provider" => [
                "@type" => "Organization",
                "name" => $data['organizer'] ?? ""
            ],
            "audience" => [
                "@type" => "Audience",
                "name" => $data['exam_candidates'] ?? "Exam Candidates"
            ]
        ];
    }
    
    /**
     * Article / Blog Post Schema
     */
    private static function articleSchema($data)
    {
        return [
            "@context" => "https://schema.org",
            "@type" => "Article",
            "headline" => $data['headline'] ?? "",
            "description" => $data['description'] ?? "",
            "author" => [
                "@type" => "Person",
                "name" => $data['author'] ?? "SarkariResult Team",
                "url" => ($data['site_url'] ?? "https://sarkariresult.mobi") . "/author/" . ($data['author_slug'] ?? "")
            ],
            "publisher" => self::getOrganizationSchema($data),
            "datePublished" => $data['date_published'] ?? date('Y-m-d'),
            "dateModified" => $data['date_modified'] ?? date('Y-m-d'),
            "mainEntityOfPage" => [
                "@type" => "WebPage",
                "@id" => $data['page_url'] ?? ""
            ],
            "image" => $data['featured_image'] ?? "",
            "articleSection" => $data['category'] ?? "General",
            "keywords" => $data['keywords'] ?? ""
        ];
    }
    
    /**
     * BreadcrumbList Schema
     */
    private static function breadcrumbSchema($data)
    {
        $items = [];
        $position = 1;
        
        foreach ($data['breadcrumbs'] ?? [] as $crumb) {
            $items[] = [
                "@type" => "ListItem",
                "position" => $position,
                "name" => $crumb['name'],
                "item" => $crumb['url']
            ];
            $position++;
        }
        
        return [
            "@context" => "https://schema.org",
            "@type" => "BreadcrumbList",
            "itemListElement" => $items
        ];
    }
    
    /**
     * FAQ Schema
     */
    private static function faqSchema($data)
    {
        $questions = [];
        
        foreach ($data['faqs'] ?? [] as $faq) {
            $questions[] = [
                "@type" => "Question",
                "name" => $faq['question'],
                "acceptedAnswer" => [
                    "@type" => "Answer",
                    "text" => $faq['answer']
                ]
            ];
        }
        
        return [
            "@context" => "https://schema.org",
            "@type" => "FAQPage",
            "mainEntity" => $questions
        ];
    }
    
    /**
     * Generic WebPage Schema
     */
    private static function webPageSchema($data)
    {
        return [
            "@context" => "https://schema.org",
            "@type" => "WebPage",
            "name" => $data['page_title'] ?? "",
            "description" => $data['page_description'] ?? "",
            "url" => $data['page_url'] ?? "",
            "datePublished" => $data['date_published'] ?? date('Y-m-d'),
            "dateModified" => $data['date_modified'] ?? date('Y-m-d'),
            "publisher" => self::getOrganizationSchema($data)
        ];
    }
    
    /**
     * Organization Schema (Base/Common)
     */
    private static function getOrganizationSchema($data = [])
    {
        $siteUrl = $data['site_url'] ?? "https://sarkariresult.mobi";
        
        return [
            "@type" => "Organization",
            "name" => $data['site_name'] ?? "SarkariResult.Mobi",
            "alternateName" => "Sarkari Result",
            "url" => $siteUrl,
            "logo" => [
                "@type" => "ImageObject",
                "url" => ($data['logo_url'] ?? $siteUrl . "/images/logo.png"),
                "width" => 200,
                "height" => 60
            ],
            "sameAs" => [
                "https://www.facebook.com/SarkariResult.Mobi",
                "https://twitter.com/SarkariResult.Mobi",
                "https://www.instagram.com/sarkariresult.mobi",
                "https://www.linkedin.com/company/sarkariresult-mobi",
                "https://t.me/sarkariresult_mobi",
                "https://whatsapp.com/channel/sarkariresult"
            ],
            "contactPoint" => [
                "@type" => "ContactPoint",
                "contactType" => "customer service",
                "email" => "support@sarkariresult.mobi",
                "availableLanguage" => ["English", "Hindi"]
            ]
        ];
    }
}