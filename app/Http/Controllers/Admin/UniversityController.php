<?php
// app/Http/Controllers/Admin/UniversityController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UniversityController extends Controller
{
    public function index(Request $request)
    {
        $query = University::withCount('admissions')->latest();

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('state', 'like', "%{$search}%");
        }

        $universities = $query->paginate(20);

        return view('admin.universities.index', compact('universities'));
    }

    public function create()
    {
        return view('admin.universities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:universities,name',
            'slug' => 'nullable|string|max:255|unique:universities,slug',
            'code' => 'nullable|string|max:50|unique:universities,code',
            'type' => 'required|in:government,private,deemed',
            'established_year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'location' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'website' => 'nullable|url',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('universities', 'public');
        }

        University::create($validated);

        return redirect()->route('admin.universities.index')
            ->with('success', 'University created successfully!');
    }

    public function edit(University $university)
    {
        return view('admin.universities.edit', compact('university'));
    }

    public function update(Request $request, University $university)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('universities')->ignore($university->id)
            ],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('universities')->ignore($university->id)
            ],
            'code' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('universities')->ignore($university->id)
            ],
            'type' => 'required|in:government,private,deemed',
            'established_year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'location' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'website' => 'nullable|url',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($university->logo) {
                \Storage::disk('public')->delete($university->logo);
            }
            $validated['logo'] = $request->file('logo')->store('universities', 'public');
        }

        $university->update($validated);

        return redirect()->route('admin.universities.index')
            ->with('success', 'University updated successfully!');
    }

    public function destroy(University $university)
    {
        // Check if university has admissions
        if ($university->admissions()->count() > 0) {
            return back()->with('error', 'Cannot delete university with existing admissions!');
        }

        // Delete logo if exists
        if ($university->logo) {
            \Storage::disk('public')->delete($university->logo);
        }

        $university->delete();

        return back()->with('success', 'University deleted successfully!');
    }

    public function toggleStatus(University $university)
    {
        $university->update(['is_active' => !$university->is_active]);

        $status = $university->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "University {$status} successfully!");
    }
}