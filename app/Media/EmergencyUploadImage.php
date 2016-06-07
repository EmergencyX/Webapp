<?php

namespace EmergencyExplorer\Media;

use EmergencyExplorer\Media as MediaModel;
use EmergencyExplorer\User as UserModel;
use EmergencyExplorer\Util\EmergencyUploadApi;
use Illuminate\Http\UploadedFile;

class EmergencyUploadImage implements Image
{
    /**
     * @var \EmergencyExplorer\Util\EmergencyUploadApi
     */
    protected $uploadApi;

    /**
     * EmergencyUploadImage constructor.
     *
     * @param \EmergencyExplorer\Util\EmergencyUploadApi $uploadApi
     */
    public function __construct(EmergencyUploadApi $uploadApi)
    {
        $this->uploadApi = $uploadApi;
    }

    /**
     * @param UploadedFile $file
     * @param UserModel $user
     *
     * @return MediaModel
     */
    public function uploadImage(UploadedFile $file, UserModel $user)
    {
    }

    public function deleteImage(MediaModel $media)
    {
        // TODO: Implement deleteImage() method.
    }


    public function shouldQueue()
    {
        return true;
    }
}