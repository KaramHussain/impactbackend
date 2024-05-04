<?php

namespace App\Http\Controllers\auth\profile;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class imagesController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:api']);
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

        $user = $request->user();

        $this->deleteOldImage($user);

        $file = $request->file('image')->store('images/users', 'public');

        $user->update([
            'user_image' => $file
        ]);

        return response()->json([], 201);
    }



    public function deleteOldImage(User $user)
    {
        $image = $user->user_image;
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
        return "images/users/default.png";
    }

    /**
     * delete specified user file from storage
     *
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request)
    {
        $user = $request->user();
        $this->deleteOldImage($user);
        $user->update([
            'user_image' => $this->defaultUserImage()
        ]);
        return asset($this->defaultUserImage());
    }
}
