<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Project;
use App\Models\EngineeringCategory;
use App\Models\EngineeringSubCategory;
use App\Models\Currency;
use App\Models\ProjectStyle;
use App\Models\ProjectType;
use App\Models\Partner;
use App\Models\Emirate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProjectController extends Controller
{
    protected $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    /**
     * Display a listing of projects
     */
    public function index()
    {
        $projects = $this->project->list();
        
        return view('admin::projects.index', [
            'projects' => $projects
        ]);
    }

    /**
     * Show the form for creating a new project
     */
    public function create()
    {
        $categories = EngineeringCategory::whereNull('deleted_at')->orderBy('title_english')->get();
        $currencies = Currency::where('status', 0)->whereNull('deleted_at')->orderBy('name_english')->get();
        $styles = ProjectStyle::whereNull('deleted_at')->orderBy('title_english')->get();
        $types = ProjectType::whereNull('deleted_at')->orderBy('name_english')->get();
        $partners = Partner::whereNull('deleted_at')->orderBy('name_english')->get();
        $emirates = Emirate::whereNull('deleted_at')->orderBy('title_english')->get();
        
        return view('admin::projects.create', compact('categories', 'currencies', 'styles', 'types', 'partners', 'emirates'));
    }

    /**
     * Store a newly created project
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title_english' => 'required|string|max:255',
            'title_arabic' => 'required|string|max:255',
            'category_id' => 'required|exists:engineering_categories,id',
            'subcategory_id' => 'nullable|exists:engineering_sub_categories,id',
            'currency_id' => 'nullable|exists:currencies,id',
            'style_id' => 'nullable|exists:project_styles,id',
            'type_id' => 'required|exists:project_types,id',
            'partner_id' => 'nullable|exists:partners,id',
            'emirate_id' => 'nullable|exists:emirates,id',
            'sqft' => 'nullable|numeric|min:0',
            'sqm' => 'nullable|numeric|min:0',
            'video_url' => 'nullable|url|max:255',
            'tour_url' => 'nullable|url|max:255',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'page_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'site_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'plan_2d_image' => 'nullable|file|mimes:pdf|max:10240',
            'plan_3d_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'description_english' => 'nullable|string|max:3000',
            'description_arabic' => 'nullable|string|max:3000',
            'bio_english' => 'nullable|string|max:500',
            'bio_arabic' => 'nullable|string|max:500',
            'seo_tags' => 'nullable',
            'seo_description_english' => 'nullable|string|max:1000',
            'seo_description_arabic' => 'nullable|string|max:1000',
            'home_status' => 'required|in:0,1',
            'publish_status' => 'required|in:0,1',
        ]);

        // Auto-generate slug from English title
        $data['slug'] = Str::slug($data['title_english']);

        // Handle main_image upload (1080x1080)
        if ($request->hasFile('main_image')) {
            $data['main_image'] = $this->handleImageUpload($request->file('main_image'), 1080, 1080, 'projects/main');
        }

        // Handle cover_image upload (1890x420)
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $this->handleImageUpload($request->file('cover_image'), 1890, 420, 'projects/cover');
        }

        // Handle page_image upload (868x450)
        if ($request->hasFile('page_image')) {
            $data['page_image'] = $this->handleImageUpload($request->file('page_image'), 868, 450, 'projects/page');
        }

        // Handle site_image upload (420x420)
        if ($request->hasFile('site_image')) {
            $data['site_image'] = $this->handleImageUpload($request->file('site_image'), 420, 420, 'projects/site');
        }

        // Handle plan_2d_image upload (PDF file)
        if ($request->hasFile('plan_2d_image')) {
            $data['plan_2d_image'] = $this->handlePdfUpload($request->file('plan_2d_image'), 'projects/files');
        }

        // Handle plan_3d_image upload (870x420)
        if ($request->hasFile('plan_3d_image')) {
            $data['plan_3d_image'] = $this->handleImageUpload($request->file('plan_3d_image'), 870, 420, 'projects/plans_3d');
        }

        // SEO Tags Insertion (Helper Function)
        if($request->seo_tags != null) {
            $data['seo_tags'] = tags($request->seo_tags);
        }

        Project::create($data);

        return redirect()->route('project.index')->with('success', 'Project created successfully!');
    }

    /**
     * Show the form for editing project
     */
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $categories = EngineeringCategory::whereNull('deleted_at')->orderBy('title_english')->get();
        $subcategories = EngineeringSubCategory::where('category_id', $project->category_id)->whereNull('deleted_at')->orderBy('title_english')->get();
        $currencies = Currency::where('status', 0)->whereNull('deleted_at')->orderBy('name_english')->get();
        $styles = ProjectStyle::whereNull('deleted_at')->orderBy('title_english')->get();
        $types = ProjectType::whereNull('deleted_at')->orderBy('name_english')->get();
        $partners = Partner::whereNull('deleted_at')->orderBy('name_english')->get();
        $emirates = Emirate::whereNull('deleted_at')->orderBy('title_english')->get();
        
        return view('admin::projects.edit', compact('project', 'categories', 'subcategories', 'currencies', 'styles', 'types', 'partners', 'emirates'));
    }

    /**
     * Update the specified project
     */
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        
        $data = $request->validate([
            'title_english' => 'required|string|max:255',
            'title_arabic' => 'required|string|max:255',
            'category_id' => 'required|exists:engineering_categories,id',
            'subcategory_id' => 'nullable|exists:engineering_sub_categories,id',
            'currency_id' => 'nullable|exists:currencies,id',
            'style_id' => 'nullable|exists:project_styles,id',
            'type_id' => 'required|exists:project_types,id',
            'partner_id' => 'nullable|exists:partners,id',
            'emirate_id' => 'nullable|exists:emirates,id',
            'sqft' => 'nullable|numeric|min:0',
            'sqm' => 'nullable|numeric|min:0',
            'video_url' => 'nullable|url|max:255',
            'tour_url' => 'nullable|url|max:255',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'page_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'site_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'plan_2d_image' => 'nullable|file|mimes:pdf|max:10240',
            'plan_3d_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'description_english' => 'nullable|string|max:3000',
            'description_arabic' => 'nullable|string|max:3000',
            'bio_english' => 'nullable|string|max:500',
            'bio_arabic' => 'nullable|string|max:500',
            'seo_tags' => 'nullable',
            'seo_description_english' => 'nullable|string|max:1000',
            'seo_description_arabic' => 'nullable|string|max:1000',
            'home_status' => 'required|in:0,1',
            'publish_status' => 'required|in:0,1',
        ]);

        // Auto-generate slug from English title
        $data['slug'] = Str::slug($data['title_english']);

        // Handle main_image upload (1080x1080)
        if ($request->hasFile('main_image')) {
            if ($project->main_image) {
                Storage::disk('public')->delete(ltrim($project->main_image, '/'));
            }
            $data['main_image'] = $this->handleImageUpload($request->file('main_image'), 1080, 1080, 'projects/main');
        }

        // Handle cover_image upload (1890x420)
        if ($request->hasFile('cover_image')) {
            if ($project->cover_image) {
                Storage::disk('public')->delete(ltrim($project->cover_image, '/'));
            }
            $data['cover_image'] = $this->handleImageUpload($request->file('cover_image'), 1890, 420, 'projects/cover');
        }

        // Handle page_image upload (868x450)
        if ($request->hasFile('page_image')) {
            if ($project->page_image) {
                Storage::disk('public')->delete(ltrim($project->page_image, '/'));
            }
            $data['page_image'] = $this->handleImageUpload($request->file('page_image'), 868, 450, 'projects/page');
        }

        // Handle site_image upload (420x420)
        if ($request->hasFile('site_image')) {
            if ($project->site_image) {
                Storage::disk('public')->delete(ltrim($project->site_image, '/'));
            }
            $data['site_image'] = $this->handleImageUpload($request->file('site_image'), 420, 420, 'projects/site');
        }

        // Handle plan_2d_image upload (PDF file)
        if ($request->hasFile('plan_2d_image')) {
            if ($project->plan_2d_image) {
                Storage::disk('public')->delete(ltrim($project->plan_2d_image, '/'));
            }
            $data['plan_2d_image'] = $this->handlePdfUpload($request->file('plan_2d_image'), 'projects/files');
        }

        // Handle plan_3d_image upload (870x420)
        if ($request->hasFile('plan_3d_image')) {
            if ($project->plan_3d_image) {
                Storage::disk('public')->delete(ltrim($project->plan_3d_image, '/'));
            }
            $data['plan_3d_image'] = $this->handleImageUpload($request->file('plan_3d_image'), 870, 420, 'projects/plans_3d');
        }

        // SEO Tags Insertion (Helper Function)
        if($request->seo_tags != null) {
            $data['seo_tags'] = tags($request->seo_tags);
        }

        $project->update($data);

        return redirect()->route('project.index')->with('success', 'Project updated successfully!');
    }

    /**
     * Display the specified project
     */
    public function show($id)
    {
        $project = $this->project->findWithRelations($id);
        
        if (!$project) {
            return redirect()->route('project.index')->with('error', 'Project not found!');
        }
        
        return view('admin::projects.show', compact('project'));
    }

    /**
     * Soft delete the project
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->route('project.index')->with('success', 'Project deleted successfully!');
    }

    /**
     * Display trashed projects
     */
    public function trashed()
    {
        $projects = $this->project->trashed();
        
        return view('admin::projects.trashed', compact('projects'));
    }

    /**
     * Restore trashed project
     */
    public function restore($id)
    {
        $project = Project::withTrashed()->findOrFail($id);
        $project->restore();

        return redirect()->route('project.trashed')->with('success', 'Project restored successfully!');
    }

    /**
     * Toggle publish status
     */
    public function togglePublish($id)
    {
        $project = Project::findOrFail($id);
        $project->publish_status = $project->publish_status == 0 ? 1 : 0;
        $project->save();

        $status = $project->publish_status == 0 ? 'published' : 'unpublished';
        return redirect()->back()->with('success', "Project {$status} successfully!");
    }

    /**
     * Toggle home feature status
     */
    public function toggleHomeFeature($id)
    {
        $project = Project::findOrFail($id);
        $project->home_status = $project->home_status == 0 ? 1 : 0;
        $project->save();

        $status = $project->home_status == 0 ? 'shown on home' : 'hidden from home';
        return redirect()->back()->with('success', "Project {$status} successfully!");
    }
    
    /**
     * Toggle feasibility studies visibility on website
     */
    public function toggleFeasibilityStudies($id)
    {
        $project = Project::findOrFail($id);
        $project->show_feasibility_studies = $project->show_feasibility_studies == 0 ? 1 : 0;
        $project->save();

        $status = $project->show_feasibility_studies == 0 ? 'shown on website' : 'hidden from website';
        return redirect()->back()->with('success', "Feasibility Studies {$status} successfully!");
    }

    /**
     * Get subcategories by category (AJAX)
     */
    public function getSubcategories(Request $request)
    {
        $subcategories = EngineeringSubCategory::where('category_id', $request->category_id)
            ->whereNull('deleted_at')
            ->orderBy('title_english')
            ->get();
        
        return response()->json($subcategories);
    }
    
    /**
     * Handle image upload, convert to WebP and resize
     * 
     * @param \Illuminate\Http\UploadedFile $file
     * @param int $width
     * @param int $height
     * @param string $folder
     * @return string
     */
    private function handleImageUpload($file, $width, $height, $folder)
    {
        // Generate unique filename
        $filename = time() . '_' . uniqid() . '.webp';
        
        // Create image instance and resize
        $image = Image::make($file->getRealPath())
            ->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode('webp', 80);
        
        // Save image using Storage::disk('public')
        Storage::disk('public')->put('/uploads/' . $folder . '/' . $filename, (string) $image);
        
        return '/uploads/' . $folder . '/' . $filename;
    }

    /**
     * Handle PDF file upload
     */
    private function handlePdfUpload($file, $folder)
    {
        // Generate unique filename
        $filename = time() . '_' . uniqid() . '.pdf';
        
        // Store the PDF file using Storage::disk('public')
        Storage::disk('public')->put('/uploads/' . $folder . '/' . $filename, file_get_contents($file->getRealPath()));
        
        return '/uploads/' . $folder . '/' . $filename;
    }
}

