<?php

namespace Modules\Basicdata\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\PortfolioType;

class PortfolioTypeController extends Controller
{
    protected $portfolioType;

    public function __construct(PortfolioType $portfolioType)
    {
        $this->portfolioType = $portfolioType;
    }

    /**
     * Display a listing of portfolio types
     */
    public function index()
    {
        $portfolioTypes = $this->portfolioType->list();
        
        return view('basicdata::portfoliotypes.index', [
            'portfolioTypes' => $portfolioTypes
        ]);
    }

    /**
     * Show the form for creating a new portfolio type
     */
    public function create()
    {
        return view('basicdata::portfoliotypes.create');
    }

    /**
     * Store a newly created portfolio type
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'status' => 'required|in:0,1',
        ]);

        PortfolioType::create($data);

        return redirect()->route('portfoliotype.index')->with('success', 'Portfolio Type created successfully!');
    }

    /**
     * Show the form for editing portfolio type
     */
    public function edit($id)
    {
        $portfolioType = PortfolioType::findOrFail($id);
        
        return view('basicdata::portfoliotypes.edit', [
            'portfolioType' => $portfolioType
        ]);
    }

    /**
     * Update the specified portfolio type
     */
    public function update(Request $request, $id)
    {
        $portfolioType = PortfolioType::findOrFail($id);
        
        $data = $request->validate([
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'status' => 'required|in:0,1',
        ]);

        $portfolioType->update($data);

        return redirect()->route('portfoliotype.index')->with('success', 'Portfolio Type updated successfully!');
    }

    /**
     * Soft delete the portfolio type
     */
    public function destroy($id)
    {
        $portfolioType = PortfolioType::findOrFail($id);
        $portfolioType->delete();

        return redirect()->route('portfoliotype.index')->with('success', 'Portfolio Type deleted successfully!');
    }

    /**
     * Display trashed portfolio types
     */
    public function trashed()
    {
        $portfolioTypes = $this->portfolioType->trashed();
        
        return view('basicdata::portfoliotypes.trashed', [
            'portfolioTypes' => $portfolioTypes
        ]);
    }

    /**
     * Restore trashed portfolio type
     */
    public function restore($id)
    {
        $portfolioType = PortfolioType::withTrashed()->findOrFail($id);
        $portfolioType->restore();

        return redirect()->route('portfoliotype.trashed')->with('success', 'Portfolio Type restored successfully!');
    }
}

