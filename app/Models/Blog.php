<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'category_id', 'content', 'featured_image',
        'additional_images', 'meta_description', 'meta_keywords',
        'focus_keyphrase', 'tags', 'status', 'published_at',
        'is_featured', 'is_breaking', 'enable_schema',
        'enable_breadcrumb', 'enable_faq', 'author_id', 'views'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'is_breaking' => 'boolean',
        'enable_schema' => 'boolean',
        'enable_breadcrumb' => 'boolean',
        'enable_faq' => 'boolean',
        'additional_images' => 'array',
    ];

    public function getMetaTags()
    {
        return [
            'title' => $this->title . ' - Sarkari Result 2026',
            'description' => $this->meta_description,
            'keywords' => $this->meta_keywords,
            'robots' => $this->status === 'published' ? 'index, follow' : 'noindex, nofollow',
            'canonical' => route('blog.show', $this->slug),
        ];
    }

    public function getOpenGraphTags()
    {
        return [
            'og:title' => $this->title,
            'og:description' => $this->meta_description,
            'og:url' => route('blog.show', $this->slug),
            'og:image' => asset('storage/' . $this->featured_image),
            'og:type' => 'article',
            'article:published_time' => $this->published_at?->toIso8601String(),
            'article:modified_time' => $this->updated_at->toIso8601String(),
            'article:section' => $this->category?->name,
            'article:tag' => explode(',', $this->tags),
        ];
    }

    public function getTwitterTags()
    {
        return [
            'twitter:card' => 'summary_large_image',
            'twitter:title' => $this->title,
            'twitter:description' => $this->meta_description,
            'twitter:image' => asset('storage/' . $this->featured_image),
        ];
    }

    public function getArticleSchema()
    {
        if (!$this->enable_schema) {
            return null;
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $this->title,
            'description' => $this->meta_description,
            'image' => asset('storage/' . $this->featured_image),
            'author' => [
                '@type' => 'Person',
                'name' => $this->author?->name ?? 'Sarkari Result',
            ],
            'datePublished' => $this->published_at?->toIso8601String(),
            'dateModified' => $this->updated_at->toIso8601String(),
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'Sarkari Result',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('images/logo.png'),
                ],
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => route('blog.show', $this->slug),
            ],
        ];
    }

    public function getBreadcrumbSchema()
    {
        if (!$this->enable_breadcrumb) {
            return null;
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'Home',
                    'item' => route('home'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => 'Blog',
                    'item' => route('blog.index'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 3,
                    'name' => $this->title,
                    'item' => route('blog.show', $this->slug),
                ],
            ],
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeBreaking($query)
    {
        return $query->where('is_breaking', true);
    }

    public function getReadingTimeAttribute()
    {
        $words = str_word_count(strip_tags($this->content));
        $minutes = ceil($words / 200);

        return $minutes . ' min read';
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
