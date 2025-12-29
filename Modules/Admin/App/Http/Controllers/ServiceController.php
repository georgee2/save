<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Image;

use App\Models\Service;


class ServiceController extends Controller
{
    protected $Service;



    public function __construct(Service $Service)
    {
            $this->Service = $Service;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    { 
            return view('admin::services.index', [
            'data' =>  $this->Service->list(),
            'urls' => array(

                'add' => URL::to('admin/service/create'),
                'show' => URL::to('admin/service/show'),
                'update' => URL::to('admin/service/edit'),
                'delete' => URL::to(app()->getLocale().'/admin/service/delete')
            ),
        ]);
    }

    public function trashed()
    { 
            return view('admin::services.trashed', [
            'data' =>  $this->Service->trashed(),
            'urls' => array(

                'add' => URL::to('admin/project/create'),
                'restore' => URL::to(app()->getLocale().'/admin/service/restore')
            ),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('admin::services.create', [
            'MainServices' => $this->Service->getMainServices()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
       //Validation
       $data =  $request->validate([
        'title_english' => 'required',
        'title_arabic' => 'required',
        'bio_english' => 'required|max:2000',
        'bio_arabic' => 'required|max:2000',
        'description_english' => 'required',
        'description_arabic' => 'required',
        'main_image' => 'required|image|mimes:png,jpg,jpeg|max:2000',
        'service_home_image' => 'nullable|image|mimes:png,jpg,jpeg|max:2000',
        'icon' => 'nullable|image|mimes:png,jpg,jpeg|max:2000',
        'hero_image' => 'nullable|image|mimes:png,jpg,jpeg|max:2000',
        'service_id' => 'nullable|numeric',
        'seo_tags' => 'nullable',
        'seo_des_en' => 'nullable|max:1000',
        'seo_des_ar' => 'nullable|max:1000',
        'is_sub_service' => 'nullable|boolean',
        'publish_status' => 'nullable|in:0,1',
        'home_feature_status' => 'nullable|in:0,1',
    ]);

    $data['slug'] = Str::slug($request->title_english);
    $data['is_sub_service'] = $request->has('is_sub_service') ? 1 : 0;
    $data['publish_status'] = $request->input('publish_status', 0);
    $data['home_feature_status'] = $request->input('home_feature_status', 0);

        // Main Image Upload
        if ($request->has('main_image') != null) {
                $classifiedImg = $request->file('main_image');
                $filename = $classifiedImg->getClientOriginalExtension();
                $image = Image::make($classifiedImg)->resize(870,450)->encode('webp', 70);

                $imageName = Str::random() . ".webp";
                Storage::disk('public')->put( '/uploads/services/' . $imageName ,(string) $image);
                $data['main_image'] = "/uploads/services/{$imageName}";
            }

        // Service Home Image Upload (870x450)
        if ($request->has('service_home_image') != null) {
                $classifiedImg = $request->file('service_home_image');
                $filename = $classifiedImg->getClientOriginalExtension();
                $image = Image::make($classifiedImg)->resize(870,450)->encode('webp', 80);

                $imageName = Str::random() . ".webp";
                Storage::disk('public')->put( '/uploads/services/home/' . $imageName ,(string) $image);
                $data['service_home_image'] = "/uploads/services/home/{$imageName}";
            }

        // Icon Upload
        if ($request->has('icon') != null) {
                $classifiedImg = $request->file('icon');
                $filename = $classifiedImg->getClientOriginalExtension();
                $image = Image::make($classifiedImg)->resize(100,100)->encode('webp', 100);

                $imageName = Str::random() . ".webp";
                Storage::disk('public')->put( '/uploads/servicesicon/' . $imageName ,(string) $image);
                $data['icon'] = "/uploads/servicesicon/{$imageName}";
            }
            
        // Hero Image Upload
        if ($request->has('hero_image') != null) {
                $classifiedImg = $request->file('hero_image');
                $filename = $classifiedImg->getClientOriginalExtension();
                $image = Image::make($classifiedImg)->resize(1890,420)->encode('webp', 60);

                $imageName = Str::random() . ".webp";
                Storage::disk('public')->put( '/uploads/servicescover/' . $imageName ,(string) $image);
                $data['hero_image'] = "/uploads/servicescover/{$imageName}";
            }

    //SEO Tags Insertion (Helper Function)
     if($request->seo_tags != null)
     {
         $data['seo_tags'] = tags($request->seo_tags);
     }
     
     //SEO Description Insertion
     if($request->seo_des_en != null)
     {
         $data['seo_des_en'] = $request->seo_des_en;
     }

     if($request->seo_des_ar != null)
     {
         $data['seo_des_ar'] = $request->seo_des_ar;
     }

     $Service = $this->Service->NewRecord($data);
     
     //Status
     return redirect()->route('service.index')->with('success','Record Created Successfully !');

    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('admin::services.edit',[
            'Service' => $this->Service->find($id),
            'MainServices' => $this->Service->getMainServices()
        ]);
    }


    public function show($id)
    {
        $service = $this->Service->find($id);
        $serviceModel = Service::with(['features', 'values', 'processes', 'blocks', 'serviceFaqs.faq', 'sectionOrders.block'])->findOrFail($id);
        
        // Get all FAQs for the dropdown
        $allFaqs = \App\Models\FAQ::whereNull('deleted_at')->orderBy('question_english')->get();
        
        return view('admin::services.show',[
            'Service' => $service,
            'ServiceModel' => $serviceModel,
            'Features' => $serviceModel->features,
            'Values' => $serviceModel->values,
            'Processes' => $serviceModel->processes,
            'Blocks' => $serviceModel->blocks,
            'ServiceFAQs' => $serviceModel->serviceFaqs,
            'AllFAQs' => $allFaqs,
            'SectionOrders' => $serviceModel->sectionOrders,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $data =  $request->validate([
            'title_english' => 'required',
            'title_arabic' => 'required',
            'bio_english' => 'required|max:2000',
            'bio_arabic' => 'required|max:2000',
            'description_english' => 'required',
            'description_arabic' => 'required',
            'main_image' => 'nullable|image|mimes:png,jpg,jpeg|max:2000',
            'service_home_image' => 'nullable|image|mimes:png,jpg,jpeg|max:2000',
            'icon' => 'nullable|image|mimes:png,jpg,jpeg|max:2000',
            'hero_image' => 'nullable|image|mimes:png,jpg,jpeg|max:2000',
            'service_id' => 'nullable|numeric',
            'seo_tags' => 'nullable',
            'seo_des_en' => 'nullable|max:1000',
            'seo_des_ar' => 'nullable|max:1000',
            'is_sub_service' => 'nullable|boolean',
            'publish_status' => 'nullable|in:0,1',
            'home_feature_status' => 'nullable|in:0,1',
        ]);

        $data['slug'] = Str::slug($request->title_english);
        $data['is_sub_service'] = $request->has('is_sub_service') ? 1 : 0;
        $data['publish_status'] = $request->input('publish_status', 0);
        $data['home_feature_status'] = $request->input('home_feature_status', 0);

        // Main Image Upload
        if ($request->has('main_image') != null) {
                $classifiedImg = $request->file('main_image');
                $filename = $classifiedImg->getClientOriginalExtension();
                $image = Image::make($classifiedImg)->resize(870,450)->encode('webp', 70);

                $imageName = Str::random() . ".webp";
                Storage::disk('public')->put( '/uploads/services/' . $imageName ,(string) $image);
                $data['main_image'] = "/uploads/services/{$imageName}";
            }

        // Service Home Image Upload (870x450)
        if ($request->has('service_home_image') != null) {
                $classifiedImg = $request->file('service_home_image');
                $filename = $classifiedImg->getClientOriginalExtension();
                $image = Image::make($classifiedImg)->resize(870,450)->encode('webp', 80);

                $imageName = Str::random() . ".webp";
                Storage::disk('public')->put( '/uploads/services/home/' . $imageName ,(string) $image);
                $data['service_home_image'] = "/uploads/services/home/{$imageName}";
            }

        // Icon Upload
        if ($request->has('icon') != null) {
                $classifiedImg = $request->file('icon');
                $filename = $classifiedImg->getClientOriginalExtension();
                $image = Image::make($classifiedImg)->resize(100,100)->encode('webp', 100);

                $imageName = Str::random() . ".webp";
                Storage::disk('public')->put( '/uploads/servicesicon/' . $imageName ,(string) $image);
                $data['icon'] = "/uploads/servicesicon/{$imageName}";
            }
            
        // Hero Image Upload
        if ($request->has('hero_image') != null) {
                $classifiedImg = $request->file('hero_image');
                $filename = $classifiedImg->getClientOriginalExtension();
                $image = Image::make($classifiedImg)->resize(1890,420)->encode('webp', 60);

                $imageName = Str::random() . ".webp";
                Storage::disk('public')->put( '/uploads/servicescover/' . $imageName ,(string) $image);
                $data['hero_image'] = "/uploads/servicescover/{$imageName}";
            }

        //SEO Tags Insertion (Helper Function)
         if($request->seo_tags != null)
         {
             $data['seo_tags'] = tags($request->seo_tags);
         }
         
         //SEO Description Insertion
         if($request->seo_des_en != null)
         {
             $data['seo_des_en'] = $request->seo_des_en;
         }

         if($request->seo_des_ar != null)
         {
             $data['seo_des_ar'] = $request->seo_des_ar;
         }

        $this->Service->updateRecord($id,$data);
        return redirect()->route('service.index')->with('success', 'Record Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $this->Service->deleteRecord($id);
        return redirect()->route('service.trashed')->with('success', 'Record Deleted Successfully !');
    }

    public function restore($id)
    {
        $this->Service->restore($id);
        return redirect()->route('service.index')->with('success', 'Record Deleted Successfully !');
    }

    /**
     * Toggle publish status
     */
    public function togglePublish($id)
    {
        $service = Service::findOrFail($id);
        $service->publish_status = $service->publish_status == 0 ? 1 : 0;
        $service->save();

        $status = $service->publish_status == 0 ? 'Published' : 'Unpublished';
        return redirect()->route('service.show', ['id' => $id])
            ->with('success', "Service {$status} successfully!");
    }

    /**
     * Toggle home feature status
     */
    public function toggleHomeFeature($id)
    {
        $service = Service::findOrFail($id);
        $service->home_feature_status = $service->home_feature_status == 0 ? 1 : 0;
        $service->save();

        $status = $service->home_feature_status == 0 ? 'shown on home page' : 'hidden from home page';
        return redirect()->route('service.show', ['id' => $id])
            ->with('success', "Service {$status} successfully!");
    }
}
