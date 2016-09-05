<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use App\Room;
use App\ClassType;
use App\Http\Requests;
use App\Http\Requests\RoomRequest;
use App\Http\Controllers\Controller;

class RoomsController extends Controller
{
    public function index()
    {
        $rooms = room::all();

        return view('rooms.index')->with('rooms', $rooms);
    }

    public function show(Room $room)
    {
        return view('rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        $classTypes = ClassType::all();
        $room->load('classTypes');

        return view('rooms.edit', compact('room', 'classTypes'));
    }

    public function create()
    {
        $room = new Room;
        $classTypes = ClassType::all();

        return view('rooms.create', compact('classTypes', 'room'));
    }

    public function store(RoomRequest $request)
    {
        $room = Room::create($request->all());

        $room->classTypes()->sync($request->class_type_list ?? []);

        Session::flash('message', 'Successfully added room ' . $room->name);

        return redirect('rooms');
    }

    public function update(Room $room, RoomRequest $request)
    {
        $room->update($request->all());

        // Using PHP7 null coalise operator ??
        $room->classTypes()->sync($request->class_type_list ?? []);

        Session::flash('message', 'Successfully updated room ' . $room->name);

        return redirect('rooms');
    }

    public function destroy(Room $room)
    {
        $room->destroy($room->id);

        Session::flash('message', 'Successfully deleted room ' . $room->name);

        return redirect('rooms');
    }
}
