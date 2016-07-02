<?php

namespace EmergencyExplorer\Repositories;

use EmergencyExplorer\Jobs\CreateImage as CreateImageJob;
use EmergencyExplorer\Project as ProjectModel;
use EmergencyExplorer\Media as MediaModel;
use EmergencyExplorer\User as UserModel;
use EmergencyExplorer\Util\Media\EmergencyUploadImage;
use EmergencyExplorer\Util\Media\Image as ImageProvider;
use EmergencyExplorer\Util\Media\LocalImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Bus\DispatchesJobs;

class Media
{
    use DispatchesJobs;

    /**
     * @param UploadedFile $file
     * @param array $imageData
     * @param ProjectModel $project
     * @param UserModel $user
     */
    public function createImage(UploadedFile $file, array $imageData, UserModel $user, ProjectModel $project = null)
    {
        //Use the file hash instead?
        $filename = sha1($file->getRealPath() . time() . $user->id . json_encode($imageData)) . '.' . $file->getClientOriginalExtension();

        $file = $file->move(storage_path('app'), $filename);

        $job = new CreateImageJob($file->getRealPath(), $imageData, $user, $project);

        if ($this->getImageProvider($imageData['provider'])->shouldQueue()) {
            $this->dispatch($job);
        } else {
            $this->dispatchNow($job);
        }
    }

    /**
     * @param string $providerId
     *
     * @return ImageProvider
     */
    public function getImageProvider(string $providerId)
    {
        $imageProviders = [
            LocalImage::IDENTIFIER => app(LocalImage::class),
            'em-upload'            => EmergencyUploadImage::class,
        ];


        if (isset($imageProviders[$providerId])) {
            return $imageProviders[$providerId];
        }

        return app(LocalImage::class);
    }
    
    public function getProfileImageFor(UserModel $user)
    {
        //MediaModel::where()
        return;
    }
}