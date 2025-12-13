<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\FAQ;

class FAQController extends Controller
{
    protected $FAQ;

    public function __construct(FAQ $FAQ)
    {
        $this->FAQ = $FAQ;
    }

    /**
     * Display a listing of FAQs
     */
    public function index()
    {
        $faqs = $this->FAQ->list();
        
        return view('admin::faqs.index', [
            'FAQs' => $faqs
        ]);
    }

    /**
     * Show the form for creating a new FAQ
     */
    public function create()
    {
        return view('admin::faqs.create');
    }

    /**
     * Store a newly created FAQ
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'question_english' => 'required|string',
            'question_arabic' => 'required|string',
            'answer_english' => 'required|string',
            'answer_arabic' => 'required|string',
        ]);

        FAQ::create($data);

        return redirect()->route('faq.index')->with('success', 'FAQ created successfully!');
    }

    /**
     * Show the form for editing FAQ
     */
    public function edit($id)
    {
        $faq = $this->FAQ->find($id);
        
        if (!$faq) {
            return redirect()->route('faq.index')->with('error', 'FAQ not found!');
        }
        
        return view('admin::faqs.edit', [
            'FAQ' => $faq
        ]);
    }

    /**
     * Update the specified FAQ
     */
    public function update(Request $request, $id)
    {
        $faq = FAQ::findOrFail($id);
        
        $data = $request->validate([
            'question_english' => 'required|string',
            'question_arabic' => 'required|string',
            'answer_english' => 'required|string',
            'answer_arabic' => 'required|string',
        ]);

        $faq->update($data);

        return redirect()->route('faq.index')->with('success', 'FAQ updated successfully!');
    }

    /**
     * Soft delete the FAQ
     */
    public function destroy($id)
    {
        $faq = FAQ::findOrFail($id);
        $faq->delete();

        return redirect()->route('faq.index')->with('success', 'FAQ deleted successfully!');
    }

    /**
     * Display trashed FAQs
     */
    public function trashed()
    {
        $faqs = $this->FAQ->trashed();
        
        return view('admin::faqs.trashed', [
            'FAQs' => $faqs
        ]);
    }

    /**
     * Restore trashed FAQ
     */
    public function restore($id)
    {
        $faq = FAQ::withTrashed()->findOrFail($id);
        $faq->restore();

        return redirect()->route('faq.trashed')->with('success', 'FAQ restored successfully!');
    }
}

