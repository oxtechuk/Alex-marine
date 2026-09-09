<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Certificate;
use App\Models\MaintenanceProject;
use App\Models\NewsArticle;
use App\Models\Product;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        $selectedCategorySlug = $request->get('category', 'all');

        $fleetQuery = Product::with('category')->where('is_active', true);
        if ($selectedCategorySlug !== 'all') {
            $fleetQuery->whereHas('category', function ($q) use ($selectedCategorySlug) {
                $q->where('slug', $selectedCategorySlug);
            });
        }
        $fleetProducts = $fleetQuery->latest()->take(16)->get();

        if ($request->ajax()) {
            return view('partials.fleet-products-grid', compact('fleetProducts'));
        }

        $settings = Setting::pluck('value', 'key')->all();
        $featureCategoryIds = ! empty($settings['feature_category_ids']) ? array_filter(explode(',', $settings['feature_category_ids'])) : [];
        if (! empty($featureCategoryIds)) {
            $featureCategories = Category::whereIn('id', $featureCategoryIds)->get();
        } else {
            $featureCategories = $categories->take(4);
        }

        $featuredProducts = Product::with('category')->where('is_active', true)->where('is_featured', true)->take(8)->get();
        if ($featuredProducts->isEmpty()) {
            $featuredProducts = Product::with('category')->where('is_active', true)->take(8)->get();
        }
        $services = Service::where('is_active', true)->take(4)->get();
        $certificates = Certificate::where('is_active', true)->take(3)->get();
        $news = NewsArticle::where('is_published', true)->orderBy('published_at', 'desc')->take(3)->get();
        $maintenanceProjects = MaintenanceProject::with('service')->where('is_active', true)->orderBy('sort_order', 'asc')->latest()->take(3)->get();

        return view('home', compact('categories', 'featureCategories', 'fleetProducts', 'featuredProducts', 'services', 'certificates', 'news', 'maintenanceProjects', 'selectedCategorySlug', 'settings'));
    }

    public function about()
    {
        $certificates = Certificate::where('is_active', true)->get();

        return view('about', compact('certificates'));
    }

    public function contact()
    {
        return view('contact');
    }
}
