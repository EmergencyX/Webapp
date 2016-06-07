<?php

namespace EmergencyExplorer\Http\Controllers;

use EmergencyExplorer\Media;
use EmergencyExplorer\Util\MediaUtil;
use Illuminate\Http\Request;

use EmergencyExplorer\Http\Requests;

class MediaController extends Controller
{
    public function delete(Request $request, int $id)
    {
        $user = $request->user();
        //Todo: Check auth
        $media = Media::findOrFail($id);
        MediaUtil::deleteMedia($media);
        return back();
    }

    public function store()
    {
        $providers = [
            1 => Media\LocalImage::class,
            2 => Media\EmergencyUploadImage::class
        ];

        //Todo: Get the provider value and pass the image to upload
        //Gnerell
    }
}
