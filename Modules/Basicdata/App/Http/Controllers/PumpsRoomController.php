<?php

namespace Modules\Basicdata\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\PumpsRoom;
use App\Models\ProjectType;

class PumpsRoomController extends Controller
{
    protected $pumpsRoom;

    public function __construct(PumpsRoom $pumpsRoom)
    {
        $this->pumpsRoom = $pumpsRoom;
    }

    public function index()
    {
        $rooms = $this->pumpsRoom->list();
        return view('basicdata::pumpsrooms.index', ['rooms' => $rooms]);
    }

    public function create()
    {
        $projectTypes = ProjectType::whereNull('deleted_at')->orderBy('name_english')->get();
        return view('basicdata::pumpsrooms.create', ['projectTypes' => $projectTypes]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'project_type_id' => 'nullable|exists:project_types,id',
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        PumpsRoom::create($data);
        return redirect()->route('pumpsroom.index')->with('success', 'Pumps Room created successfully!');
    }

    public function edit($id)
    {
        $room = PumpsRoom::findOrFail($id);
        $projectTypes = ProjectType::whereNull('deleted_at')->orderBy('name_english')->get();
        return view('basicdata::pumpsrooms.edit', ['room' => $room, 'projectTypes' => $projectTypes]);
    }

    public function update(Request $request, $id)
    {
        $room = PumpsRoom::findOrFail($id);
        
        $data = $request->validate([
            'project_type_id' => 'nullable|exists:project_types,id',
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $room->update($data);
        return redirect()->route('pumpsroom.index')->with('success', 'Pumps Room updated successfully!');
    }

    public function destroy($id)
    {
        $room = PumpsRoom::findOrFail($id);
        $room->delete();
        return redirect()->route('pumpsroom.index')->with('success', 'Pumps Room deleted successfully!');
    }

    public function trashed()
    {
        $rooms = $this->pumpsRoom->trashed();
        return view('basicdata::pumpsrooms.trashed', ['rooms' => $rooms]);
    }

    public function restore($id)
    {
        $room = PumpsRoom::withTrashed()->findOrFail($id);
        $room->restore();
        return redirect()->route('pumpsroom.trashed')->with('success', 'Pumps Room restored successfully!');
    }
}

