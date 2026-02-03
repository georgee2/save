<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Image;

use App\Models\Newscategory;
use App\Models\News;


class NewsController extends Controller
{
    protected $Newscategory;
    protected $News;



    public function __construct(Newscategory $Newscategory,News $News)
    {
            $this->Newscategory = $Newscategory;
            $this->News = $News;

    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    { 
            return view('admin::news.index', [
            'data' =>  $this->News->list(),
            'urls' => array(

                'add' => URL::to('admin/news-back/create'),
                'update' => URL::to('admin/news-back/edit'),
                'delete' => URL::to(app()->getLocale().'/admin/news-back/delete')
            ),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('admin::news.create',[
            'Category' => $this->Newscategory->getscopes()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
       //Vaildation
       $data =  $request->validate([
        'title_english' => 'required',
        'title_arabic' => 'required',
        'body_english' => 'required',
        'body_arabic' => 'required',
        'image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:5000',
        'page_image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:5000',
        'cover' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:5000',
        'seo_tags' => 'nullable',
        'seo_des_en' => 'nullable|max:1000',
        'seo_des_ar' => 'nullable|max:1000',
        'category_code' => 'required|numeric'
    ]);
    
    // Set default 'none' values for hidden fields
    $data['bio_english'] = 'none';
    $data['bio_arabic'] = 'none';
    $data['button_text'] = 'none';
    $data['button_text_arabic'] = 'none';
    $data['link_english'] = 'none';
    $data['link_arabic'] = 'none';

    $data['slug'] = Str::slug($request->title_english);

        // Main Image Upload (600x600 - Square)
        if ($request->hasFile('image')) {
                $classifiedImg = $request->file('image');
                $image = Image::make($classifiedImg)->fit(600, 600)->encode('webp', 80);
                $imageName = Str::random() . ".webp";
                Storage::disk('public')->put('/uploads/news/main/' . $imageName, (string) $image);
                $data['image'] = "/uploads/news/main/{$imageName}";
            }

        // Page Image Upload (870x450)
        if ($request->hasFile('page_image')) {
                $classifiedImg = $request->file('page_image');
                $image = Image::make($classifiedImg)->resize(870, 450)->encode('webp', 80);
                $imageName = Str::random() . ".webp";
                Storage::disk('public')->put('/uploads/news/page/' . $imageName, (string) $image);
                $data['page_image'] = "/uploads/news/page/{$imageName}";
            }

        // Cover Image Upload (1890x420)
        if ($request->hasFile('cover')) {
                $classifiedImg = $request->file('cover');
                $image = Image::make($classifiedImg)->resize(1890, 420)->encode('webp', 80);
                $imageName = Str::random() . ".webp";
                Storage::disk('public')->put('/uploads/news/cover/' . $imageName, (string) $image);
                $data['cover'] = "/uploads/news/cover/{$imageName}";
            }

    //SEO Tags Insertion (Helper Fuction)
     if($request->seo_tags != null)
     {
         //SEO Tags
         $data['seo_tags'] = tags($request->seo_tags);
     }
     //SEO Description Insertion
     if($request->seo_des_en != null)
     {
         //SEO Tags
         $data['seo_des_en'] = $request->seo_des_en;
     }

     if($request->seo_des_ar != null)
     {
         //SEO Tags
         $data['seo_des_ar'] = $request->seo_des_ar;
     }

     $News = $this->News->NewRecord($data);
     
     //Status
     return redirect()->route('news-back.index')->with('success','Record Created Successfully !');

    }


    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('admin::news.edit',[
            'News' => $this->News->find($id),
            'Category' => $this->Newscategory->getscopes()
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
            'body_english' => 'required',
            'body_arabic' => 'required',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:5000',
            'page_image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:5000',
            'cover' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:5000',
            'seo_tags' => 'nullable',
            'seo_des_en' => 'nullable|max:1000',
            'seo_des_ar' => 'nullable|max:1000',
            'category_code' => 'nullable|numeric'

        ]);
        
        // Set default 'none' values for hidden fields
        $data['bio_english'] = 'none';
        $data['bio_arabic'] = 'none';
        $data['button_text'] = 'none';
        $data['button_text_arabic'] = 'none';
        $data['link_english'] = 'none';
        $data['link_arabic'] = 'none';

        $data['slug'] = Str::slug($request->title_english);

        // Main Image Upload (600x600 - Square)
        if ($request->hasFile('image')) {
                $classifiedImg = $request->file('image');
                $image = Image::make($classifiedImg)->fit(600, 600)->encode('webp', 80);
                $imageName = Str::random() . ".webp";
                Storage::disk('public')->put('/uploads/news/main/' . $imageName, (string) $image);
                $data['image'] = "/uploads/news/main/{$imageName}";
            }

        // Page Image Upload (870x450)
        if ($request->hasFile('page_image')) {
                $classifiedImg = $request->file('page_image');
                $image = Image::make($classifiedImg)->resize(870, 450)->encode('webp', 80);
                $imageName = Str::random() . ".webp";
                Storage::disk('public')->put('/uploads/news/page/' . $imageName, (string) $image);
                $data['page_image'] = "/uploads/news/page/{$imageName}";
            }

        // Cover Image Upload (1890x420)
        if ($request->hasFile('cover')) {
                $classifiedImg = $request->file('cover');
                $image = Image::make($classifiedImg)->resize(1890, 420)->encode('webp', 80);
                $imageName = Str::random() . ".webp";
                Storage::disk('public')->put('/uploads/news/cover/' . $imageName, (string) $image);
                $data['cover'] = "/uploads/news/cover/{$imageName}";
            }

        //SEO Tags Insertion (Helper Fuction)
         if($request->seo_tags != null)
         {
             //SEO Tags
             $data['seo_tags'] = tags($request->seo_tags);
         }
         //SEO Description Insertion
         if($request->seo_des_en != null)
         {
             //SEO Tags
             $data['seo_des_en'] = $request->seo_des_en;
         }

         if($request->seo_des_ar != null)
         {
             //SEO Tags
             $data['seo_des_ar'] = $request->seo_des_ar;
         }

        $this->News->updateRecord($id,$data);
        return redirect()->route('news-back.index')->with('success', 'Record Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $this->News->deleteRecord($id);
        return redirect()->route('news-back.index')->with('success', 'Record Deleted Successfully !');
    }
}
