<?php
// app/Http/Controllers/DocumentController.php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    /**
     * Get common data used across the index view.
     */
    private function getCommonData()
    {
        return [
            'featuredNotices' => Document::active()->notices()->featured()->latest()->take(6)->get(),
            'featuredCertificates' => Document::active()->certificates()->featured()->latest()->take(6)->get(),
            'stats' => [
                'notices' => Document::active()->notices()->count(),
                'certificates' => Document::active()->certificates()->count(),
                'total' => Document::active()->count(),
            ],
        ];
    }

    public function index(Request $request)
    {
        $query = Document::active();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('document_number', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%");
            });
        }

        $documents = $query->orderBy('sort_order', 'asc')
            ->orderBy('issue_date', 'desc')
            ->paginate(20);

        $viewData = array_merge(
            compact('documents'),
            $this->getCommonData()
        );

        return view('documents.index', $viewData);
    }

    public function show(Document $document)
    {
        $document->increment('views');
        
        $relatedDocuments = Document::active()
            ->where('type', $document->type)
            ->where('id', '!=', $document->id)
            ->latest()
            ->take(5)
            ->get();

        $pageDisplayTitle = trim((string) (
            $document->title
            ?: $document->short_description
            ?: $document->description
            ?: ($document->slug ? Str::of($document->slug)
                ->replace(['_', '-'], ' ')
                ->replaceMatches('/\s+/', ' ')
                ->squish()
                ->title()
                ->toString()
                : 'Document Details')
        ));
        $pageDisplayDescription = trim((string) ($document->short_description ?: ($document->description ?: 'Official government document and notice details.')));

        return view('documents.show', compact('document', 'relatedDocuments', 'pageDisplayTitle', 'pageDisplayDescription'));
    }

    public function download(Document $document)
    {
        $document->increment('download_count');
        
        $filePath = storage_path('app/public/' . $document->file_path);
        
        if (file_exists($filePath)) {
            return response()->download($filePath, $document->file_name ?? $document->title . '.pdf', [
                'Content-Type' => 'application/pdf',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
            ]);
        }
        
        return redirect()->back()->with('error', 'File not found.');
    }

    public function verifyForm()
    {
        return view('documents.verify-form');
    }

    public function verifyCertificate(Request $request)
    {
        $request->validate([
            'certificate_number' => 'required|string'
        ]);
        
        $certificate = Document::certificates()
            ->where('document_number', $request->certificate_number)
            ->first();

        return view('documents.verify-result', compact('certificate'));
    }

    public function notices()
    {
        $documents = Document::notices()->active()->paginate(20);
        
        $viewData = array_merge(
            compact('documents'),
            $this->getCommonData()
        );
        
        return view('documents.index', $viewData);
    }

    public function certificates()
    {
        $documents = Document::certificates()->active()->paginate(20);
        
        $viewData = array_merge(
            compact('documents'),
            $this->getCommonData()
        );
        
        return view('documents.index', $viewData);
    }
}