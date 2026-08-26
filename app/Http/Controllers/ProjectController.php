<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceProject;
use App\Models\Service;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of active maintenance projects / case studies.
     */
    public function index(Request $request)
    {
        $serviceSlug = $request->query('service');
        $query = MaintenanceProject::with('service')->where('is_active', true);

        $selectedService = null;
        if ($serviceSlug) {
            $selectedService = Service::where('slug', $serviceSlug)->first();
            if ($selectedService) {
                $query->where('service_id', $selectedService->id);
            }
        }

        $projects = $query->orderBy('sort_order', 'asc')->latest()->paginate(9)->withQueryString();
        $services = Service::where('is_active', true)->has('maintenanceProjects')->orWhere('is_active', true)->get();

        return view('projects.index', compact('projects', 'services', 'selectedService', 'serviceSlug'));
    }

    /**
     * Display the specified maintenance project case study.
     */
    public function show(string $slug)
    {
        $project = MaintenanceProject::with('service')->where('slug', $slug)->firstOrFail();

        // Get related projects
        $relatedProjects = MaintenanceProject::where('id', '!=', $project->id)
            ->where('is_active', true)
            ->where(function ($q) use ($project) {
                if ($project->service_id) {
                    $q->where('service_id', $project->service_id);
                }
            })
            ->take(3)
            ->get();

        if ($relatedProjects->isEmpty()) {
            $relatedProjects = MaintenanceProject::where('id', '!=', $project->id)
                ->where('is_active', true)
                ->take(3)
                ->get();
        }

        return view('projects.show', compact('project', 'relatedProjects'));
    }
}
