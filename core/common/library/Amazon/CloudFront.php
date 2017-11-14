<?php
/**
 * Phanbook : Delightfully simple forum software
 *
 * Licensed under The GNU License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @link    http://phanbook.com Phanbook Project
 * @since   1.0.0
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */
namespace Phanbook\Amazon;

use Aws\CloudFront\CloudFrontClient;
use Phalcon\Mvc\User\Component;

class CloudFront extends Component
{
    /**
     * @var CloudFrontClient
     */
    protected $cf;

    /**
     * @var array|object Config value from amazon
     */
    protected $amazon;

    /**
     * CloudFront constructor.
     */
    public function __construct()
    {
        $this->cf = $this->cloudFrontClient();
        $this->amazon = $this->config->amazon;
    }

    /**
     * @return CloudFrontClient
     */
    protected function cloudFrontClient()
    {

        $cloudFront = new CloudFrontClient([
            'region'  => $this->config->amazon->s3->region,
            'version' => 'latest'
        ]);

        return $cloudFront;
    }

    /**
     * @param $filename
     * @return mixed
     */
    public  function signedUrl($filename)
    {

        $streamHostUrl = $this->amazon->cloudFront->url;
        $resourceKey = 'video/' . $filename;
        $expires = time() + 3600;

        // Create a signed URL for the resource using the canned policy
        $signedUrlCannedPolicy = $this->cf->getSignedUrl([
            'url'         => $streamHostUrl . '/' . $resourceKey,
            'expires'     => $expires,
            'private_key' => $this->amazon->cloudFront->secret,
            'key_pair_id' => $this->amazon->cloudFront->keyId
        ]);

        return $signedUrlCannedPolicy;
    }

    public  function renderUrl()
    {
        // Setup parameter values for the resource

    }

}
