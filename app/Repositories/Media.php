<?php

namespace EmergencyExplorer\Repositories;

use EmergencyExplorer\Jobs\CreateImage as CreateImageJob;
use EmergencyExplorer\Project as ProjectModel;
use EmergencyExplorer\Media as MediaModel;
use EmergencyExplorer\User as UserModel;
use EmergencyExplorer\Media\Image as ImageProvider;
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
    public function createImage(UploadedFile $file, array $imageData, ProjectModel $project, UserModel $user)
    {
        //Use the file hash instead?
        $filename = sha1($file->getRealPath() . time() . $project->id . $user->id . json_encode($imageData)) . '.' . $file->getClientOriginalExtension();

        $file = $file->move(storage_path('app'), $filename);

        $job = new CreateImageJob($project, $user, $file->getRealPath(), $imageData);

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
            MediaModel\LocalImage::IDENTIFIER => app(MediaModel\LocalImage::class),
            'em-upload'                       => MediaModel\EmergencyUploadImage::class,
        ];


        if (isset($imageProviders[$providerId])) {
            return $imageProviders[$providerId];
        }

        return app(MediaModel\LocalImage::class);
    }
}