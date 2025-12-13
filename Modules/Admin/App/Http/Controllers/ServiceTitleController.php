<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\URL;
use App\Models\ServiceTitle;

class ServiceTitleController extends Controller
{
    protected $ServiceTitle;

    public function __construct(ServiceTitle $ServiceTitle)
    {
        $this->ServiceTitle = $ServiceTitle;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('admin::service-titles.index', [
            'data' => $this->ServiceTitle->list(),
            'urls' => array(
                'add' => URL::to('admin/service-title/create'),
                'show' => URL::to('admin/service-title/show'),
                'update' => URL::to('admin/service-title/edit'),
                'delete' => URL::to(app()->getLocale() . '/admin/service-title/delete')
            ),
        ]);
    }

    /**
     * Display trashed records
     * @return Renderable
     */
    public function trashed()
    {
        return view('admin::service-titles.trashed', [
            'data' => $this->ServiceTitle->trashed(),
            'urls' => array(
                'add' => URL::to('admin/service-title/create'),
                'restore' => URL::to(app()->getLocale() . '/admin/service-title/restore')
            ),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('admin::service-titles.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        // Validation
        $data = $request->validate([
            'title_english' => 'required|string|max:255',
            'title_arabic' => 'required|string|max:255',
            'subtitle_english' => 'nullable|string|max:255',
            'subtitle_arabic' => 'nullable|string|max:255',
            'target' => 'required|in:features,processes,values,faqs,sub_services',
        ]);

        $this->ServiceTitle->NewRecord($data);

        return redirect()->route('service-title.index')->with('success', 'Service Title Created Successfully!');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('admin::service-titles.show', [
            'ServiceTitle' => $this->ServiceTitle->find($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('admin::service-titles.edit', [
            'ServiceTitle' => $this->ServiceTitle->find($id),
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
        $data = $request->validate([
            'title_english' => 'required|string|max:255',
            'title_arabic' => 'required|string|max:255',
            'subtitle_english' => 'nullable|string|max:255',
            'subtitle_arabic' => 'nullable|string|max:255',
            'target' => 'required|in:features,processes,values,faqs,sub_services',
        ]);

        $this->ServiceTitle->updateRecord($id, $data);

        return redirect()->route('service-title.index')->with('success', 'Service Title Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $this->ServiceTitle->deleteRecord($id);
        return redirect()->route('service-title.trashed')->with('success', 'Service Title Deleted Successfully!');
    }

    /**
     * Restore soft deleted record
     * @param int $id
     * @return Renderable
     */
    public function restore($id)
    {
        $this->ServiceTitle->restore($id);
        return redirect()->route('service-title.index')->with('success', 'Service Title Restored Successfully!');
    }
}

