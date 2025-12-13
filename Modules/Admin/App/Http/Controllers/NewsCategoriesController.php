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

class NewsCategoriesController extends Controller
{
    protected $Newscategory;



    public function __construct(Newscategory $Newscategory)
    {
            $this->Newscategory = $Newscategory;


    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    { 
            return view('admin::newscategories.index', [
            'data' =>  $this->Newscategory->list(),
            'urls' => array(

                'add' => URL::to('admin/newscategories/create'),
                'update' => URL::to('admin/newscategories/edit'),
                'delete' => URL::to(app()->getLocale().'/admin/newscategories/delete')
            ),
        ]);
    }

    public function trashed()
    { 
            return view('admin::newscategories.trashed', [
            'data' =>  $this->Newscategory->trashed(),
            'urls' => array(

                'add' => URL::to('admin/newscategories/create'),
                'restore' => URL::to(app()->getLocale().'/admin/newscategories/restore')
            ),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('admin::newscategories.create');
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
        'name_english' => 'required|unique:newscategories',
        'name_arabic' => 'required|unique:newscategories',
    ]);

       $data['slug'] = Str::slug($request->name_english);

     $Newscategory = $this->Newscategory->NewRecord($data);
     
     //Status
     return redirect()->route('newscategories.index')->with('success',  'Record Created Successfully !');

    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('admin::newscategories.edit',[
            'Category' => $this->Newscategory->find($id),
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
            'name_english' => 'required|unique:newscategories,id,' . $id,
            'name_arabic' => 'required|unique:newscategories,id,' . $id,
        ]);

        $data['slug'] = Str::slug($request->name_english);


        $this->Newscategory->updateRecord($id,$data);
        return redirect()->route('newscategories.index')->with('success', 'Record Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $this->Newscategory->deleteRecord($id);
        return redirect()->route('newscategories.trashed')->with('success', 'Record Deleted Successfully !');
    }

    public function restore($id)
    {
        $this->Newscategory->restore($id);
        return redirect()->route('newscategories.index')->with('success', 'Record Updated Successfully !');
    }
}
