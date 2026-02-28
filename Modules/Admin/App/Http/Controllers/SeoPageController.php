<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\SeoPage;

class SeoPageController extends Controller
{
    public function index()
    {
        $seoPages = SeoPage::orderBy('id')->get();
        return view('admin::seo-pages.index', compact('seoPages'));
    }

    public function edit($id)
    {
        $seoPage = SeoPage::findOrFail($id);
        return view('admin::seo-pages.edit', compact('seoPage'));
    }

    public function update(Request $request, $id)
    {
        $seoPage = SeoPage::findOrFail($id);

        $request->validate([
            'seo_title_english' => 'nullable|string|max:255',
            'seo_title_arabic' => 'nullable|string|max:255',
            'seo_description_english' => 'nullable|string|max:500',
            'seo_description_arabic' => 'nullable|string|max:500',
            'seo_tags' => 'nullable|string|max:500',
        ]);

        $data = $request->only([
            'seo_title_english',
            'seo_title_arabic',
            'seo_description_english',
            'seo_description_arabic',
        ]);

        if ($request->seo_tags != null) {
            $data['seo_tags'] = tags($request->seo_tags);
        } else {
            $data['seo_tags'] = null;
        }

        $seoPage->update($data);

        return redirect()->route('admin.seo-pages.index')->with('success', 'SEO for "' . $seoPage->page_name . '" updated successfully!');
    }
}
