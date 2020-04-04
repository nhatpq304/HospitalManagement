<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Enum\mediaType;
use App\Http\Requests\ImageRequest;
use App\Models\Media;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    private $media;
    private static $BASE_S3;

    public function __construct(Media $media)
    {
        $this->media = $media;
        MediaController::$BASE_S3 = 'https://' . env('AWS_BUCKET') . '.s3-' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/';
    }

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(ImageRequest $request)
    {
        $user = User::findOrFail($request->user_id);
        $path = MediaController::$BASE_S3 . Storage::disk('s3')->put('images', $request->file, 'public');
        $this->media->fill(['media_link' => $path,
            'media_type' => mediaType::$AVATAR,
        ]);

        if ($user->media()->save($this->media)) {
            return response()->json([], 201);
        } else {
            return response()->json([], 500);
        }
    }


    public function show(Media $medium)
    {
        //
    }

    public function edit(Media $medium)
    {
        //
    }


    public function update(Request $request, Media $medium)
    {
        //
    }


    public function destroy(Media $medium)
    {
        try {
            if ($medium->delete()) {
                Storage::disk('s3')->delete($medium->media_link);

                return response()->json([], 200);
            } else {
                return response()->json([], 500);
            }
        }catch (\Exception $error )
        {
            return response()->json(['error' => $error], 500);
        }
    }
}
