<?php
/**
 * @category  Collab
 * @package   Collab\FacebookLogin
 * @author    Marcin Jędrzejewski <m.jedrzejewski@collab.pl>
 * @copyright 2024 Collab
 * @license   MIT
 */

declare(strict_types=1);

namespace Collab\FacebookLogin\Service;

use Collab\FacebookLogin\Api\Data\ConfigInterface;
use Exception;
use Magento\Framework\HTTP\Client\CurlFactory;

class FbApiClient
{
    public function __construct(
        protected ConfigInterface $config,
        protected CurlFactory $curlFactory
    ) {
    }

    /**
     *
     * @throws Exception
     */
    public function getUserInfo(string $code): array
    {
        $token = $this->getAccessToken($code);
        return $this->getUser($token);
    }

    /**
     *
     * @throws Exception
     */
    private function getAccessToken(string $code): string
    {
        $curl = $this->curlFactory->create();

        $curl->get(ConfigInterface::CONFIG_BASE_GRAPH_URL . ConfigInterface::CONFIG_TOKEN_ENDPOINT . '?'
            . http_build_query([
                'client_id' => $this->config->getClientId(),
                'client_secret' => $this->config->getClientSecret(),
                'code' => $code,
                'redirect_uri' => $this->config->getCallbackUrl()
            ]));

        $response = json_decode($curl->getBody(), true);
        unset($curl);

        if (array_key_exists('error', $response)) {
            throw new Exception($response['error']['message']);
        }

        return $response['access_token'];
    }

    private function getUser(string $token): array
    {
        $curl = $this->curlFactory->create();

        $curl->get(ConfigInterface::CONFIG_BASE_GRAPH_URL . ConfigInterface::CONFIG_ME_ENDPOINT . '?'
            . http_build_query([
                'fields' => 'email,first_name,last_name',
                'access_token' => $token
            ]));

        $response = json_decode($curl->getBody(), true);
        unset($curl);

        return $response;
    }
}
