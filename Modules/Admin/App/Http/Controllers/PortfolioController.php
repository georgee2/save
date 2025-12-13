<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Portfolio;
use App\Models\PortfolioType;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Intervention\Image\Facades\Image;

class PortfolioController extends Controller
{
    protected $portfolio;

    public function __construct(Portfolio $portfolio)
    {
        $this->portfolio = $portfolio;
    }

    /**
     * Display a listing of portfolios
     */
    public function index()
    {
        return view('admin::portfolios.index', [
            'data' => $this->portfolio->list(),
            'urls' => array(
                'add' => URL::to('admin/portfolio/create'),
                'show' => URL::to('admin/portfolio/show'),
                'update' => URL::to('admin/portfolio/edit'),
                'delete' => URL::to(app()->getLocale().'/admin/portfolio/delete')
            ),
        ]);
    }

    /**
     * Show the form for creating a new portfolio
     */
    public function create()
    {
        $portfolioTypes = PortfolioType::whereNull('deleted_at')
            ->where('status', 0)
            ->orderBy('name_english')
            ->get();
            
        return view('admin::portfolios.create', [
            'portfolioTypes' => $portfolioTypes
        ]);
    }

    /**
     * Store a newly created portfolio
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title_english' => 'required|string|max:255',
            'title_arabic' => 'required|string|max:255',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5000',
            'page_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5000',
            'bio_english' => 'nullable|string|max:500',
            'bio_arabic' => 'nullable|string|max:500',
            'description_english' => 'required|string|max:3000',
            'description_arabic' => 'required|string|max:3000',
            'date' => 'required|date',
            'icon' => 'required|image|mimes:jpeg,png,jpg,webp|max:2000',
            'cover' => 'required|image|mimes:jpeg,png,jpg,webp|max:5000',
            'client_name' => 'required|string|max:255',
            'portfolio_type_id' => 'required|exists:portfolio_types,id',
            'seo_tags' => 'nullable|string',
            'seo_description_english' => 'nullable|string|max:1000',
            'seo_description_arabic' => 'nullable|string|max:1000',
            'status' => 'required|in:0,1',
            'home_status' => 'required|in:0,1',
        ]);

        // Main Image Upload (645x460)
        if ($request->hasFile('main_image')) {
            $imageFile = $request->file('main_image');
            $image = Image::make($imageFile)->resize(645, 460)->encode('webp', 80);
            $imageName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/portfolios/main/' . $imageName, (string) $image);
            $data['main_image'] = "/uploads/portfolios/main/{$imageName}";
        }

        // Page Image Upload (868x450)
        if ($request->hasFile('page_image')) {
            $imageFile = $request->file('page_image');
            $image = Image::make($imageFile)->resize(868, 450)->encode('webp', 80);
            $imageName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/portfolios/page/' . $imageName, (string) $image);
            $data['page_image'] = "/uploads/portfolios/page/{$imageName}";
        }

        // Icon Upload (100x100)
        if ($request->hasFile('icon')) {
            $iconFile = $request->file('icon');
            $icon = Image::make($iconFile)->resize(100, 100)->encode('webp', 100);
            $iconName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/portfolios/icons/' . $iconName, (string) $icon);
            $data['icon'] = "/uploads/portfolios/icons/{$iconName}";
        }

        // Cover Upload (1890x420)
        if ($request->hasFile('cover')) {
            $coverFile = $request->file('cover');
            $cover = Image::make($coverFile)->resize(1890, 420)->encode('webp', 80);
            $coverName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/portfolios/covers/' . $coverName, (string) $cover);
            $data['cover'] = "/uploads/portfolios/covers/{$coverName}";
        }

        // SEO Tags Insertion (Helper Function)
        if ($request->seo_tags != null) {
            $data['seo_tags'] = tags($request->seo_tags);
        }

        // Generate slug from title_english
        $data['slug'] = Str::slug($request->title_english);
        
        // Ensure slug is unique
        $originalSlug = $data['slug'];
        $count = 1;
        while (Portfolio::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $count;
            $count++;
        }

        Portfolio::create($data);

        return redirect()->route('portfolio.index')->with('success', 'Portfolio created successfully!');
    }

    /**
     * Show the specified portfolio
     */
    public function show($id)
    {
        $portfolio = $this->portfolio->find($id);
        
        if (!$portfolio) {
            return redirect()->route('portfolio.index')->with('error', 'Portfolio not found!');
        }
        
        $portfolioModel = Portfolio::with(['processes'])->findOrFail($id);
        
        return view('admin::portfolios.show', [
            'portfolio' => $portfolio,
            'PortfolioModel' => $portfolioModel,
            'Processes' => $portfolioModel->processes
        ]);
    }

    /**
     * Show the form for editing portfolio
     */
    public function edit($id)
    {
        $portfolio = Portfolio::findOrFail($id);
        $portfolioTypes = PortfolioType::whereNull('deleted_at')
            ->where('status', 0)
            ->orderBy('name_english')
            ->get();
        
        return view('admin::portfolios.edit', [
            'portfolio' => $portfolio,
            'portfolioTypes' => $portfolioTypes
        ]);
    }

