<?php

namespace Modules\Basicdata\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Currency;

class CurrencyController extends Controller
{
    protected $currency;

    public function __construct(Currency $currency)
    {
        $this->currency = $currency;
    }

    /**
     * Display a listing of currencies
     */
    public function index()
    {
        $currencies = $this->currency->list();
        
        return view('basicdata::currencies.index', [
            'currencies' => $currencies
        ]);
    }

    /**
     * Show the form for creating a new currency
     */
    public function create()
    {
        return view('basicdata::currencies.create');
    }

    /**
     * Store a newly created currency
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'abbreviation' => 'required|string|max:10',
            'status' => 'required|in:0,1',
        ]);

        Currency::create($data);

        return redirect()->route('currency.index')->with('success', 'Currency created successfully!');
    }

    /**
     * Show the form for editing currency
     */
    public function edit($id)
    {
        $currency = Currency::findOrFail($id);
        
        return view('basicdata::currencies.edit', [
            'currency' => $currency
        ]);
    }

    /**
     * Update the specified currency
     */
    public function update(Request $request, $id)
    {
        $currency = Currency::findOrFail($id);
        
        $data = $request->validate([
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'abbreviation' => 'required|string|max:10',
            'status' => 'required|in:0,1',
        ]);

        $currency->update($data);

        return redirect()->route('currency.index')->with('success', 'Currency updated successfully!');
    }

    /**
     * Soft delete the currency
     */
    public function destroy($id)
    {
        $currency = Currency::findOrFail($id);
        $currency->delete();

        return redirect()->route('currency.index')->with('success', 'Currency deleted successfully!');
    }

    /**
     * Display trashed currencies
     */
    public function trashed()
    {
        $currencies = $this->currency->trashed();
        
        return view('basicdata::currencies.trashed', [
            'currencies' => $currencies
        ]);
    }

    /**
     * Restore trashed currency
     */
    public function restore($id)
    {
        $currency = Currency::withTrashed()->findOrFail($id);
        $currency->restore();

        return redirect()->route('currency.trashed')->with('success', 'Currency restored successfully!');
    }
}

