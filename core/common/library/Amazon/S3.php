<?php

namespace Phanbook\Amazon;

use Aws\S3\S3Client;
use Aws\Exception\S3Exception;

class S3
{
    /**
     * @var object
     */
    protected $config;

    public function __construct($config)
    {
        $this->config = $config->amazon->s3;
        $this->client = $this->s3Client();
    }

    /**
     *
     * @param  the $path container a filename
     * @param  string $key is folder / a filename
     *
     * @return bool
     */
    public function upload($path, $key)
    {
        if (!file_exists($path)) {
            return false;
        }

        try {
            $this->client->putObject([
                'Bucket' => $this->config->bucket,
                'Key'    => $key,
                'Body'   => fopen($path, 'rb'),
                'ACL'    => 'public-read',
            ]);
            return true;
        } catch (S3Exception $e) {
            error_log("There was an error uploading the file to amazon");
            return false;
        }
    }


    public function get($pathToFile)
    {
        try {
            return $this->client->getObject([
                'Bucket' => $this->config->bucket,
                'Key' => $pathToFile
            ])->get('Body');
        } catch (S3Exception $e) {
            d($e);
        }
    }

    /**
     * @param $pathToFile
     * @return mixed
     */
    public function getContent($pathToFile)
    {
        return $this->get($pathToFile)->getContents();
    }

    /**
     * @param $pathToFile
     * @return string
     */
    public function getObjecturl($pathToFile)
    {
        try {
            return $this->client->getObjectUrl(
                $this->config->bucket,
                $pathToFile
            );
        } catch (S3Exception $e) {
            d($e);
        }
    }

    /**
     * @return S3Client
     */
    protected function s3Client()
    {
        $s3Client = new S3Client(
            [
                'version' => 'latest',
                'region'  => $this->config->region,
                'credentials' => [
                    'key' => $this->config->key,
                    'secret' => $this->config->secret
                ],
                //'debug'   => true
            ]
        );
        return $s3Client;
    }

}
