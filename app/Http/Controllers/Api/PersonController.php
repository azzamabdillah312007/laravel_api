<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PersonResource;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $person = Person::all();
        return PersonResource::collection($person)->additional(['status' => 'true', 'message' => 'Data berhasil di temukan'])->response()->setStatusCode(200);

        // return response()->json([
        //     'status' => true,
        //     'message' => 'data berhasil di temukan',
        //     'data' => $person
        // ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validasi error',
                'errors' => $validator->errors()
            ], 422);
        }

        $person = Person::create($request->all());
        return (new PersonResource($person))->additional(['status' => 'true', 'message' => 'Data berhasil di tambahkan'])->response()->setStatusCode(201);

        // return response()->json([
        //     'status' => true,
        //     'message' => 'data berhasil di masukan',
        //     'data' => $person
        // ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $person = Person::findOrFail($id);
        return (new PersonResource($person))->additional(['status' => 'true', 'message' => 'Data berhasil di tampilkan'])->response()->setStatusCode(200);

        // return response()->json([
        //     'status' => true,
        //     'message' => 'data berhasil di temukan',
        //     'data' => $person
        // ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validasi error',
                'errors' => $validator->errors()
            ], 422);
        }

        $person = Person::findOrFail($id);
        $person->update($request->all());
        return (new PersonResource($person))->additional(['status' => 'true', 'message' => 'Data berhasil di perbaiki'])->response()->setStatusCode(200);

        // return response()->json([
        //     'status' => true,
        //     'message' => 'data berhasil di update',
        //     'data' => $person
        // ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $person = Person::findOrFail($id);
        $person->delete();
        return response()->json([
            'status' => true,
            'message' => 'data berhasil di hapus',
            'data' => $person
        ], 204);
    }
}
