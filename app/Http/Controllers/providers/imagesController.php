<?php

namespace App\Http\Controllers\providers;

use App\carepays_providers\provider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class imagesController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:providers']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $request->validate([
            'image' => 'required|image'
        ]);

        $provider = $request->user();

        $this->deleteOldImage($provider);

        $file = $request->file('image')->store('images/providers', 'public');
        $filepath = 'app/public/' . $file;

        $provider->update([
            'image' => $filepath
        ]);

        return response()->json([], 201);
    }



    public function deleteOldImage(provider $provider)
    {
        $image = $provider->image;
        if(!$this->IsDefault($image))
        {
            Storage::delete('public/' . $image);
        }
    }

    public function IsDefault($image)
    {
        return $image === $this->defaultUserImage();
    }

    public function defaultUserImage()
    {
        return "images/providers/default.png";
    }

    /**
     * delete specified user file from storage
     *
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request)
    {
        $provider = $request->user();
        $this->deleteOldImage($provider);
        $provider->update([
            'image' => $this->defaultUserImage()
        ]);
        return asset($this->defaultUserImage());
    }
}
