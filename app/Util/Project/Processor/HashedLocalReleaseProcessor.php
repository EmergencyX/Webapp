<?php

namespace EmergencyExplorer\Util\Project\Processor;

use Carbon\Carbon;
use EmergencyExplorer\Models\Release;
use Symfony\Component\HttpFoundation\File\File;

class HashedLocalReleaseProcessor implements ReleaseProcessor
{
    const IDENTIFIER = 'hash';

    /**
     * Get a download link for a release
     *
     * @param Release $release
     *
     * @return string
     */
    public function url(Release $release): string
    {
        $filename = $release->provider['t'];

        return asset(sprintf('/storage/mods/%s/%s', substr($filename, 0, 2), $filename));
    }

    /**
     * @param File $file
     *
     * @return Release
     */
    public function store(File $file): Release
    {
        $filename = $this->generateFilename($file->guessExtension());
        $file->move(storage_path('ingress'), $filename);

        chmod(storage_path('ingress/' . $filename), 0644);

        $release = new Release;
        $release->provider = [
            's' => 0,                   //status == nicht verarbeitet
            't' => $filename,           //token
            'p' => self::IDENTIFIER,    //
        ];

        logger()->info('Incoming release saved in ingress folder', $release->toArray());

        return $release;
    }

    /**
     * @param string $extension
     *
     * @return string
     */
    protected function generateFilename(string $extension)
    {
        return Carbon::now()->toDateTimeString() . str_random(6) . '.' . $extension;
    }

    /**
     * @param Release $release
     *
     * @return bool
     */
    public function remove(Release $release): bool
    {
        $filename = $release->provider['t'];
        $path = public_path('storage/mods/' . substr($filename, 0, 2) . '/' . $filename);
        @unlink($path);

        return $release->delete();
    }

    /**
     * @param Release $release
     *
     * @return bool
     */
    public function publish(Release $release): bool
    {
        return true;
    }

    /**
     * @param Release $release
     *
     * @return bool
     */
    public function unpublish(Release $release): bool
    {
        return true;
    }
}