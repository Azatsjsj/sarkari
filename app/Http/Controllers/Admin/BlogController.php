<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::with(['category', 'author'])->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $blogs = $query->paginate(15)->withQueryString();

        return view('admin.blog.index', compact('blogs'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('admin.blog.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'slug' => 'required|string|max:200|unique:blogs,slug',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string|min:300',
            'featured_image' => 'required|image|mimes:jpeg,png,webp|max:2048',
            'additional_images.*' => 'image|mimes:jpeg,png,webp|max:2048',
            'meta_description' => 'required|string|max:160|min:120',
            'meta_keywords' => 'nullable|string|max:255',
            'focus_keyphrase' => 'required|string|max:100',
            'tags' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published,scheduled',
            'published_at' => 'nullable|date|after:now',
            'is_featured' => 'boolean',
            'is_breaking' => 'boolean',
            'enable_schema' => 'boolean',
            'enable_breadcrumb' => 'boolean',
            'enable_faq' => 'boolean',
        ]);

        // Handle featured image
        $featuredImagePath = $request->file('featured_image')->store('blog/featured', 'public');

        // Handle additional images
        $additionalImages = [];
        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $image) {
                $additionalImages[] = $image->store('blog/gallery', 'public');
            }
        }

        $blog = Blog::create([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'category_id' => $validated['category_id'],
            'content' => $validated['content'],
            'featured_image' => $featuredImagePath,
            'additional_images' => json_encode($additionalImages),
            'meta_description' => $validated['meta_description'],
            'meta_keywords' => $validated['meta_keywords'] ?? '',
            'focus_keyphrase' => $validated['focus_keyphrase'],
            'tags' => $validated['tags'] ?? '',
            'status' => $validated['status'],
            'published_at' => $validated['status'] === 'scheduled' 
                            ? Carbon::parse($validated['published_at']) 
                            : ($validated['status'] === 'published' ? now() : null),
            'is_featured' => $request->has('is_featured'),
            'is_breaking' => $request->has('is_breaking'),
            'enable_schema' => $request->has('enable_schema'),
            'enable_breadcrumb' => $request->has('enable_breadcrumb'),
            'enable_faq' => $request->has('enable_faq'),
            'author_id' => auth()->id(),
            'views' => 0,
        ]);

        // Clear cache
        Cache::forget('featured_blogs');
        Cache::forget('breaking_blogs');
        Cache::forget('latest_blogs');

        return redirect()->route('admin.blog.index')
                         ->with('success', 'Article created successfully!');
    }

    public function edit(Blog $blog)
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('admin.blog.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'slug' => 'required|string|max:200|unique:blogs,slug,' . $blog->id,
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string|min:300',
            'featured_image' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
            'meta_description' => 'required|string|max:160|min:120',
            'meta_keywords' => 'nullable|string|max:255',
            'focus_keyphrase' => 'required|string|max:100',
            'tags' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published,scheduled',
            'published_at' => 'nullable|date',
            'is_featured' => 'boolean',
            'is_breaking' => 'boolean',
            'enable_schema' => 'boolean',
            'enable_breadcrumb' => 'boolean',
            'enable_faq' => 'boolean',
        ]);

        if ($request->hasFile('featured_image')) {
            if ($blog->featured_image) {
                Storage::disk('public')->delete($blog->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('blog/featured', 'public');
        }

        $blog->update([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'category_id' => $validated['category_id'],
            'content' => $validated['content'],
            'featured_image' => $validated['featured_image'] ?? $blog->featured_image,
            'meta_description' => $validated['meta_description'],
            'meta_keywords' => $validated['meta_keywords'] ?? '',
            'focus_keyphrase' => $validated['focus_keyphrase'],
            'tags' => $validated['tags'] ?? '',
            'status' => $validated['status'],
            'published_at' => $validated['status'] === 'scheduled'
                ? Carbon::parse($validated['published_at'])
                : ($validated['status'] === 'published' ? ($blog->published_at ?? now()) : null),
            'is_featured' => $request->boolean('is_featured'),
            'is_breaking' => $request->boolean('is_breaking'),
            'enable_schema' => $request->boolean('enable_schema'),
            'enable_breadcrumb' => $request->boolean('enable_breadcrumb'),
            'enable_faq' => $request->boolean('enable_faq'),
        ]);

        Cache::forget('featured_blogs');
        Cache::forget('breaking_blogs');
        Cache::forget('latest_blogs');

        return redirect()->route('admin.blog.index')
            ->with('success', 'Article updated successfully!');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->featured_image) {
            Storage::disk('public')->delete($blog->featured_image);
        }

        $blog->delete();

        Cache::forget('featured_blogs');
        Cache::forget('breaking_blogs');
        Cache::forget('latest_blogs');

        return redirect()->route('admin.blog.index')
            ->with('success', 'Article deleted successfully!');
    }

    public function toggleStatus(int $id)
    {
        $blog = Blog::findOrFail($id);
        $blog->update([
            'status' => $blog->status === 'published' ? 'draft' : 'published',
            'published_at' => $blog->status === 'published' ? null : now(),
        ]);

        return back()->with('success', 'Article status updated.');
    }

    public function toggleFeatured(int $id)
    {
        $blog = Blog::findOrFail($id);
        $blog->update(['is_featured' => !$blog->is_featured]);

        return back()->with('success', 'Featured status updated.');
    }

    private function generateMetaTags(Blog $blog)
    {
        return [
            'title' => $blog->title . ' - Sarkari Result 2026',
            'meta_description' => $blog->meta_description,
            'meta_keywords' => $blog->meta_keywords,
            'og_title' => $blog->title,
            'og_description' => $blog->meta_description,
            'og_image' => asset('storage/' . $blog->featured_image),
            'twitter_title' => $blog->title,
            'twitter_description' => $blog->meta_description,
            'twitter_image' => asset('storage/' . $blog->featured_image),
            'canonical' => route('blog.show', $blog->slug),
            'robots' => $blog->status === 'published' ? 'index, follow' : 'noindex, nofollow',
        ];
    }
}