<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\ServiceFAQ;
use App\Models\FAQ;

class ServiceFAQController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'service_id' => 'required|exists:services,id',
            'faq_id' => 'required|exists:faqs,id',
        ]);

        // Check if already exists
        $exists = ServiceFAQ::where('service_id', $data['service_id'])
            ->where('faq_id', $data['faq_id'])
            ->exists();

        if ($exists) {
            return redirect()->route('service.show', ['id' => $request->service_id])
                ->with('error', 'This FAQ is already added to this service!');
        }

        ServiceFAQ::create($data);

        return redirect()->route('service.show', ['id' => $request->service_id])
            ->with('success', 'FAQ added to service successfully!');
    }

    public function destroy($id)
    {
        $serviceFaq = ServiceFAQ::findOrFail($id);
        $serviceId = $serviceFaq->service_id;

        $serviceFaq->delete();

        return redirect()->route('service.show', ['id' => $serviceId])
            ->with('success', 'FAQ removed from service successfully!');
    }
}

