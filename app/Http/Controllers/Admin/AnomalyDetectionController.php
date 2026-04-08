<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AnomalyDetection;
use App\Services\AnomalyDetectionService;

class AnomalyDetectionController extends Controller
{
    protected $anomalyService;

    public function __construct(AnomalyDetectionService $anomalyService)
    {
        $this->anomalyService = $anomalyService;
    }

    public function index(Request $request)
    {
        $query = AnomalyDetection::with(['user', 'reviewer'])
            ->orderBy('detected_at', 'desc');

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('severity') && $request->severity !== 'all') {
            $query->where('severity', $request->severity);
        }

        if ($request->has('type') && $request->type !== 'all') {
            $query->where('anomaly_type', $request->type);
        }

        $anomalies = $query->paginate(20);

        $stats = [
            'total' => AnomalyDetection::count(),
            'pending' => AnomalyDetection::where('status', 'pending')->count(),
            'critical' => AnomalyDetection::where('severity', 'critical')->where('status', 'pending')->count(),
        ];

        return view('admin.anomaly-detection.index', compact('anomalies', 'stats'));
    }

    public function show($id)
    {
        $anomaly = AnomalyDetection::with(['user', 'reviewer'])->findOrFail($id);
        return view('admin.anomaly-detection.show', compact('anomaly'));
    }

    public function review(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:reviewed,resolved,false_positive',
            'review_notes' => 'nullable|string'
        ]);

        $anomaly = AnomalyDetection::findOrFail($id);
        $anomaly->update([
            'status' => $request->status,
            'review_notes' => $request->review_notes,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now()
        ]);

        return redirect()->route('admin.anomaly-detection.index')
            ->with('success', 'Anomaly reviewed successfully');
    }

    public function learnBaselines()
    {
        $users = \App\Models\User::all();
        
        foreach ($users as $user) {
            $this->anomalyService->learnUserBehavior($user->id);
        }

        return redirect()->route('admin.anomaly-detection.index')
            ->with('success', 'Behavior baselines learned for all users');
    }
}
