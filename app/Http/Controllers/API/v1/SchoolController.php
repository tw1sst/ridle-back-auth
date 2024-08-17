<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\School;
use Illuminate\Support\Facades\Auth;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $status = false;
        $schools = '';
        $message = '';

        try {
            if ($schools = School::where('owner_id', Auth::user()->id)->get()) {
                $status = true;
                $message = 'Success';
            }
        } catch (Exception $e) {
            $message = $e;
        }

        return response()->json([
            "status" => $status,
            "message" => $message,
            "schools" => $schools,
        ])->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $status = false;
        $school = '';
        $message = '';

        $validatedData = $request->validate([
            'name' => ['required', 'max:100'],
            'description' => ['required', 'max:255'],
            'nick_name' => ['required', 'unique:schools'],
        ]);

        if ($validatedData) {
            try {
                $school = new School;
                $school->owner_id = Auth::user()->id;
                $school->name = $request->name;
                $school->nick_name = $request->nick_name;
                $school->description = $request->description;
                $school->save();

                $status = true;
                $message = 'Success';
            } catch (Exception $e) {
                $message = $e;
            }
        }

        return response()->json([
            "status" => $status,
            "message" => $message,
            "school" => $school,
        ])->setStatusCode(200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $status = false;
        $school = '';
        $message = '';

        try {
            if ($school = School::find($id)) {
                $status = true;
                $message = 'Success';
            }
        } catch (Exception $e) {
            $message = $e;
        }

        return response()->json([
            "status" => $status,
            "message" => $message,
            "school" => $school,
        ])->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $status = false;
        $message = '';

        if ($school = School::find($id)) {
            if ($school->owner_id === Auth::user()->id) {
                $school->delete();

                $status = true;
                $message = 'Success';
            } else {
                $message = 'Permission Denied';
            }
        } else {
            $message = 'School not found';
        }

        return response()->json([
            "status" => $status,
            "message" => $message,
        ])->setStatusCode(200);
    }
}
