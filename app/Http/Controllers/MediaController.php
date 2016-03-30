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
}
