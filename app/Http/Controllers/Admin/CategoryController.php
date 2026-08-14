<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        try {
            $query = Category::withCount('jobs');

            // 🔍 Search filter
            if ($search = $request->input('search')) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('description', 'LIKE', "%{$search}%")
                      ->orWhere('slug', 'LIKE', "%{$search}%");
                });
            }

            // ⚙️ Status filter
            if ($status = $request->input('status')) {
                if ($status === 'active') {
                    $query->where('is_active', true);
                } elseif ($status === 'inactive') {
                    $query->where('is_active', false);
                }
            }

            // 🔄 Sort options
            $sort = $request->input('sort', 'latest');
            switch ($sort) {
                case 'oldest':
                    $query->orderBy('id');
                    break;
                case 'name_asc':
                    $query->orderBy('name');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'jobs_asc':
                    $query->orderBy('jobs_count');
                    break;
                case 'jobs_desc':
                    $query->orderBy('jobs_count', 'desc');
                    break;
                default:
                    $query->orderByDesc('id');
            }

            // ✅ Always use paginate() to get a LengthAwarePaginator instance
            $categories = $query->paginate(10)->withQueryString();

            // 📊 Statistics
            $stats = [
                'total'      => Category::count(),
                'active'     => Category::where('is_active', true)->count(),
                'with_jobs'  => Category::has('jobs')->count(),
                'total_jobs' => Job::count(),
            ];

            return view('admin.categories.index', compact('categories', 'stats'));

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to load categories: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            return view('admin.categories.create');
        } catch (\Exception $e) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Failed to load create form: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:categories,name'
                ],
                'description' => 'nullable|string|max:500',
                'is_active' => 'nullable|boolean',
                'meta_title' => 'nullable|string|max:60',
                'meta_description' => 'nullable|string|max:160',
                'meta_keywords' => 'nullable|string|max:255',
            ], [
                'name.unique' => 'A category with this name already exists.',
                'meta_title.max' => 'Meta title should not exceed 60 characters.',
                'meta_description.max' => 'Meta description should not exceed 160 characters.',
            ]);

            $category = Category::create([
                'name'            => $validated['name'],
                'slug'            => $this->generateUniqueSlug($validated['name']),
                'description'     => $validated['description'] ?? null,
                'is_active'       => $request->boolean('is_active'),
                'meta_title'      => $validated['meta_title'] ?? null,
                'meta_description'=> $validated['meta_description'] ?? null,
                'meta_keywords'   => $validated['meta_keywords'] ?? null,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Category created successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to create category: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        try {
            $category = Category::withCount('jobs')->findOrFail($id);
            $recentJobs = $category->jobs()
                ->with('category')
                ->latest()
                ->take(5)
                ->get();

            // Statistics for this category
            $categoryStats = [
                'total_jobs' => $category->jobs_count,
                'active_jobs' => $category->jobs()->where('is_active', true)->count(),
                'featured_jobs' => $category->jobs()->where('is_featured', true)->count(),
                'expired_jobs' => $category->jobs()->where('last_date', '<', now())->count(),
            ];

            return view('admin.categories.show', compact('category', 'recentJobs', 'categoryStats'));

        } catch (\Exception $e) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Category not found: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $category = Category::findOrFail($id);
            return view('admin.categories.edit', compact('category'));
        } catch (\Exception $e) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Category not found: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $category = Category::findOrFail($id);

            $validated = $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('categories')->ignore($category->id)
                ],
                'description' => 'nullable|string|max:500',
                'is_active' => 'nullable|boolean',
                'meta_title' => 'nullable|string|max:60',
                'meta_description' => 'nullable|string|max:160',
                'meta_keywords' => 'nullable|string|max:255',
            ], [
                'name.unique' => 'A category with this name already exists.',
                'meta_title.max' => 'Meta title should not exceed 60 characters.',
                'meta_description.max' => 'Meta description should not exceed 160 characters.',
            ]);

            $updateData = [
                'name'            => $validated['name'],
                'description'     => $validated['description'] ?? null,
                'is_active'       => $request->boolean('is_active'),
                'meta_title'      => $validated['meta_title'] ?? null,
                'meta_description'=> $validated['meta_description'] ?? null,
                'meta_keywords'   => $validated['meta_keywords'] ?? null,
            ];

            // Generate new slug if name changed
            if ($category->name !== $validated['name']) {
                $updateData['slug'] = $this->generateUniqueSlug($validated['name']);
            }

            $category->update($updateData);

            DB::commit();

            return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Category updated successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to update category: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $category = Category::findOrFail($id);

            if ($category->jobs()->exists()) {
                return back()->with('error', 
                    'Cannot delete category because it has ' . $category->jobs()->count() . 
                    ' associated jobs. Please delete or reassign the jobs first.');
            }

            $categoryName = $category->name;
            $category->delete();

            DB::commit();

            return redirect()
                ->route('admin.categories.index')
                ->with('success', "Category '{$categoryName}' deleted successfully.");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.categories.index')
                ->with('error', 'Failed to delete category: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);
            
            $category->update([
                'is_active' => !$category->is_active
            ]);

            $status = $category->is_active ? 'activated' : 'deactivated';

            return back()->with('success', "Category '{$category->name}' {$status} successfully.");

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update category status: ' . $e->getMessage());
        }
    }

    /**
     * Bulk actions for categories
     */
    public function bulkActivate(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'exists:categories,id'
            ]);

            Category::whereIn('id', $request->ids)->update(['is_active' => true]);

            return back()->with('success', 
                count($request->ids) . ' categor' . (count($request->ids) === 1 ? 'y' : 'ies') . ' activated successfully.');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to activate categories: ' . $e->getMessage());
        }
    }

    public function bulkDeactivate(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'exists:categories,id'
            ]);

            Category::whereIn('id', $request->ids)->update(['is_active' => false]);

            return back()->with('success', 
                count($request->ids) . ' categor' . (count($request->ids) === 1 ? 'y' : 'ies') . ' deactivated successfully.');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to deactivate categories: ' . $e->getMessage());
        }
    }

    public function bulkDelete(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'exists:categories,id'
            ]);

            $categories = Category::withCount('jobs')->whereIn('id', $request->ids)->get();
            
            $deletable = $categories->filter(fn($cat) => $cat->jobs_count === 0);
            $nonDeletable = $categories->filter(fn($cat) => $cat->jobs_count > 0);

            if ($deletable->isNotEmpty()) {
                Category::whereIn('id', $deletable->pluck('id'))->delete();
            }

            DB::commit();

            $message = '';
            if ($deletable->isNotEmpty()) {
                $message = $deletable->count() . ' categor' . ($deletable->count() === 1 ? 'y' : 'ies') . ' deleted successfully.';
            }
            if ($nonDeletable->isNotEmpty()) {
                $message .= ' ' . $nonDeletable->count() . ' categor' . ($nonDeletable->count() === 1 ? 'y' : 'ies') . 
                           ' could not be deleted because they have associated jobs.';
            }

            return back()->with(
                $deletable->isNotEmpty() ? 'success' : 'warning', 
                trim($message)
            );

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete categories: ' . $e->getMessage());
        }
    }

    /**
     * Import categories from CSV
     */
    public function import(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'file' => 'required|file|mimes:csv,txt|max:1024'
            ]);

            $file = $request->file('file');
            $csvData = array_map('str_getcsv', file($file));
            $headers = array_shift($csvData);

            $imported = 0;
            $errors = [];

            foreach ($csvData as $rowNumber => $row) {
                try {
                    if (count($row) !== count($headers)) {
                        $errors[] = "Row " . ($rowNumber + 2) . ": Column count mismatch";
                        continue;
                    }

                    $data = array_combine($headers, $row);

                    Category::create([
                        'name' => $data['name'],
                        'slug' => $this->generateUniqueSlug($data['name']),
                        'description' => $data['description'] ?? null,
                        'is_active' => filter_var($data['is_active'] ?? true, FILTER_VALIDATE_BOOLEAN),
                    ]);

                    $imported++;

                } catch (\Exception $e) {
                    $errors[] = "Row " . ($rowNumber + 2) . ": " . $e->getMessage();
                }
            }

            DB::commit();

            $message = "Successfully imported {$imported} categories.";
            if (!empty($errors)) {
                $message .= " " . count($errors) . " errors occurred.";
                session()->flash('import_errors', $errors);
            }

            return back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to import categories: ' . $e->getMessage());
        }
    }

    /**
     * Export categories to CSV
     */
    public function export()
    {
        try {
            $categories = Category::withCount('jobs')->get();
            
            $fileName = 'categories-' . date('Y-m-d') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ];

            $callback = function() use ($categories) {
                $file = fopen('php://output', 'w');
                
                // Add headers
                fputcsv($file, ['Name', 'Slug', 'Description', 'Jobs Count', 'Status', 'Created At']);
                
                // Add data
                foreach ($categories as $category) {
                    fputcsv($file, [
                        $category->name,
                        $category->slug,
                        $category->description,
                        $category->jobs_count,
                        $category->is_active ? 'Active' : 'Inactive',
                        $category->created_at->format('Y-m-d H:i:s')
                    ]);
                }
                
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to export categories: ' . $e->getMessage());
        }
    }

    /**
     * Generate unique slug for category
     */
    private function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        while (Category::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }
}