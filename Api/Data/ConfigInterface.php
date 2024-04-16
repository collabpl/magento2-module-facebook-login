<?php
/**
 * @category  Collab
 * @package   Collab\FacebookLogin
 * @author    Marcin Jędrzejewski <m.jedrzejewski@collab.pl>
 * @copyright 2024 Collab
 * @license   MIT
 */

declare(strict_types=1);

namespace Collab\FacebookLogin\Api\Data;

interface ConfigInterface
{
    public const CONFIG_CALLBACK_URL = 'facebooklogin/index/index';
    public const CONFIG_BASE_GRAPH_URL = 'https://graph.facebook.com/v19.0/';
    public const CONFIG_TOKEN_ENDPOINT = 'oauth/access_token';
    public const CONFIG_ME_ENDPOINT = 'me';
    public const XML_PATH_FACEBOOK_LOGIN_ENABLED = 'collab_facebooklogin/general/enabled';
    public const XML_PATH_FACEBOOK_CLIENT_ID = 'collab_facebooklogin/general/client_id';
    public const XML_PATH_FACEBOOK_CLIENT_SECRET = 'collab_facebooklogin/general/client_secret';

    public function isEnabled(): bool;
    public function getClientId(): ?string;
    public function getClientSecret(): ?string;
    public function getCallbackUrl(): string;
    public function getBaseGraphUrl(): string;
    public function getFormKey(): string;
}
