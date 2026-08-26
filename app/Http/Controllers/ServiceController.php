<?php

namespace App\Http\Controllers;

use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::where('is_active', true)->get();

        return view('services.index', compact('services'));
    }

    public function show($slug)
    {
        $service = Service::where('slug', $slug)->where('is_active', true)->with(['maintenanceProjects' => function ($q) {
            $q->where('is_active', true)->take(3);
        }])->firstOrFail();
        $otherServices = Service::where('id', '!=', $service->id)->where('is_active', true)->take(3)->get();

        return view('services.show', compact('service', 'otherServices'));
    }
}
