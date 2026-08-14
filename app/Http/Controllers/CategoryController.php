<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function show(string $slug): View
    {
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $jobs = Job::where('category_id', $category->id)
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('last_date')
                      ->orWhere('last_date', '>=', now());
            })
            ->latest()
            ->paginate(10);

        return view('category', compact('category', 'jobs'));
    }
}
