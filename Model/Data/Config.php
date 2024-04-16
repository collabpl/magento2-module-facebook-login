<?php
/**
 * @category  Collab
 * @package   Collab\FacebookLogin
 * @author    Marcin Jędrzejewski <m.jedrzejewski@collab.pl>
 * @copyright 2024 Collab
 * @license   MIT
 */

declare(strict_types=1);

namespace Collab\FacebookLogin\Model\Data;

use Collab\FacebookLogin\Api\Data\ConfigInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Data\Form\FormKey as CsrfFormKey;
use Magento\Framework\DataObject;
use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class Config extends DataObject implements ConfigInterface
{

    public function __construct(
        protected CsrfFormKey $formKey,
        protected ScopeConfigInterface $scopeConfig,
        protected StoreManagerInterface $storeManager,
        protected EncryptorInterface $encryptor,
        array $data = []
    ) {
        parent::__construct($data);
    }

    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_FACEBOOK_LOGIN_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getClientId(): ?string
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_FACEBOOK_CLIENT_ID,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getClientSecret(): ?string
    {
        return $this->encryptor->decrypt(
            $this->scopeConfig->getValue(
                self::XML_PATH_FACEBOOK_CLIENT_SECRET,
                ScopeInterface::SCOPE_STORE
            )
        );
    }

    /**
     * @throws NoSuchEntityException
     */
    public function getCallbackUrl(): string
    {
        return $this->storeManager->getStore()->getBaseUrl() . self::CONFIG_CALLBACK_URL;
    }

    public function getBaseGraphUrl(): string
    {
        return self::CONFIG_BASE_GRAPH_URL;
    }

    /**
     * @throws LocalizedException
     */
    public function getFormKey(): string
    {
        return $this->formKey->getFormKey();
    }
}