    /**
     * Update the specified portfolio
     */
    public function update(Request $request, $id)
    {
        $portfolio = Portfolio::findOrFail($id);
        
        $data = $request->validate([
            'title_english' => 'required|string|max:255',
            'title_arabic' => 'required|string|max:255',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5000',
            'page_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5000',
            'bio_english' => 'nullable|string|max:500',
            'bio_arabic' => 'nullable|string|max:500',
            'description_english' => 'required|string|max:3000',
            'description_arabic' => 'required|string|max:3000',
            'date' => 'required|date',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2000',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5000',
            'client_name' => 'required|string|max:255',
            'portfolio_type_id' => 'required|exists:portfolio_types,id',
            'seo_tags' => 'nullable|string',
            'seo_description_english' => 'nullable|string|max:1000',
            'seo_description_arabic' => 'nullable|string|max:1000',
            'status' => 'required|in:0,1',
            'home_status' => 'required|in:0,1',
        ]);

        // Main Image Upload (645x460)
        if ($request->hasFile('main_image')) {
            // Delete old image
            if ($portfolio->main_image && Storage::disk('public')->exists(ltrim($portfolio->main_image, '/'))) {
                Storage::disk('public')->delete(ltrim($portfolio->main_image, '/'));
            }
            
            $imageFile = $request->file('main_image');
            $image = Image::make($imageFile)->resize(645, 460)->encode('webp', 80);
            $imageName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/portfolios/main/' . $imageName, (string) $image);
            $data['main_image'] = "/uploads/portfolios/main/{$imageName}";
        }

        // Page Image Upload (868x450)
        if ($request->hasFile('page_image')) {
            // Delete old image
            if ($portfolio->page_image && Storage::disk('public')->exists(ltrim($portfolio->page_image, '/'))) {
                Storage::disk('public')->delete(ltrim($portfolio->page_image, '/'));
            }
            
            $imageFile = $request->file('page_image');
            $image = Image::make($imageFile)->resize(868, 450)->encode('webp', 80);
            $imageName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/portfolios/page/' . $imageName, (string) $image);
            $data['page_image'] = "/uploads/portfolios/page/{$imageName}";
        }

        // Icon Upload (100x100)
        if ($request->hasFile('icon')) {
            // Delete old icon
            if ($portfolio->icon && Storage::disk('public')->exists(ltrim($portfolio->icon, '/'))) {
                Storage::disk('public')->delete(ltrim($portfolio->icon, '/'));
            }
            
            $iconFile = $request->file('icon');
            $icon = Image::make($iconFile)->resize(100, 100)->encode('webp', 100);
            $iconName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/portfolios/icons/' . $iconName, (string) $icon);
            $data['icon'] = "/uploads/portfolios/icons/{$iconName}";
        }

        // Cover Upload (1890x420)
        if ($request->hasFile('cover')) {
            // Delete old cover
            if ($portfolio->cover && Storage::disk('public')->exists(ltrim($portfolio->cover, '/'))) {
                Storage::disk('public')->delete(ltrim($portfolio->cover, '/'));
            }
            
            $coverFile = $request->file('cover');
            $cover = Image::make($coverFile)->resize(1890, 420)->encode('webp', 80);
            $coverName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/portfolios/covers/' . $coverName, (string) $cover);
            $data['cover'] = "/uploads/portfolios/covers/{$coverName}";
        }

        // SEO Tags Insertion (Helper Function)
        if ($request->seo_tags != null) {
            $data['seo_tags'] = tags($request->seo_tags);
        }

        // Update slug if title_english changed
        if ($request->title_english !== $portfolio->title_english) {
            $data['slug'] = Str::slug($request->title_english);
            
            // Ensure slug is unique (excluding current portfolio)
            $originalSlug = $data['slug'];
            $count = 1;
            while (Portfolio::where('slug', $data['slug'])->where('id', '!=', $id)->exists()) {
                $data['slug'] = $originalSlug . '-' . $count;
                $count++;
            }
        }

        $portfolio->update($data);

        return redirect()->route('portfolio.index')->with('success', 'Portfolio updated successfully!');
    }

    /**
     * Soft delete the portfolio
     */
    public function destroy($id)
    {
        $portfolio = Portfolio::findOrFail($id);
        $portfolio->delete();

        return redirect()->route('portfolio.index')->with('success', 'Portfolio deleted successfully!');
    }

    /**
     * Display trashed portfolios
     */
    public function trashed()
    {
        return view('admin::portfolios.trashed', [
            'data' => $this->portfolio->trashed(),
            'urls' => array(
                'add' => URL::to('admin/portfolio/create'),
                'restore' => URL::to(app()->getLocale().'/admin/portfolio/restore')
            ),
        ]);
    }

    /**
     * Restore trashed portfolio
     */
    public function restore($id)
    {
        $portfolio = Portfolio::withTrashed()->findOrFail($id);
        $portfolio->restore();

        return redirect()->route('portfolio.trashed')->with('success', 'Portfolio restored successfully!');
    }
}

