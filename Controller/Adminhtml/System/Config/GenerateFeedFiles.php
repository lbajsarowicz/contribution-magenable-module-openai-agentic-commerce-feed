<?php

declare(strict_types=1);

namespace Magenable\OpenAIAgenticCommerceFeed\Controller\Adminhtml\System\Config;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magenable\OpenAIAgenticCommerceFeed\Model\LockManager;
use Magenable\OpenAIAgenticCommerceFeed\Model\GenerateFeed as GenerateFeedModel;
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Exception\LocalizedException;
use Magenable\OpenAIAgenticCommerceFeed\Exception\LockException;

class GenerateFeedFiles extends Action
{
    const ADMIN_RESOURCE = 'Magenable_OpenAIAgenticCommerceFeed::configuration';
    private LockManager $lockManager;
    private GenerateFeedModel $generateFeedModel;
    private SessionManagerInterface $sessionManager;
    private Json $json;

    public function __construct(
        Context $context,
        LockManager $lockManager,
        GenerateFeedModel $generateFeedModel,
        SessionManagerInterface $sessionManager,
        Json $json,
    ) {
        parent::__construct($context);
        $this->lockManager = $lockManager;
        $this->generateFeedModel = $generateFeedModel;
        $this->sessionManager = $sessionManager;
        $this->json = $json;
    }

    /**
     * @throws LocalizedException
     * @throws LockException
     */
    public function execute(): void
    {
        $result = [
            'success' => false,
            'errorMessage' => '',
        ];

        $generationIsLocked = $this->lockManager->isLocked();
        if ($generationIsLocked) {
            $result['errorMessage'] = __('The feed generation process is already works, the generation is skipped');
        } else {
            $result['success'] = true;
        }

        header('Content-Type: application/json');
        print_r($this->json->serialize($result));

        $this->sessionManager->writeClose();
        fastcgi_finish_request();

        if (!$generationIsLocked) {
            $this->generateFeedModel->execute();
        }
    }
}
