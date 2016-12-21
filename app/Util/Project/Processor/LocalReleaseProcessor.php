<?php

namespace EmergencyExplorer\Util\Project\Processor;

use EmergencyExplorer\Models\Release;
use Symfony\Component\HttpFoundation\File\File;

class LocalReleaseProcessor implements ReleaseProcessor
{
    const IDENTIFIER = 'loc';

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
        $release  = new Release;
        $filename = md5(str_random(12) . (string)time()) . '.' . $file->guessExtension();
        $path     = public_path('storage/mods/' . substr($filename, 0, 2));
        $file->move($path, $filename);

        chmod($path . '/' . $filename, 0644);

        $release->provider = ['t' => $filename, 'p' => self::IDENTIFIER];

        return $release;
    }

    /**
     * @param Release $release
     *
     * @return bool
     */
    public function remove(Release $release): bool
    {
        $filename = $release->provider['t'];
        $path     = public_path('storage/mods/' . substr($filename, 0, 2) . '/' . $filename);

        return unlink($path);
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