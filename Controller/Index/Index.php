<?php
/**
 * @category  Collab
 * @package   Collab\FacebookLogin
 * @author    Marcin Jędrzejewski <m.jedrzejewski@collab.pl>
 * @copyright 2024 Collab
 * @license   MIT
 */

declare(strict_types=1);

namespace Collab\FacebookLogin\Controller\Index;

use Collab\CustomerPasswordLessLogin\Service\LoginWithoutPassword;
use Collab\FacebookLogin\Api\Data\ConfigInterface;
use Collab\FacebookLogin\Service\FbApiClient;
use Exception;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Message\ManagerInterface;

class Index implements HttpGetActionInterface
{
    public function __construct(
        protected ConfigInterface $config,
        protected FbApiClient $fbApiClient,
        protected RequestInterface $request,
        protected ResultFactory $resultFactory,
        protected LoginWithoutPassword $loginWithoutPassword,
        protected Session $customerSession,
        protected ManagerInterface $messageManager
    ) {
    }

    /**
     *
     * @throws Exception
     */
    public function execute(): ResultInterface
    {
        $code = $this->request->getParam('code');
        $csrfToken = $this->request->getParam('state');

        $payload = $this->fbApiClient->getUserInfo($code);

        if (!count($payload) || $csrfToken !== $this->config->getFormKey()) {
            $this->messageManager->addErrorMessage(
                __('Invalid credentials or expired form key. Please try again...')
            );
        } else {
            $this->loginWithoutPassword->login([
                'email' => $payload['email'],
                'firstName' => $payload['first_name'],
                'lastName' => $payload['last_name']
            ]);
            $this->messageManager->addSuccessMessage(__('You have been successfully logged in.'));
        }

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)
            ->setPath($this->customerSession->getBeforeAuthUrl());
    }
}
