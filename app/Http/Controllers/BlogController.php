<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $query = Blog::with(['category', 'author'])
            ->published()
            ->latest('published_at');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('tags', 'like', "%{$search}%");
            });
        }

        $blogs = $query->paginate(12)->withQueryString();
        $featuredBlogs = Blog::published()->featured()->latest('published_at')->take(5)->get();

        return view('blog.index', compact('blogs', 'featuredBlogs'));
    }

    public function show(string $slug): View
    {
        $blog = Blog::with(['category', 'author'])
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        $relatedArticles = Blog::published()
            ->where('id', '!=', $blog->id)
            ->when($blog->category_id, fn ($q) => $q->where('category_id', $blog->category_id))
            ->latest('published_at')
            ->take(6)
            ->get();

        return view('blog.show', compact('blog', 'relatedArticles'));
    }

    public function trackView(string $slug)
    {
        $blog = Blog::where('slug', $slug)->published()->first();

        if ($blog) {
            $blog->increment('views');
        }

        return response()->json(['success' => true]);
    }

    public function category(string $slug): View
    {
        $category = Category::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $blogs = Blog::with(['category', 'author'])
            ->published()
            ->where('category_id', $category->id)
            ->latest('published_at')
            ->paginate(12);

        $featuredBlogs = Blog::published()
            ->where('category_id', $category->id)
            ->featured()
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('blog.index', compact('blogs', 'featuredBlogs', 'category'));
    }

    public function tag(string $tag): View
    {
        $blogs = Blog::with(['category', 'author'])
            ->published()
            ->where('tags', 'like', "%{$tag}%")
            ->latest('published_at')
            ->paginate(12);

        $featuredBlogs = Blog::published()->featured()->latest('published_at')->take(5)->get();

        return view('blog.index', compact('blogs', 'featuredBlogs', 'tag'));
    }
}
