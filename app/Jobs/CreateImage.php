<?php

namespace EmergencyExplorer\Jobs;

use EmergencyExplorer\Media\LocalImage;
use EmergencyExplorer\Repositories\Media as MediaRepository;
use EmergencyExplorer\Repositories\Media;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use EmergencyExplorer\User as UserModel;
use EmergencyExplorer\Project as ProjectModel;
use EmergencyExplorer\Media as MediaModel;
use EmergencyExplorer\Jobs\Job;
use EmergencyExplorer\Media\Image as ImageProvider;

class CreateImage extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    /**
     * @var ProjectModel
     */
    protected $project;

    /**
     * @var string
     */
    protected $filename;

    /**
     * @var array
     */
    protected $imageData;

    /**
     * @var UserModel
     */
    protected $user;

    /**
     * Create a new job instance.
     *
     * @param ProjectModel $project
     * @param UserModel $user
     * @param string $filename
     * @param array $imageData
     */
    public function __construct(string $filename, array $imageData, UserModel $user, ProjectModel $project = null)
    {
        $this->user = $user;
        $this->project = $project;

        $this->filename = $filename;
        $this->imageData = $imageData;
    }

    /**
     * Execute the job.
     *
     * @param \EmergencyExplorer\Repositories\Media $mediaRepository
     */
    public function handle(MediaRepository $mediaRepository)
    {
        $imageProvider = $mediaRepository->getImageProvider($this->imageData['provider']);

        $created = [];
        $missing = [];

        $sizes = array_merge(['xs'], $this->imageData['sizes']);

        foreach ($sizes as $size) {
            if (isset($created[$size])) {
                continue; //Already created, skip
            }

            if ($imageProvider->providesImageSize($size)) {
                //processImage may return multiple sizes at once.
                $created = array_merge($created, $imageProvider->processImage($this->filename, [$size]));
            } else {
                $missing[] = $size;
            }
        }

        if (! empty($missing)) {
            /** @var LocalImage $backupImageProvider */
            $backupImageProvider = app(LocalImage::class);
            $created = array_merge($created, $backupImageProvider->processImage($this->filename, $missing));
        }

        $media = MediaModel::create(
            array_merge(
                array_only($this->imageData, ['name', 'description']),
                ['extra' => json_encode($created)]
            )
        );
        
        if(! is_null($project)) {
            $this->project->media()->save($media, ['user_id' => $this->user->id]);
        } else {
            if ($this->imageData['category']) {
                $media->meta = json_encode(['category' => 'profile-picture']);
            }
        }
    }
}
