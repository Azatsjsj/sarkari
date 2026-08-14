<?php
// app/Http/Controllers/Admin/CourseController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::withCount('admissions')->latest();

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
        }

        $courses = $query->paginate(20);

        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:courses,name',
            'slug' => 'nullable|string|max:255|unique:courses,slug',
            'code' => 'nullable|string|max:50|unique:courses,code',
            'level' => 'required|in:undergraduate,postgraduate,diploma,phd',
            'duration' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        Course::create($validated);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course created successfully!');
    }

    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('courses')->ignore($course->id)
            ],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('courses')->ignore($course->id)
            ],
            'code' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('courses')->ignore($course->id)
            ],
            'level' => 'required|in:undergraduate,postgraduate,diploma,phd',
            'duration' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $course->update($validated);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course updated successfully!');
    }

    public function destroy(Course $course)
    {
        // Check if course has admissions
        if ($course->admissions()->count() > 0) {
            return back()->with('error', 'Cannot delete course with existing admissions!');
        }

        $course->delete();

        return back()->with('success', 'Course deleted successfully!');
    }

    public function toggleStatus(Course $course)
    {
        $course->update(['is_active' => !$course->is_active]);

        $status = $course->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "Course {$status} successfully!");
    }
}