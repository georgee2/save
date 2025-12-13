<?php

namespace Modules\Basicdata\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\SubstationRoom;
use App\Models\ProjectType;

class SubstationRoomController extends Controller
{
    protected $substationRoom;

    public function __construct(SubstationRoom $substationRoom)
    {
        $this->substationRoom = $substationRoom;
    }

    public function index()
    {
        $rooms = $this->substationRoom->list();
        return view('basicdata::substationrooms.index', ['rooms' => $rooms]);
    }

    public function create()
    {
        $projectTypes = ProjectType::whereNull('deleted_at')->orderBy('name_english')->get();
        return view('basicdata::substationrooms.create', ['projectTypes' => $projectTypes]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'project_type_id' => 'nullable|exists:project_types,id',
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        SubstationRoom::create($data);
        return redirect()->route('substationroom.index')->with('success', 'Substation Room created successfully!');
    }

    public function edit($id)
    {
        $room = SubstationRoom::findOrFail($id);
        $projectTypes = ProjectType::whereNull('deleted_at')->orderBy('name_english')->get();
        return view('basicdata::substationrooms.edit', ['room' => $room, 'projectTypes' => $projectTypes]);
    }

    public function update(Request $request, $id)
    {
        $room = SubstationRoom::findOrFail($id);
        
        $data = $request->validate([
            'project_type_id' => 'nullable|exists:project_types,id',
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $room->update($data);
        return redirect()->route('substationroom.index')->with('success', 'Substation Room updated successfully!');
    }

    public function destroy($id)
    {
        $room = SubstationRoom::findOrFail($id);
        $room->delete();
        return redirect()->route('substationroom.index')->with('success', 'Substation Room deleted successfully!');
    }

    public function trashed()
    {
        $rooms = $this->substationRoom->trashed();
        return view('basicdata::substationrooms.trashed', ['rooms' => $rooms]);
    }

    public function restore($id)
    {
        $room = SubstationRoom::withTrashed()->findOrFail($id);
        $room->restore();
        return redirect()->route('substationroom.trashed')->with('success', 'Substation Room restored successfully!');
    }
}

