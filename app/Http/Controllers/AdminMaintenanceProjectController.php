<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceProject;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminMaintenanceProjectController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $serviceId = $request->query('service_id');

        $query = MaintenanceProject::with('service');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title_ar', 'like', "%{$search}%")
                    ->orWhere('title_en', 'like', "%{$search}%")
                    ->orWhere('client_name', 'like', "%{$search}%")
                    ->orWhere('vessel_type', 'like', "%{$search}%");
            });
        }

        if ($serviceId) {
            $query->where('service_id', $serviceId);
        }

        $projects = $query->orderBy('sort_order', 'asc')->latest()->paginate(15)->withQueryString();
        $services = Service::where('is_active', true)->get();

        return view('admin.projects.index', compact('projects', 'services', 'search', 'serviceId'));
    }

    public function create()
    {
        $services = Service::where('is_active', true)->get();

        return view('admin.projects.create', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'service_id' => 'nullable|exists:services,id',
            'client_name' => 'nullable|string|max:255',
            'vessel_type' => 'nullable|string|max:255',
            'location_ar' => 'nullable|string|max:255',
            'location_en' => 'nullable|string|max:255',
            'duration' => 'nullable|string|max:100',
            'short_desc_ar' => 'nullable|string',
            'short_desc_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'main_image_file' => 'nullable|image|max:8192',
            'main_image_url' => 'nullable|string|max:500',
            'before_image_file' => 'nullable|image|max:8192',
            'before_image_url' => 'nullable|string|max:500',
            'after_image_file' => 'nullable|image|max:8192',
            'after_image_url' => 'nullable|string|max:500',
            'gallery_files.*' => 'nullable|image|max:8192',
            'video_url' => 'nullable|string|max:500',
            'spec_keys' => 'nullable|array',
            'spec_values' => 'nullable|array',
        ]);

        // Upload main image
        $mainImage = $request->main_image_url;
        if ($request->hasFile('main_image_file')) {
            $file = $request->file('main_image_file');
            $filename = 'proj_main_'.time().'_'.Str::random(4).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/projects'), $filename);
            $mainImage = '/uploads/projects/'.$filename;
        }

        // Upload before image
        $beforeImage = $request->before_image_url;
        if ($request->hasFile('before_image_file')) {
            $file = $request->file('before_image_file');
            $filename = 'proj_before_'.time().'_'.Str::random(4).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/projects'), $filename);
            $beforeImage = '/uploads/projects/'.$filename;
        }

        // Upload after image
        $afterImage = $request->after_image_url;
        if ($request->hasFile('after_image_file')) {
            $file = $request->file('after_image_file');
            $filename = 'proj_after_'.time().'_'.Str::random(4).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/projects'), $filename);
            $afterImage = '/uploads/projects/'.$filename;
        }

        // Upload gallery images
        $galleryPaths = [];
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $gFile) {
                $gFilename = 'proj_gal_'.time().'_'.Str::random(6).'.'.$gFile->getClientOriginalExtension();
                $gFile->move(public_path('uploads/projects'), $gFilename);
                $galleryPaths[] = '/uploads/projects/'.$gFilename;
            }
        }

        // Parse specifications key-values
        $specifications = [];
        if ($request->filled('spec_keys') && is_array($request->spec_keys)) {
            foreach ($request->spec_keys as $index => $key) {
                $val = $request->spec_values[$index] ?? '';
                if (! empty(trim($key)) && ! empty(trim($val))) {
                    $specifications[trim($key)] = trim($val);
                }
            }
        }

        $slugBase = $request->filled('title_en') ? Str::slug($request->title_en) : Str::slug($request->title_ar);
        if (empty($slugBase)) {
            $slugBase = 'case-'.time();
        }
        $slug = $slugBase.'-'.time();

        MaintenanceProject::create([
            'service_id' => $request->service_id,
            'title_ar' => $request->title_ar,
            'title_en' => $request->title_en,
            'slug' => $slug,
            'client_name' => $request->client_name,
            'vessel_type' => $request->vessel_type,
            'location_ar' => $request->location_ar,
            'location_en' => $request->location_en,
            'duration' => $request->duration,
            'short_desc_ar' => $request->short_desc_ar,
            'short_desc_en' => $request->short_desc_en,
            'description_ar' => $request->description_ar,
            'description_en' => $request->description_en,
            'specifications' => count($specifications) ? $specifications : null,
            'main_image' => $mainImage,
            'video_url' => $request->video_url,
            'gallery_images' => count($galleryPaths) ? $galleryPaths : null,
            'before_image' => $beforeImage,
            'after_image' => $afterImage,
            'is_featured' => $request->has('is_featured'),
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.projects.index')->with('success', 'تم إضافة مشروع الصيانة بنجاح!');
    }

    public function edit($id)
    {
        $project = MaintenanceProject::findOrFail($id);
        $services = Service::where('is_active', true)->get();

        return view('admin.projects.edit', compact('project', 'services'));
    }

    public function update(Request $request, $id)
    {
        $project = MaintenanceProject::findOrFail($id);

        $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'service_id' => 'nullable|exists:services,id',
            'client_name' => 'nullable|string|max:255',
            'vessel_type' => 'nullable|string|max:255',
            'location_ar' => 'nullable|string|max:255',
            'location_en' => 'nullable|string|max:255',
            'duration' => 'nullable|string|max:100',
            'short_desc_ar' => 'nullable|string',
            'short_desc_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'main_image_file' => 'nullable|image|max:8192',
            'main_image_url' => 'nullable|string|max:500',
            'before_image_file' => 'nullable|image|max:8192',
            'before_image_url' => 'nullable|string|max:500',
            'after_image_file' => 'nullable|image|max:8192',
            'after_image_url' => 'nullable|string|max:500',
            'gallery_files.*' => 'nullable|image|max:8192',
            'video_url' => 'nullable|string|max:500',
            'spec_keys' => 'nullable|array',
            'spec_values' => 'nullable|array',
        ]);

        // Main Image
        $mainImage = $project->main_image;
        if ($request->filled('main_image_url')) {
            $mainImage = $request->main_image_url;
        }
        if ($request->hasFile('main_image_file')) {
            $file = $request->file('main_image_file');
            $filename = 'proj_main_'.time().'_'.Str::random(4).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/projects'), $filename);
            $mainImage = '/uploads/projects/'.$filename;
        }

        // Before Image
        $beforeImage = $project->before_image;
        if ($request->filled('before_image_url')) {
            $beforeImage = $request->before_image_url;
        }
        if ($request->hasFile('before_image_file')) {
            $file = $request->file('before_image_file');
            $filename = 'proj_before_'.time().'_'.Str::random(4).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/projects'), $filename);
            $beforeImage = '/uploads/projects/'.$filename;
        }

        // After Image
        $afterImage = $project->after_image;
        if ($request->filled('after_image_url')) {
            $afterImage = $request->after_image_url;
        }
        if ($request->hasFile('after_image_file')) {
            $file = $request->file('after_image_file');
            $filename = 'proj_after_'.time().'_'.Str::random(4).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/projects'), $filename);
            $afterImage = '/uploads/projects/'.$filename;
        }

        // Gallery Images (combine retained with new)
        $existingGallery = $request->retained_gallery ?? [];
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $gFile) {
                $gFilename = 'proj_gal_'.time().'_'.Str::random(6).'.'.$gFile->getClientOriginalExtension();
                $gFile->move(public_path('uploads/projects'), $gFilename);
                $existingGallery[] = '/uploads/projects/'.$gFilename;
            }
        }

        // Specifications
        $specifications = [];
        if ($request->filled('spec_keys') && is_array($request->spec_keys)) {
            foreach ($request->spec_keys as $index => $key) {
                $val = $request->spec_values[$index] ?? '';
                if (! empty(trim($key)) && ! empty(trim($val))) {
                    $specifications[trim($key)] = trim($val);
                }
            }
        }

        $project->update([
            'service_id' => $request->service_id,
            'title_ar' => $request->title_ar,
            'title_en' => $request->title_en,
            'client_name' => $request->client_name,
            'vessel_type' => $request->vessel_type,
            'location_ar' => $request->location_ar,
            'location_en' => $request->location_en,
            'duration' => $request->duration,
            'short_desc_ar' => $request->short_desc_ar,
            'short_desc_en' => $request->short_desc_en,
            'description_ar' => $request->description_ar,
            'description_en' => $request->description_en,
            'specifications' => count($specifications) ? $specifications : null,
            'main_image' => $mainImage,
            'video_url' => $request->video_url,
            'gallery_images' => count($existingGallery) ? array_values($existingGallery) : null,
            'before_image' => $beforeImage,
            'after_image' => $afterImage,
            'is_featured' => $request->has('is_featured'),
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.projects.index')->with('success', 'تم تحديث بيانات مشروع الصيانة بنجاح!');
    }

    public function destroy($id)
    {
        $project = MaintenanceProject::findOrFail($id);
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'تم حذف المشروع بنجاح!');
    }
}
