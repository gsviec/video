<?php

namespace Phanbook\Amazon;

use Aws\S3\S3Client;
use Aws\Exception\S3Exception;
use Phalcon\Di\Injectable;

class S3 extends Injectable
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
    public function upload($path, $key, $acl = 'private')
    {
        if (!file_exists($path)) {
            return false;
        }
        $this->logger->error($path);
        try {
            $this->client->putObject([
                'Bucket' => $this->config->bucket,
                'Key'    => $key,
                'Body'   => fopen($path, 'rb'),
                'ACL'    => $acl
            ]);
            return true;
        } catch (S3Exception $e) {
            $this->logger->error($e->getMessage());
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
    public function createPresignedRequest($pathToFile)
    {
        try {
            //Creating a presigned URL
            $cmd = $this->client->getCommand('GetObject', [
                'Bucket' => $this->config->bucket,
                'Key' => $pathToFile
            ]);

            $request = $this->client->createPresignedRequest($cmd, '+20 minutes');
            // Get the actual presigned-url
            return (string)$request->getUri();

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
                'debug'   => true
            ]
        );
        return $s3Client;
    }

}
