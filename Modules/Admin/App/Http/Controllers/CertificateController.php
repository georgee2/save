<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Certificate;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CertificateController extends Controller
{
    protected $certificate;

    public function __construct(Certificate $certificate)
    {
        $this->certificate = $certificate;
    }

    /**
     * Display a listing of certificates
     */
    public function index()
    {
        $certificates = $this->certificate->list();
        
        return view('admin::certificates.index', [
            'certificates' => $certificates
        ]);
    }

    /**
     * Show the form for creating a new certificate
     */
    public function create()
    {
        $maxOrdering = Certificate::getMaxOrdering();
        return view('admin::certificates.create', [
            'maxOrdering' => $maxOrdering
        ]);
    }

    /**
     * Store a newly created certificate
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'bio_english' => 'nullable|string|max:300',
            'bio_arabic' => 'nullable|string|max:300',
            'ordering' => 'nullable|integer|min:0',
            'publish_status' => 'required|in:0,1',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_certificate_' . uniqid() . '.webp';
            $imagePath = 'certificates/' . $imageName;
            
            // Process image: resize to 400x400 square and convert to WebP
            $img = Image::make($image);
            $img->fit(400, 400, function ($constraint) {
                $constraint->upsize();
            });
            
            // Save as WebP
            Storage::disk('public')->put($imagePath, $img->encode('webp', 90)->__toString());
            $data['image'] = '/' . $imagePath;
        }

        // Set ordering if not provided
        if (empty($data['ordering'])) {
            $data['ordering'] = Certificate::getMaxOrdering() + 1;
        }

        Certificate::create($data);

        return redirect()->route('certificate.index')->with('success', 'Certificate created successfully!');
    }

    /**
     * Show the form for editing certificate
     */
    public function edit($id)
    {
        $certificate = Certificate::findOrFail($id);
        
        return view('admin::certificates.edit', [
            'certificate' => $certificate
        ]);
    }

    /**
     * Update the specified certificate
     */
    public function update(Request $request, $id)
    {
        $certificate = Certificate::findOrFail($id);
        
        $data = $request->validate([
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'bio_english' => 'nullable|string|max:300',
            'bio_arabic' => 'nullable|string|max:300',
            'ordering' => 'nullable|integer|min:0',
            'publish_status' => 'required|in:0,1',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($certificate->image) {
                Storage::disk('public')->delete(ltrim($certificate->image, '/'));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_certificate_' . uniqid() . '.webp';
            $imagePath = 'certificates/' . $imageName;
            
            // Process image: resize to 400x400 square and convert to WebP
            $img = Image::make($image);
            $img->fit(400, 400, function ($constraint) {
                $constraint->upsize();
            });
            
            // Save as WebP
            Storage::disk('public')->put($imagePath, $img->encode('webp', 90)->__toString());
            $data['image'] = '/' . $imagePath;
        }

        $certificate->update($data);

        return redirect()->route('certificate.index')->with('success', 'Certificate updated successfully!');
    }

    /**
     * Soft delete the certificate
     */
    public function destroy($id)
    {
        $certificate = Certificate::findOrFail($id);
        $certificate->delete();

        return redirect()->route('certificate.index')->with('success', 'Certificate deleted successfully!');
    }

    /**
     * Display trashed certificates
     */
    public function trashed()
    {
        $certificates = $this->certificate->trashed();
        
        return view('admin::certificates.trashed', [
            'certificates' => $certificates
        ]);
    }

    /**
     * Restore trashed certificate
     */
    public function restore($id)
    {
        $certificate = Certificate::withTrashed()->findOrFail($id);
        $certificate->restore();

        return redirect()->route('certificate.trashed')->with('success', 'Certificate restored successfully!');
    }

    /**
     * Toggle publish status
     */
    public function toggleStatus($id)
    {
        $certificate = Certificate::findOrFail($id);
        $certificate->publish_status = $certificate->publish_status == 1 ? 0 : 1;
        $certificate->save();

        $status = $certificate->publish_status == 1 ? 'published' : 'unpublished';
        return redirect()->route('certificate.index')->with('success', "Certificate {$status} successfully!");
    }

    /**
     * Update display order for certificates
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'required|integer|exists:certificates,id',
            'orders.*.order' => 'required|integer|min:0',
        ]);
        
        foreach ($request->orders as $item) {
            Certificate::where('id', $item['id'])->update(['ordering' => $item['order']]);
        }
        
        return response()->json(['success' => true, 'message' => 'Order updated successfully!']);
    }
}
