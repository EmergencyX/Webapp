<?php

namespace EmergencyExplorer\Util\Release;

use Illuminate\Http\UploadedFile;

interface Release
{
    /**
     * @param string $provider
     *
     * @return boolean
     */
    public function is(string $provider);

    /**
     * @param array $config
     * @param string $identifier
     * @param \Illuminate\Http\UploadedFile $file
     *
     * @return string|false
     */
    public function publish(array $config, string $identifier, UploadedFile $file);

    /**
     * @param string $identifier
     *
     * @return boolean
     */
    public function unpublish(array $config, string $identifier);
}