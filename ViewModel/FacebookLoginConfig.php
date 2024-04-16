<?php
/**
 * @category  Collab
 * @package   Collab\FacebookLogin
 * @author    Marcin Jędrzejewski <m.jedrzejewski@collab.pl>
 * @copyright 2024 Collab
 * @license   MIT
 */

declare(strict_types=1);

namespace Collab\FacebookLogin\ViewModel;

use Collab\FacebookLogin\Api\Data\ConfigInterface;
use Magento\Framework\Data\Form\FormKey as CsrfFormKey;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class FacebookLoginConfig implements ArgumentInterface
{
    public function __construct(
        protected UrlInterface $url,
        protected ConfigInterface $config
    ) {
    }

    public function getCallbackUrl(): string
    {
        return $this->url->getDirectUrl(ConfigInterface::CONFIG_CALLBACK_URL);
    }

    public function getClientId(): ?string
    {
        return $this->config->getClientId();
    }

    public function getBaseGraphUrl(): string
    {
        return $this->config->getBaseGraphUrl();
    }

    public function getFormKey(): string
    {
        return $this->config->getFormKey();
    }
}
