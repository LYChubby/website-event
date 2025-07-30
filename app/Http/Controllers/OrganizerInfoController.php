<?php

namespace App\Http\Controllers;

use App\Models\OrganizerInfo;
use App\Http\Requests\OrganizerInfoRequest;
use Illuminate\Http\Request;

class OrganizerInfoController extends Controller
{
    public function index()
    {
        $data = OrganizerInfo::with('user')->get();
        return response()->json($data);
    }

    public function store(OrganizerInfoRequest $request)
    {
        $organizerInfo = OrganizerInfo::create($request->validated());
        return response()->json($organizerInfo, 201);
    }

    public function show($id)
    {
        $organizerInfo = OrganizerInfo::with('user')->findOrFail($id);
        return response()->json($organizerInfo);
    }

    public function update(OrganizerInfoRequest $request, $id)
    {
        $organizerInfo = OrganizerInfo::findOrFail($id);
        $organizerInfo->update($request->validated());
        return response()->json($organizerInfo);
    }

    public function destroy($id)
    {
        $organizerInfo = OrganizerInfo::findOrFail($id);
        $organizerInfo->delete();
        return response()->json(['message' => 'Organizer info deleted successfully.']);
    }
}
