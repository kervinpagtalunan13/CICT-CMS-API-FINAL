<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\ProfileResource;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Validation\Validator;
use Nette\Utils\Validators;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profiles = Profile::all();
        return response()->json($profiles);
        // $profiles = User::with('profile')->get();
        // return ProfileResource::collection($profiles);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProfileRequest $request)
    {
        return Profile::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {
        return response()->json(new ProfileResource($profile));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileRequest $request, Profile $profile)
    {
        $profile->update($request->all());
        // return response()->json([
        //     'message' => 'profile updated successfuly',
        //     'profile' => $request->user()->profile
        // ]);
        return $request->user()->profile;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        //
    }

    public function uploadPic(Request $request)
    {
        $fields = $request->validate([
            'image' => 'required|image|mimes:png,jpg,jpeg'
        ]);

        $file = $request->file('image');
        if (!$file)
            return response()->json(['message' => 'profile pic is required'], 404);

        $profile = auth()->user()->profile;

        if (!$profile)
            return response()->json(['message' => 'profile has not been set up'], 404);

        $fileName = $profile->id . '-' . time() . '-' . $file->getClientOriginalName();
        Storage::putFileAs('profilePics', $file, $fileName);

        $profile->update(['profile_pic' => $fileName]);

        return response()->json(['message' => 'success', 'profile' => $profile]);
    }

    public function getProfilePic(Request $request, string $pic)
    {
        $filePath = storage_path('app/profilePics/' . $pic);

        if (!file_exists($filePath)) {
            return response()->json(['message' => 'image not found'], 404);
        }

        $fileContents = file_get_contents($filePath);
        
        return response($fileContents)
            ->header('Content-Type', 'image/jpeg');
        // ->header('Content-Disposition', 'inline; filename="' . '1-1680422701-WIN_20230308_12_44_42_Pro.jpg' . '"');
    }
}
