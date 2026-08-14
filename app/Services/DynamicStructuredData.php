<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class DynamicStructuredData
{
    /**
     * Main method to generate structured data for any page
     */
    public function generate(): string
    {
        try {
            $pageInfo = $this->detectPageInfo();
            $schemaData = $this->buildSchemaData($pageInfo);
            $schema = $this->createSchema($pageInfo['type'], $schemaData);
            
            return $this->formatOutput($schema);
        } catch (\Throwable $e) {
            // Log error for debugging
            Log::error('Structured Data Generation Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return $this->getFallbackSchema();
        }
    }

    /**
     * Detect page type and get data from URL
     */
    private function detectPageInfo(): array
    {
        $path = Request::path();
        $fullUrl = Request::url();
        $segments = explode('/', trim($path, '/'));
        $lastSegment = !empty($segments) ? end($segments) : '';
        
        // Page type detection patterns
        $patterns = [
            'job' => ['job', 'jobs', 'recruitment', 'vacancy', 'apply'],
            'result' => ['result', 'results', 'score', 'marks'],
            'admit-card' => ['admit-card', 'admitcard', 'admit', 'hall-ticket', 'call-letter'],
            'answer-key' => ['answer-key', 'answerkey', 'answer', 'solution'],
            'category' => ['category', 'categories'],
            'document' => ['document', 'documents', 'notice', 'notification', 'circular', 'order'],
        ];
        
        $pageType = 'home';
        $pageData = [];
        
        // Detect by URL pattern
        foreach ($patterns as $type => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($path, $keyword)) {
                    $pageType = $type;
                    break 2;
                }
            }
        }
        
        // Get page data based on type
        switch ($pageType) {
            case 'job':
                $pageData = $this->getJobData($lastSegment);
                break;
            case 'result':
                $pageData = $this->getResultData($lastSegment);
                break;
            case 'admit-card':
                $pageData = $this->getAdmitCardData($lastSegment);
                break;
            case 'answer-key':
                $pageData = $this->getAnswerKeyData($lastSegment);
                break;
            case 'category':
                $pageData = $this->getCategoryData($lastSegment);
                break;
            case 'document':
                $pageData = $this->getDocumentData($lastSegment);
                break;
            default:
                $pageData = $this->getHomePageData();
        }
        
        return [
            'type' => $pageType,
            'slug' => $lastSegment,
            'url' => $fullUrl,
            'data' => $pageData,
        ];
    }

    /**
     * Get job data dynamically from database or URL
     */
    private function getJobData($slug): array
    {
        if (empty($slug)) {
            return $this->getDefaultJobData();
        }
        
        // Try to get from cache
        $cacheKey = 'job_data_' . $slug;
        
        return Cache::remember($cacheKey, 3600, function () use ($slug) {
            // Method 1: Try from database
            if ($this->tableExists('jobs')) {
                try {
                    $job = DB::table('jobs')
                        ->where('slug', $slug)
                        ->orWhere('id', $slug)
                        ->orWhere('title', 'like', $slug . '%')
                        ->first();
                    
                    if ($job) {
                        return [
                            'title' => $job->title ?? '',
                            'description' => $job->description ?? $job->short_description ?? '',
                            'organization' => $job->organization ?? $job->organization_name ?? '',
                            'location' => $job->location ?? 'India',
                            'last_date' => $job->last_date ?? null,
                            'created_at' => $job->created_at ?? now(),
                            'salary_min' => $job->salary_min ?? null,
                            'salary_max' => $job->salary_max ?? null,
                            'qualification' => $job->qualification ?? '',
                            'experience' => $job->experience ?? '',
                            'total_posts' => $job->total_posts ?? null,
                            'employment_type' => $job->employment_type ?? 'FULL_TIME',
                        ];
                    }
                } catch (\Exception $e) {
                    Log::warning('Job query failed: ' . $e->getMessage());
                }
            }
            
            // Method 2: Extract from page content
            return $this->extractFromPageContent('job', $slug);
        });
    }

    /**
     * Get default job data when slug is empty
     */
    private function getDefaultJobData(): array
    {
        return [
            'title' => 'Government Job Opportunities',
            'description' => 'Latest government job vacancies and recruitment notifications',
            'organization' => 'Government of India',
            'location' => 'India',
            'last_date' => now()->addDays(30),
            'created_at' => now(),
            'salary_min' => null,
            'salary_max' => null,
            'qualification' => 'As per notification',
            'experience' => 'Freshers can apply',
            'total_posts' => null,
            'employment_type' => 'FULL_TIME',
        ];
    }

    /**
     * Get result data dynamically
     */
    private function getResultData($slug): array
    {
        if (empty($slug)) {
            return $this->getDefaultResultData();
        }
        
        $cacheKey = 'result_data_' . $slug;
        
        return Cache::remember($cacheKey, 3600, function () use ($slug) {
            if ($this->tableExists('results')) {
                try {
                    $result = DB::table('results')
                        ->where('slug', $slug)
                        ->orWhere('id', $slug)
                        ->orWhere('title', 'like', $slug . '%')
                        ->first();
                    
                    if ($result) {
                        return [
                            'title' => $result->title ?? '',
                            'description' => $result->description ?? '',
                            'exam_name' => $result->exam_name ?? $result->title ?? '',
                            'result_date' => $result->result_date ?? $result->declared_date ?? now(),
                            'organization' => $result->organization ?? '',
                        ];
                    }
                } catch (\Exception $e) {
                    Log::warning('Result query failed: ' . $e->getMessage());
                }
            }
            
            return $this->extractFromPageContent('result', $slug);
        });
    }

    /**
     * Get default result data
     */
    private function getDefaultResultData(): array
    {
        return [
            'title' => 'Exam Results',
            'description' => 'Latest examination results and scorecards',
            'exam_name' => 'Government Exam',
            'result_date' => now(),
            'organization' => 'Government Organization',
        ];
    }

    /**
     * Get admit card data dynamically
     */
    private function getAdmitCardData($slug): array
    {
        if (empty($slug)) {
            return $this->getDefaultAdmitCardData();
        }
        
        $cacheKey = 'admit_card_data_' . $slug;
        
        return Cache::remember($cacheKey, 3600, function () use ($slug) {
            if ($this->tableExists('admit_cards')) {
                try {
                    $admitCard = DB::table('admit_cards')
                        ->where('slug', $slug)
                        ->orWhere('id', $slug)
                        ->orWhere('title', 'like', $slug . '%')
                        ->first();
                    
                    if ($admitCard) {
                        return [
                            'title' => $admitCard->title ?? '',
                            'description' => $admitCard->description ?? '',
                            'exam_name' => $admitCard->exam_name ?? $admitCard->title ?? '',
                            'release_date' => $admitCard->release_date ?? $admitCard->exam_date ?? now(),
                            'exam_date' => $admitCard->exam_date ?? null,
                            'organization' => $admitCard->organization ?? '',
                        ];
                    }
                } catch (\Exception $e) {
                    Log::warning('Admit card query failed: ' . $e->getMessage());
                }
            }
            
            return $this->extractFromPageContent('admit-card', $slug);
        });
    }

    /**
     * Get default admit card data
     */
    private function getDefaultAdmitCardData(): array
    {
        return [
            'title' => 'Admit Card',
            'description' => 'Download admit card for upcoming examinations',
            'exam_name' => 'Government Exam',
            'release_date' => now(),
            'exam_date' => now()->addDays(15),
            'organization' => 'Government Organization',
        ];
    }

    /**
     * Get answer key data dynamically
     */
    private function getAnswerKeyData($slug): array
    {
        if (empty($slug)) {
            return $this->getDefaultAnswerKeyData();
        }
        
        $cacheKey = 'answer_key_data_' . $slug;
        
        return Cache::remember($cacheKey, 3600, function () use ($slug) {
            if ($this->tableExists('answer_keys')) {
                try {
                    $answerKey = DB::table('answer_keys')
                        ->where('title', 'like', $slug . '%')
                        ->orWhere('id', $slug)
                        ->orWhere('title', 'like', '%' . $slug . '%')
                        ->first();
                    
                    if ($answerKey) {
                        return [
                            'title' => $answerKey->title ?? '',
                            'description' => $answerKey->description ?? '',
                            'exam_name' => $answerKey->exam_name ?? $answerKey->title ?? '',
                            'release_date' => $answerKey->release_date ?? now(),
                            'organization' => $answerKey->organization ?? '',
                        ];
                    }
                } catch (\Exception $e) {
                    Log::warning('Answer key query failed: ' . $e->getMessage());
                }
            }
            
            return $this->extractFromPageContent('answer-key', $slug);
        });
    }

    /**
     * Get default answer key data
     */
    private function getDefaultAnswerKeyData(): array
    {
        return [
            'title' => 'Answer Key',
            'description' => 'Official answer key for examinations',
            'exam_name' => 'Government Exam',
            'release_date' => now(),
            'organization' => 'Government Organization',
        ];
    }
    
    /**
     * Get document data dynamically from database or URL
     */
    private function getDocumentData($slug): array
    {
        if (empty($slug)) {
            return $this->getDefaultDocumentData();
        }
        
        $cacheKey = 'document_data_' . $slug;
        
        return Cache::remember($cacheKey, 3600, function () use ($slug) {
            // Method 1: Try from database
            if ($this->tableExists('documents')) {
                try {
                    $document = DB::table('documents')
                        ->where('title', 'like', $slug . '%')
                        ->orWhere('id', $slug)
                        ->orWhere('title', 'like', '%' . $slug . '%')
                        ->first();
                    
                    if ($document) {
                        return [
                            'title' => $document->title ?? '',
                            'description' => $document->description ?? $document->short_description ?? '',
                            'document_number' => $document->document_number ?? null,
                            'type' => $document->type ?? 'notice',
                            'issue_date' => $document->issue_date ?? null,
                            'valid_upto' => $document->valid_upto ?? null,
                            'department' => $document->department ?? '',
                            'issued_by' => $document->issued_by ?? '',
                            'file_path' => $document->file_path ?? '',
                            'file_size' => $document->file_size ?? null,
                            'download_count' => $document->download_count ?? 0,
                            'created_at' => $document->created_at ?? now(),
                            'updated_at' => $document->updated_at ?? now(),
                        ];
                    }
                } catch (\Exception $e) {
                    Log::warning('Document query failed: ' . $e->getMessage());
                }
            }
            
            return $this->extractDocumentFromPageContent($slug);
        });
    }
    
    /**
     * Get default document data
     */
    private function getDefaultDocumentData(): array
    {
        return [
            'title' => 'Government Document',
            'description' => 'Official government document and notifications',
            'document_number' => null,
            'type' => 'notice',
            'issue_date' => now(),
            'valid_upto' => now()->addYear(),
            'department' => 'Government of India',
            'issued_by' => 'Competent Authority',
            'file_path' => null,
            'file_size' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
    
    /**
     * Extract document data from page content as fallback
     */
    private function extractDocumentFromPageContent($slug): array
    {
        $title = $this->getPageTitle();
        $description = $this->getPageDescription();
        
        return [
            'title' => $title ?: ucwords(str_replace('-', ' ', $slug)),
            'description' => $description ?: "Official government document - " . ucwords(str_replace('-', ' ', $slug)),
            'document_number' => null,
            'type' => 'document',
            'issue_date' => now(),
            'valid_upto' => now()->addYear(),
            'department' => 'Government of India',
            'issued_by' => 'Competent Authority',
            'file_path' => null,
            'file_size' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Get category data dynamically
     */
    private function getCategoryData($slug): array
    {
        if (empty($slug)) {
            return $this->getDefaultCategoryData();
        }
        
        $cacheKey = 'category_data_' . $slug;
        
        return Cache::remember($cacheKey, 3600, function () use ($slug) {
            if ($this->tableExists('categories')) {
                try {
                    $category = DB::table('categories')
                        ->where('title', 'like', $slug . '%')
                        ->orWhere('name', $slug)
                        ->first();
                    
                    if ($category) {
                        return [
                            'name' => $category->name ?? '',
                            'description' => $category->description ?? '',
                            'slug' => $category->slug ?? $slug,
                        ];
                    }
                } catch (\Exception $e) {
                    Log::warning('Category query failed: ' . $e->getMessage());
                }
            }
            
            return [
                'name' => ucwords(str_replace('-', ' ', $slug)),
                'description' => 'Latest government jobs in ' . ucwords(str_replace('-', ' ', $slug)) . ' category',
                'slug' => $slug,
            ];
        });
    }

    /**
     * Get default category data
     */
    private function getDefaultCategoryData(): array
    {
        return [
            'name' => 'Government Jobs',
            'description' => 'Latest government job categories and opportunities',
            'slug' => 'jobs',
        ];
    }

    /**
     * Get home page data
     */
    private function getHomePageData(): array
    {
        return [
            'title' => 'Sarkari Result 2026',
            'description' => 'Latest Sarkari Result 2026, Government Jobs, Admit Card, Results, Answer Keys',
            'site_name' => config('app.name', 'Sarkari Result'),
        ];
    }

    /**
     * Extract data from page content as fallback
     */
    private function extractFromPageContent($type, $slug): array
    {
        $title = $this->getPageTitle();
        $description = $this->getPageDescription();
        
        $defaultData = [
            'title' => $title ?: ucwords(str_replace('-', ' ', $slug)),
            'description' => $description ?: "Latest " . $type . " information and updates",
            'organization' => 'Government Organization',
            'location' => 'India',
            'created_at' => now(),
            'employment_type' => 'FULL_TIME',
        ];
        
        if ($type === 'job') {
            $defaultData['last_date'] = now()->addDays(30);
            $defaultData['qualification'] = 'As per notification';
        }
        
        if ($type === 'result' || $type === 'admit-card' || $type === 'answer-key') {
            $defaultData['exam_name'] = $defaultData['title'];
            $defaultData['release_date'] = now();
        }
        
        return $defaultData;
    }

    /**
     * Build schema data array
     */
    private function buildSchemaData($pageInfo): array
    {
        $data = $pageInfo['data'];
        $url = $pageInfo['url'];
        $type = $pageInfo['type'];
        
        $baseData = [
            'site_name' => config('app.name', 'Sarkari Result'),
            'site_url' => config('app.url', url('/')),
            'page_title' => $data['title'] ?? $this->getPageTitle() ?? 'Sarkari Result',
            'page_description' => $data['description'] ?? $this->getPageDescription() ?? '',
            'page_url' => $url,
            'date_modified' => now()->toDateString(),
            'breadcrumbs' => $this->generateBreadcrumbs($type, $data['title'] ?? ''),
        ];
        
        switch ($type) {
            case 'job':
                return array_merge($baseData, [
                    'job_title' => $data['title'] ?? '',
                    'job_description' => $data['description'] ?? '',
                    'organization' => $data['organization'] ?? '',
                    'location' => $data['location'] ?? 'India',
                    'last_date' => $this->formatDate($data['last_date'] ?? null),
                    'date_posted' => $this->formatDate($data['created_at'] ?? now()),
                    'salary_min' => $data['salary_min'] ?? null,
                    'salary_max' => $data['salary_max'] ?? null,
                    'qualification' => $data['qualification'] ?? '',
                    'experience' => $data['experience'] ?? '',
                    'employment_type' => $data['employment_type'] ?? 'FULL_TIME',
                    'total_posts' => $data['total_posts'] ?? null,
                    'job_url' => $url,
                    'faqs' => $this->getFaqs('job'),
                ]);
                
            case 'result':
                return array_merge($baseData, [
                    'exam_name' => $data['exam_name'] ?? $data['title'] ?? '',
                    'description' => $data['description'] ?? '',
                    'result_date' => $this->formatDate($data['result_date'] ?? now()),
                    'result_url' => $url,
                    'faqs' => $this->getFaqs('result'),
                ]);
                
            case 'admit-card':
                return array_merge($baseData, [
                    'exam_name' => $data['exam_name'] ?? $data['title'] ?? '',
                    'description' => $data['description'] ?? '',
                    'release_date' => $this->formatDate($data['release_date'] ?? now()),
                    'exam_date' => $this->formatDate($data['exam_date'] ?? null),
                    'admit_card_url' => $url,
                    'faqs' => $this->getFaqs('admit-card'),
                ]);
                
            case 'answer-key':
                return array_merge($baseData, [
                    'exam_name' => $data['exam_name'] ?? $data['title'] ?? '',
                    'description' => $data['description'] ?? '',
                    'release_date' => $this->formatDate($data['release_date'] ?? now()),
                    'result_url' => $url,
                    'faqs' => $this->getFaqs('answer-key'),
                ]);
                
            case 'document':
                return array_merge($baseData, [
                    'document_title' => $data['title'] ?? '',
                    'document_description' => $data['description'] ?? '',
                    'document_number' => $data['document_number'] ?? null,
                    'document_type' => $data['type'] ?? 'notice',
                    'issue_date' => $this->formatDate($data['issue_date'] ?? null),
                    'valid_upto' => $this->formatDate($data['valid_upto'] ?? null),
                    'department' => $data['department'] ?? '',
                    'issued_by' => $data['issued_by'] ?? '',
                    'file_url' => isset($data['file_path']) && $data['file_path'] ? asset('storage/' . $data['file_path']) : null,
                    'file_size' => $data['file_size'] ?? null,
                    'download_count' => $data['download_count'] ?? 0,
                    'date_published' => $this->formatDate($data['issue_date'] ?? $data['created_at'] ?? null),
                    'faqs' => $this->getFaqs('document'),
                ]);
                
            case 'category':
                return array_merge($baseData, [
                    'category_name' => $data['name'] ?? '',
                    'category_description' => $data['description'] ?? '',
                ]);
                
            default:
                return array_merge($baseData, [
                    'faqs' => $this->getFaqs('home'),
                ]);
        }
    }

    /**
     * Create final schema JSON
     */
    private function createSchema($type, $data): array
    {
        $schemas = [];
        
        // Add main schema based on type
        switch ($type) {
            case 'job':
                $schemas[] = $this->createJobSchema($data);
                break;
            case 'result':
                $schemas[] = $this->createResultSchema($data);
                break;
            case 'admit-card':
                $schemas[] = $this->createAdmitCardSchema($data);
                break;
            case 'answer-key':
                $schemas[] = $this->createAnswerKeySchema($data);
                break;
            case 'document':
                $schemas[] = $this->createDocumentSchema($data);
                break;
            case 'category':
                $schemas[] = $this->createCategorySchema($data);
                break;
            default:
                $schemas[] = $this->createWebSiteSchema($data);
        }
        
        // Add breadcrumb if exists
        $breadcrumb = $this->createBreadcrumbSchema($data);
        if (!empty($breadcrumb)) {
            $schemas[] = $breadcrumb;
        }
        
        // Add FAQ if exists
        $faq = $this->createFaqSchema($data);
        if (!empty($faq)) {
            $schemas[] = $faq;
        }
        
        // Add organization schema
        $schemas[] = $this->createOrganizationSchema($data);
        
        return $schemas;
    }

    /**
     * Create JobPosting schema
     */
    private function createJobSchema($data): array
    {
        $schema = [
            "@type" => "JobPosting",
            "title" => $this->sanitize($data['job_title'] ?? ''),
            "description" => $this->sanitize(substr($data['job_description'] ?? '', 0, 5000)),
            "datePosted" => $data['date_posted'] ?? date('Y-m-d'),
            "validThrough" => $data['last_date'] ?? date('Y-m-d', strtotime('+30 days')),
            "employmentType" => $data['employment_type'] ?? 'FULL_TIME',
            "hiringOrganization" => [
                "@type" => "Organization",
                "@id" => url('/') . "#organization",
                "name" => "Government Organization",
            ],
            "jobLocation" => [
                "@type" => "Place",
                "address" => [
                    "@type" => "PostalAddress",
                    "addressLocality" => $this->sanitize($data['location'] ?? 'India'),
                    "addressCountry" => "IN"
                ]
            ],
            "url" => $data['job_url'] ?? $data['page_url'] ?? '',
            "identifier" => [
                "@type" => "PropertyValue",
                "name" => $data['organization'] ?? 'Government Job',
                "value" => md5($data['job_url'] ?? '')
            ],
            "applicantLocationRequirements" => [
                "@type" => "Country",
                "name" => "India"
            ]
        ];
        
        // Add salary if exists
        if (!empty($data['salary_min']) || !empty($data['salary_max'])) {
            $schema["baseSalary"] = [
                "@type" => "MonetaryAmount",
                "currency" => "INR",
                "value" => [
                    "@type" => "QuantitativeValue",
                    "minValue" => (float)($data['salary_min'] ?? 0),
                    "maxValue" => (float)($data['salary_max'] ?? $data['salary_min'] ?? 0),
                    "unitText" => "MONTH"
                ]
            ];
        }
        
        // Add optional fields
        if (!empty($data['qualification'])) {
            $schema["educationRequirements"] = $this->sanitize($data['qualification']);
        }
        
        if (!empty($data['experience'])) {
            $schema["experienceRequirements"] = $this->sanitize($data['experience']);
        }
        
        return $schema;
    }

    /**
     * Create Result schema
     */
    private function createResultSchema($data): array
    {
        return [
            "@type" => "Article",
            "headline" => $this->sanitize(($data['exam_name'] ?? 'Exam') . ' Result ' . date('Y')),
            "description" => $this->sanitize($data['description'] ?? ''),
            "datePublished" => $data['result_date'] ?? date('Y-m-d'),
            "dateModified" => date('Y-m-d'),
            "author" => [
                "@type" => "Organization",
                "name" => "Sarkari Result"
            ],
            "publisher" => [
                "@type" => "Organization",
                "name" => "Sarkari Result"
            ],
            "mainEntityOfPage" => [
                "@type" => "WebPage",
                "@id" => $data['result_url'] ?? $data['page_url'] ?? url('/')
            ]
        ];
    }

    /**
     * Create Admit Card schema
     */
    private function createAdmitCardSchema($data): array
    {
        return [
            "@type" => "Article",
            "headline" => $this->sanitize(($data['exam_name'] ?? 'Exam') . ' Admit Card ' . date('Y')),
            "description" => $this->sanitize($data['description'] ?? ''),
            "datePublished" => $data['release_date'] ?? date('Y-m-d'),
            "publisher" => [
                "@type" => "Organization",
                "name" => "Sarkari Result"
            ],
            "mainEntityOfPage" => [
                "@type" => "WebPage",
                "@id" => $data['admit_card_url'] ?? $data['page_url'] ?? url('/')
            ]
        ];
    }

    /**
     * Create Answer Key schema
     */
    private function createAnswerKeySchema($data): array
    {
        return [
            "@type" => "Article",
            "headline" => $this->sanitize(($data['exam_name'] ?? 'Exam') . ' Answer Key ' . date('Y')),
            "description" => $this->sanitize($data['description'] ?? ''),
            "datePublished" => $data['release_date'] ?? date('Y-m-d'),
            "publisher" => [
                "@type" => "Organization",
                "name" => "Sarkari Result"
            ],
            "mainEntityOfPage" => [
                "@type" => "WebPage",
                "@id" => $data['result_url'] ?? $data['page_url'] ?? url('/')
            ]
        ];
    }

    /**
     * Create Document schema (CreativeWork)
     */
    private function createDocumentSchema($data): array
    {
        $schema = [
            "@type" => "CreativeWork",
            "name" => $this->sanitize($data['document_title'] ?? ''),
            "description" => $this->sanitize(substr($data['document_description'] ?? '', 0, 5000)),
            "url" => $data['page_url'] ?? '',
            "datePublished" => $data['date_published'] ?? date('Y-m-d'),
            "dateModified" => $data['date_modified'] ?? date('Y-m-d'),
            "inLanguage" => "en-IN",
            "author" => [
                "@type" => "Organization",
                "name" => $this->sanitize($data['issued_by'] ?? $data['department'] ?? 'Sarkari Result')
            ],
            "publisher" => [
                "@type" => "Organization",
                "name" => "Sarkari Result",
                "url" => url('/')
            ]
        ];
        
        // Add identifier if exists
        if (!empty($data['document_number'])) {
            $schema["identifier"] = [
                "@type" => "PropertyValue",
                "name" => "Document Number",
                "value" => $this->sanitize($data['document_number'])
            ];
        }
        
        // Add version/type
        if (!empty($data['document_type'])) {
            $schema["version"] = ucfirst($this->sanitize($data['document_type']));
        }
        
        // Add keywords
        $schema["keywords"] = $this->sanitize(($data['document_title'] ?? '') . ', Government Document, Sarkari Result, ' . ($data['department'] ?? ''));
        
        return $schema;
    }
    
    /**
     * Create Category schema
     */
    private function createCategorySchema($data): array
    {
        return [
            "@type" => "CollectionPage",
            "name" => $this->sanitize($data['category_name'] ?? 'Category'),
            "description" => $this->sanitize($data['category_description'] ?? ''),
            "url" => $data['page_url'] ?? '',
            "publisher" => [
                "@type" => "Organization",
                "name" => "Sarkari Result"
            ]
        ];
    }

    /**
     * Create WebSite schema
     */
    private function createWebSiteSchema($data): array
    {
        return [
            "@type" => "WebSite",
            "name" => $data['site_name'] ?? 'Sarkari Result',
            "url" => $data['site_url'] ?? url('/'),
            "description" => $this->sanitize($data['page_description'] ?? ''),
            "potentialAction" => [
                "@type" => "SearchAction",
                "target" => [
                    "@type" => "EntryPoint",
                    "urlTemplate" => url('/jobs?search={search_term_string}')
                ],
                "query-input" => "required name=search_term_string"
            ]
        ];
    }

    /**
     * Create Breadcrumb schema
     */
    private function createBreadcrumbSchema($data): array
    {
        if (empty($data['breadcrumbs'])) {
            return [];
        }
        
        $items = [];
        $position = 1;
        $total = count($data['breadcrumbs']);
        
        foreach ($data['breadcrumbs'] as $crumb) {
            if (empty($crumb['name'])) {
                continue;
            }
            
            $item = [
                "@type" => "ListItem",
                "position" => $position,
                "name" => $this->sanitize($crumb['name'])
            ];
            
            if (!empty($crumb['url']) && $position < $total) {
                $item['item'] = $crumb['url'];
            }
            
            $items[] = $item;
            $position++;
        }
        
        if (empty($items)) {
            return [];
        }
        
        return [
            "@type" => "BreadcrumbList",
            "itemListElement" => $items
        ];
    }

    /**
     * Create FAQ schema
     */
    private function createFaqSchema($data): array
    {
        if (empty($data['faqs'])) {
            return [];
        }
        
        $faqs = [];
        foreach (array_slice($data['faqs'], 0, 10) as $faq) {
            if (empty($faq['question']) || empty($faq['answer'])) {
                continue;
            }
            
            $faqs[] = [
                "@type" => "Question",
                "name" => $this->sanitize($faq['question']),
                "acceptedAnswer" => [
                    "@type" => "Answer",
                    "text" => $this->sanitize($faq['answer'])
                ]
            ];
        }
        
        if (empty($faqs)) {
            return [];
        }
        
        return [
            "@type" => "FAQPage",
            "mainEntity" => $faqs
        ];
    }

    /**
     * Create Organization schema
     */
    private function createOrganizationSchema($data): array
    {
        $schema = [
            "@type" => "Organization",
            "name" => "Sarkari Result",
            "alternateName" => "www.sarkariresult.mobi",
            "url" => url('/'),
            "logo" => [
                "@type" => "ImageObject",
                "url" => asset('/images/logo.png'),
                "width" => 200,
                "height" => 60
            ]
        ];
        
        // Add social links
        $socialLinks = [
            "https://www.facebook.com/sarkariresultmobi",
            "https://twitter.com/sarkariresultmobi",
            "https://t.me/sarkariresultofficialmobi"
        ];
        
        $schema["sameAs"] = $socialLinks;
        
        return $schema;
    }

    /**
     * Generate breadcrumbs dynamically
     */
    private function generateBreadcrumbs($type, $currentPage): array
    {
        $breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
        ];
        
        $typeMapping = [
            'job' => ['name' => 'Government Jobs', 'url' => url('/jobs')],
            'result' => ['name' => 'Results', 'url' => url('/results')],
            'admit-card' => ['name' => 'Admit Cards', 'url' => url('/admit-cards')],
            'answer-key' => ['name' => 'Answer Keys', 'url' => url('/answer-keys')],
            'category' => ['name' => 'Categories', 'url' => url('/categories')],
            'document' => ['name' => 'Documents', 'url' => url('/documents')],
        ];
        
        if (isset($typeMapping[$type])) {
            $breadcrumbs[] = $typeMapping[$type];
        }
        
        if (!empty($currentPage)) {
            $breadcrumbs[] = ['name' => $currentPage, 'url' => null];
        }
        
        return $breadcrumbs;
    }

    /**
     * Get FAQs based on page type
     */
    private function getFaqs($type): array
    {
        $faqs = [
            'home' => [
                ['question' => 'What is Sarkari Result?', 'answer' => 'Sarkari Result is a platform providing latest government job notifications, results, admit cards and answer keys.'],
                ['question' => 'How to get job alerts?', 'answer' => 'Subscribe to our Telegram channel or WhatsApp channel for instant job alerts.'],
                ['question' => 'Is Sarkari Result free?', 'answer' => 'Yes, Sarkari Result is completely free to use.'],
            ],
            'job' => [
                ['question' => 'What is the last date to apply?', 'answer' => 'Please check the official notification for exact last date.'],
                ['question' => 'What is the eligibility criteria?', 'answer' => 'Eligibility varies by post. Check official notification for details.'],
                ['question' => 'How to apply for this job?', 'answer' => 'Apply online through official website link provided in the notification.'],
            ],
            'result' => [
                ['question' => 'How to check result?', 'answer' => 'Click on the result link and enter your roll number/registration number.'],
                ['question' => 'When was the result declared?', 'answer' => 'Result was declared on the date mentioned above.'],
            ],
            'admit-card' => [
                ['question' => 'How to download admit card?', 'answer' => 'Click on download link and enter your registration number and date of birth.'],
                ['question' => 'What to carry to exam center?', 'answer' => 'Carry admit card printout and valid ID proof.'],
            ],
            'answer-key' => [
                ['question' => 'How to download answer key?', 'answer' => 'Click on the answer key link to download PDF.'],
                ['question' => 'How to raise objection?', 'answer' => 'Follow instructions in official notification for objection submission.'],
            ],
            'document' => [
                ['question' => 'What is this document about?', 'answer' => 'This is an official government document issued by the concerned authority.'],
                ['question' => 'How to download this document?', 'answer' => 'Click on the Download button to save the document to your device.'],
                ['question' => 'Is this document official?', 'answer' => 'Yes, this is an official document from the government department.'],
                ['question' => 'Can I share this document?', 'answer' => 'Yes, you can share this document using the share buttons provided.'],
            ],
        ];
        
        return $faqs[$type] ?? $faqs['home'];
    }

    /**
     * Get page title from meta or generate
     */
    private function getPageTitle(): ?string
    {
        // Try to get from view shared data
        if (isset($GLOBALS['pageTitle'])) {
            return $GLOBALS['pageTitle'];
        }
        
        // Try to get from HTML title tag (only if we're in a view context)
        if (function_exists('view') && view()->getshared('pageTitle', null)) {
            return view()->shared('pageTitle');
        }
        
        return null;
    }

    /**
     * Get page description from meta
     */
    private function getPageDescription(): ?string
    {
        if (isset($GLOBALS['pageDescription'])) {
            return $GLOBALS['pageDescription'];
        }
        
        // Try to get from view shared data
        if (function_exists('view') && view()->getshared('pageDescription', null)) {
            return view()->shared('pageDescription');
        }
        
        return null;
    }

    /**
     * Check if table exists in database
     */
    private function tableExists($table): bool
    {
        try {
            return Schema::hasTable($table);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Format date for schema
     */
    private function formatDate($date): string
    {
        if (empty($date)) {
            return date('Y-m-d');
        }
        
        if ($date instanceof \DateTime || $date instanceof Carbon) {
            return $date->format('Y-m-d');
        }
        
        if (is_string($date)) {
            try {
                $timestamp = strtotime($date);
                if ($timestamp === false) {
                    return date('Y-m-d');
                }
                return date('Y-m-d', $timestamp);
            } catch (\Exception $e) {
                return date('Y-m-d');
            }
        }
        
        return date('Y-m-d');
    }

    /**
     * Sanitize text for JSON
     */
    private function sanitize($text): string
    {
        if (empty($text)) {
            return '';
        }
        
        if (!is_string($text)) {
            $text = (string)$text;
        }
        
        // Strip HTML tags
        $text = strip_tags($text);
        // Remove excessive whitespace
        $text = preg_replace('/\s+/', ' ', $text);
        // Trim
        $text = trim($text);
        // Escape HTML special characters
        $text = htmlspecialchars($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        
        return $text;
    }

    /**
     * Format output JSON-LD
     */
    private function formatOutput($schemas): string
    {
        if (empty($schemas)) {
            return $this->getFallbackSchema();
        }
        
        $output = [
            "@context" => "https://schema.org",
            "@graph" => $schemas
        ];
        
        $json = json_encode($output, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        
        // Check if JSON encoding failed
        if ($json === false) {
            Log::error('JSON encoding failed for structured data');
            return $this->getFallbackSchema();
        }
        
        return '<script type="application/ld+json">' . "\n" .
            $json .
            "\n" . '</script>' . "\n";
    }

    /**
     * Get fallback schema
     */
    private function getFallbackSchema(): string
    {
        $fallback = [
            "@context" => "https://schema.org",
            "@type" => "WebSite",
            "name" => config('app.name', 'Sarkari Result'),
            "url" => url('/'),
            "description" => "Latest Sarkari Result 2026, Government Jobs, Admit Card, Results Updates"
        ];
        
        $json = json_encode($fallback, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        
        if ($json === false) {
            return '';
        }
        
        return '<script type="application/ld+json">' . "\n" .
            $json .
            "\n" . '</script>' . "\n";
    }
}