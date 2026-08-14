<?php
// app/Http/Controllers/Admin/AdminDocumentController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminDocumentController extends Controller
{
    /**
     * Display documents listing in admin panel
     */
    public function index(Request $request)
    {
        $query = Document::query();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status == 'active');
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('document_number', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%");
            });
        }

        $documents = $query->orderBy('created_at', 'desc')->paginate(20);
        
        $stats = [
            'total' => Document::count(),
            'notices' => Document::notices()->count(),
            'certificates' => Document::certificates()->count(),
            'active' => Document::active()->count(),
            'featured' => Document::featured()->count(),
        ];

        return view('admin.documents.index', compact('documents', 'stats'));
    }

    /**
     * Show form to create new document
     */
    public function create()
    {
        return view('admin.documents.create');
    }

    /**
     * Store new document
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'document_number' => 'nullable|string|max:100',
            'type' => 'required|in:notice,certificate,syllabus,admit_card,result,answer_key,other',
            'category' => 'nullable|string|max:100',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'department' => 'nullable|string|max:200',
            'issued_by' => 'nullable|string|max:200',
            'issue_date' => 'nullable|date',
            'valid_upto' => 'nullable|date|after:issue_date',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'language' => 'in:hindi,english',
            'sort_order' => 'integer',
            'document_file' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
        ]);

        // Handle file upload
        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
            $fileName = time() . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('documents/' . $request->type, $fileName, 'public');
            
            $validated['file_path'] = $filePath;
            $validated['file_name'] = $file->getClientOriginalName();
            $validated['file_size'] = $file->getSize();
            $validated['file_type'] = $file->getMimeType();
        }

        $validated['slug'] = Str::slug($request->title) . '-' . time();
        
        Document::create($validated);

        return redirect()->route('admin.documents.index')
            ->with('success', 'Document uploaded successfully.');
    }

    /**
     * Show document details in admin panel
     */
    public function show(Document $document)
    {
        return view('admin.documents.show', compact('document'));
    }

    /**
     * Show form to edit document
     */
    public function edit(Document $document)
    {
        return view('admin.documents.edit', compact('document'));
    }

    /**
     * Update document
     */
    public function update(Request $request, Document $document)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'document_number' => 'nullable|string|max:100',
            'type' => 'required|in:notice,certificate,syllabus,admit_card,result,answer_key,other',
            'category' => 'nullable|string|max:100',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'department' => 'nullable|string|max:200',
            'issued_by' => 'nullable|string|max:200',
            'issue_date' => 'nullable|date',
            'valid_upto' => 'nullable|date|after:issue_date',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'language' => 'in:hindi,english',
            'sort_order' => 'integer',
            'document_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
        ]);

        // Handle file upload
        if ($request->hasFile('document_file')) {
            // Delete old file
            if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }
            
            $file = $request->file('document_file');
            $fileName = time() . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('documents/' . $request->type, $fileName, 'public');
            
            $validated['file_path'] = $filePath;
            $validated['file_name'] = $file->getClientOriginalName();
            $validated['file_size'] = $file->getSize();
            $validated['file_type'] = $file->getMimeType();
        }

        $document->update($validated);

        return redirect()->route('admin.documents.index')
            ->with('success', 'Document updated successfully.');
    }

    /**
     * Delete document
     */
    public function destroy(Document $document)
    {
        // Delete file from storage
        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }
        
        $document->delete();

        return redirect()->route('admin.documents.index')
            ->with('success', 'Document deleted successfully.');
    }

    /**
     * Toggle document status
     */
    public function toggleStatus(Document $document)
    {
        $document->update(['is_active' => !$document->is_active]);
        
        return response()->json([
            'success' => true,
            'status' => $document->is_active ? 'active' : 'inactive'
        ]);
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(Document $document)
    {
        $document->update(['is_featured' => !$document->is_featured]);
        
        return response()->json([
            'success' => true,
            'featured' => $document->is_featured
        ]);
    }

    /**
     * Bulk delete documents
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        
        $documents = Document::whereIn('id', $ids)->get();
        
        foreach ($documents as $document) {
            if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }
            $document->delete();
        }
        
        return response()->json(['success' => true]);
    }

    /**
     * Export documents to CSV
     */
    public function export(Request $request)
    {
        $query = Document::query();
        
        if ($request->type) {
            $query->where('type', $request->type);
        }
        
        $documents = $query->get();
        
        $filename = 'documents_' . date('Y-m-d') . '.csv';
        
        $handle = fopen('php://output', 'w');
        
        fputcsv($handle, ['ID', 'Title', 'Document Number', 'Type', 'Department', 'Downloads', 'Views', 'Status', 'Created At']);
        
        foreach ($documents as $document) {
            fputcsv($handle, [
                $document->id,
                $document->title,
                $document->document_number,
                $document->type,
                $document->department,
                $document->download_count,
                $document->views,
                $document->is_active ? 'Active' : 'Inactive',
                $document->created_at->format('Y-m-d')
            ]);
        }
        
        fclose($handle);
        
        return response()->stream(
            function() use ($handle) {
                fpassthru($handle);
            },
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]
        );
    }
}