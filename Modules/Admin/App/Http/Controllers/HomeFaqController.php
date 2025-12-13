<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\HomeFaq;
use Illuminate\Support\Facades\URL;

class HomeFaqController extends Controller
{
    protected $homeFaq;

    public function __construct(HomeFaq $homeFaq)
    {
        $this->homeFaq = $homeFaq;
    }

    /**
     * Display a listing of FAQs
     */
    public function index()
    {
        return view('admin::homefaqs.index', [
            'data' => $this->homeFaq->list(),
            'urls' => array(
                'add' => URL::to('admin/homefaq/create'),
                'update' => URL::to('admin/homefaq/edit'),
                'delete' => URL::to(app()->getLocale().'/admin/homefaq/delete')
            ),
        ]);
    }

    /**
     * Show the form for creating a new FAQ
     */
    public function create()
    {
        // Get the next order number
        $nextOrder = HomeFaq::whereNull('deleted_at')->max('order') + 1;
        
        return view('admin::homefaqs.create', [
            'nextOrder' => $nextOrder
        ]);
    }

    /**
     * Store a newly created FAQ
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'question_english' => 'required|string|max:255',
            'question_arabic' => 'required|string|max:255',
            'answer_english' => 'required|string',
            'answer_arabic' => 'required|string',
            'order' => 'required|integer|min:0',
            'status' => 'required|in:0,1',
        ]);

        HomeFaq::create($data);

        return redirect()->route('homefaq.index')->with('success', 'FAQ created successfully!');
    }

    /**
     * Show the form for editing FAQ
     */
    public function edit($id)
    {
        $faq = HomeFaq::findOrFail($id);
        
        return view('admin::homefaqs.edit', [
            'faq' => $faq
        ]);
    }

    /**
     * Update the specified FAQ
     */
    public function update(Request $request, $id)
    {
        $faq = HomeFaq::findOrFail($id);
        
        $data = $request->validate([
            'question_english' => 'required|string|max:255',
            'question_arabic' => 'required|string|max:255',
            'answer_english' => 'required|string',
            'answer_arabic' => 'required|string',
            'order' => 'required|integer|min:0',
            'status' => 'required|in:0,1',
        ]);

        $faq->update($data);

        return redirect()->route('homefaq.index')->with('success', 'FAQ updated successfully!');
    }

    /**
     * Soft delete the FAQ
     */
    public function destroy($id)
    {
        $faq = HomeFaq::findOrFail($id);
        $faq->delete();

        return redirect()->route('homefaq.index')->with('success', 'FAQ deleted successfully!');
    }

    /**
     * Display trashed FAQs
     */
    public function trashed()
    {
        return view('admin::homefaqs.trashed', [
            'data' => $this->homeFaq->trashed(),
            'urls' => array(
                'restore' => URL::to(app()->getLocale().'/admin/homefaq/restore')
            ),
        ]);
    }

    /**
     * Restore trashed FAQ
     */
    public function restore($id)
    {
        $faq = HomeFaq::withTrashed()->findOrFail($id);
        $faq->restore();

        return redirect()->route('homefaq.trashed')->with('success', 'FAQ restored successfully!');
    }
}

