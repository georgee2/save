<?php

namespace Modules\Basicdata\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\IncomeComponent;
use App\Models\ProjectType;
use Illuminate\Support\Facades\Storage;

class IncomeComponentController extends Controller
{
    protected $incomeComponent;

    public function __construct(IncomeComponent $incomeComponent)
    {
        $this->incomeComponent = $incomeComponent;
    }

    public function index()
    {
        $components = $this->incomeComponent->list();
        return view('basicdata::incomecomponents.index', ['components' => $components]);
    }

    public function create()
    {
        $projectTypes = ProjectType::whereNull('deleted_at')->orderBy('name_english')->get();
        return view('basicdata::incomecomponents.create', ['projectTypes' => $projectTypes]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'project_type_id' => 'required|exists:project_types,id',
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:1024',
        ]);

        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $iconName = time() . '_icon_' . uniqid() . '.' . $icon->getClientOriginalExtension();
            $iconPath = $icon->storeAs('income_components/icons', $iconName, 'public');
            $data['icon'] = '/' . $iconPath;
        }

        IncomeComponent::create($data);
        return redirect()->route('incomecomponent.index')->with('success', 'Income Component created successfully!');
    }

    public function edit($id)
    {
        $component = IncomeComponent::findOrFail($id);
        $projectTypes = ProjectType::whereNull('deleted_at')->orderBy('name_english')->get();
        return view('basicdata::incomecomponents.edit', ['component' => $component, 'projectTypes' => $projectTypes]);
    }

    public function update(Request $request, $id)
    {
        $component = IncomeComponent::findOrFail($id);
        
        $data = $request->validate([
            'project_type_id' => 'required|exists:project_types,id',
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:1024',
        ]);

        if ($request->hasFile('icon')) {
            if ($component->icon) {
                Storage::disk('public')->delete(ltrim($component->icon, '/'));
            }
            $icon = $request->file('icon');
            $iconName = time() . '_icon_' . uniqid() . '.' . $icon->getClientOriginalExtension();
            $iconPath = $icon->storeAs('income_components/icons', $iconName, 'public');
            $data['icon'] = '/' . $iconPath;
        }

        $component->update($data);
        return redirect()->route('incomecomponent.index')->with('success', 'Income Component updated successfully!');
    }

    public function destroy($id)
    {
        $component = IncomeComponent::findOrFail($id);
        $component->delete();
        return redirect()->route('incomecomponent.index')->with('success', 'Income Component deleted successfully!');
    }

    public function trashed()
    {
        $components = $this->incomeComponent->trashed();
        return view('basicdata::incomecomponents.trashed', ['components' => $components]);
    }

    public function restore($id)
    {
        $component = IncomeComponent::withTrashed()->findOrFail($id);
        $component->restore();
        return redirect()->route('incomecomponent.trashed')->with('success', 'Income Component restored successfully!');
    }
}


