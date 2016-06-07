<?php

namespace EmergencyExplorer\Util;

use GuzzleHttp;
use Illuminate\Http\UploadedFile;

class EmergencyUploadApi
{
    const EM_UPLOAD_ENDPOINT = 'http://img.em-upload.de/api/1/';
    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @return \GuzzleHttp\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * EmergencyUploadApi constructor.
     */
    public function __construct()
    {
        $this->client = new GuzzleHttp\Client([
            'base_uri' => self::EM_UPLOAD_ENDPOINT,
            'timeout'  => 2.0,
        ]);

        $this->apiKey = env('EM_UPLOAD_API_KEY');
    }

    public function createImage(string $filepath, array $options)
    {
        //Todo: As we can not set a title, we should try to set the filename

        $defaultOptions = [
            'multipart' => [
                [
                    'name'     => 'key',
                    'contents' => $this->apiKey,
                ],
                [
                    'name'     => 'source',
                    'contents' => fopen($filepath, 'r'),
                ],
            ],
            'headers'  => ['User-Agent' => 'EmergencyExplorer/0.0.1 EmergencyUploadApi/1'],
        ];

        $options = $defaultOptions + $options;

        $response = $this->client->post('upload', $options);
    }
}