<?php

namespace App\Http\Controllers;
use App\Http\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(private PostService $service) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(
            $this->service->all()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         return response()->json(
            $this->service->store($request->all())
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return response()->json(
            $this->service->update($id, $request->all())
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return response()->json(
            $this->service->delete($id)
        );
    }
    
    public function login(Request $request)
    {
        return response()->json(
            $this->service->login($request->all())
        );
    }
}