<?php

namespace EmergencyExplorer\Util\Release;

use Illuminate\Http\UploadedFile;

class LocalRelease implements Release
{
    /**
     * @param string $provider
     *
     * @return boolean
     */
    public function is(string $provider)
    {
        return $provider === 'local';
    }

    /**
     * @param array $config
     * @param string $identifier
     * @param \Illuminate\Http\UploadedFile $file
     *
     * @return string|false
     */
    public function publish(array $config, string $identifier, UploadedFile $file)
    {
        return $file->storeAs('mods', $identifier);
    }

    /**
     * @param string $identifier
     *
     * @return boolean
     */
    public function unpublish(array $config, string $identifier)
    {
        // TODO: Implement unpublish() method.
    }
}