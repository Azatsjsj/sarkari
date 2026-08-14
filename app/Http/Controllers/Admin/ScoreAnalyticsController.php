<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnswerKeyCalculation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScoreAnalyticsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = AnswerKeyCalculation::query();

        // Search filter (URL or IP)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('answer_key_url', 'LIKE', "%{$search}%")
                  ->orWhere('ip_address', 'LIKE', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // State filter
        if ($request->filled('state')) {
            $query->where('state', $request->state);
        }

        // Gender filter
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        $calculations = $query->latest()->paginate(25);

        // Calculate analytics statistics
        $stats = [
            'total_submissions' => AnswerKeyCalculation::count(),
            'avg_net_score' => round((float) AnswerKeyCalculation::avg('net_score'), 2),
            'max_score' => (float) AnswerKeyCalculation::max('net_score'),
            'top_categories' => AnswerKeyCalculation::select('category', DB::raw('count(*) as count'))
                ->groupBy('category')
                ->orderBy('count', 'desc')
                ->get(),
            'top_states' => AnswerKeyCalculation::select('state', DB::raw('count(*) as count'))
                ->groupBy('state')
                ->orderBy('count', 'desc')
                ->take(5)
                ->get(),
        ];

        return view('admin.score-analytics.index', compact('calculations', 'stats'));
    }

    public function show($id)
    {
        $calculation = AnswerKeyCalculation::findOrFail($id);
        return view('admin.score-analytics.show', compact('calculation'));
    }

    public function destroy($id)
    {
        $calculation = AnswerKeyCalculation::findOrFail($id);
        $calculation->delete();

        return redirect()->route('admin.score-analytics.index')
            ->with('success', 'Score calculation entry deleted successfully.');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete',
            'ids' => 'required|array',
            'ids.*' => 'exists:answer_key_calculations,id'
        ]);

        if ($request->action === 'delete') {
            AnswerKeyCalculation::whereIn('id', $request->ids)->delete();
            return back()->with('success', 'Selected score calculation entries deleted successfully.');
        }

        return back();
    }
}
