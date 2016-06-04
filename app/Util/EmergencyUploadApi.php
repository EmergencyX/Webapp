<?php

namespace EmergencyExplorer\Util;

class EmergencyUploadApi
{
    protected $endpoint = '';
    /**
     * EmergencyUploadApi constructor.
     */
    public function __construct()
    {
        $this->endpoint = env('EM_UPLOAD_ENDPOINT', '');
        //Connect and handle authorization
    }
}