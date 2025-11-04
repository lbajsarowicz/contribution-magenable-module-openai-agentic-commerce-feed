<?php

declare(strict_types=1);

namespace Magenable\OpenAIAgenticCommerceFeed\Controller\Adminhtml\System\Config;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magenable\OpenAIAgenticCommerceFeed\Model\ConfigProvider;
use Magenable\OpenAIAgenticCommerceFeed\Model\LockManager;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Exception\NoSuchEntityException;

class GenerationProgress extends Action
{
    const ADMIN_RESOURCE = 'Magenable_OpenAIAgenticCommerceFeed::configuration';
    private ConfigProvider $configProvider;
    private LockManager $lockManager;
    private StoreManagerInterface $storeManager;
    private JsonFactory $resultJsonFactory;

    public function __construct(
        Context $context,
        ConfigProvider $configProvider,
        LockManager $lockManager,
        StoreManagerInterface $storeManager,
        JsonFactory $resultJsonFactory,
    ) {
        parent::__construct($context);
        $this->configProvider = $configProvider;
        $this->lockManager = $lockManager;
        $this->storeManager = $storeManager;
        $this->resultJsonFactory = $resultJsonFactory;
    }

    /**
     * @throws NoSuchEntityException
     */
    public function execute(): Json
    {
        $storeId = $this->configProvider->getGenerationProgressStore();
        $result = [
            'count' => $this->configProvider->getGenerationProgressCount(),
            'current' => $this->configProvider->getGenerationCurrentProgress(),
            'store' => $storeId ? $this->storeManager->getStore((int)$storeId)->getCode() : $storeId,
        ];

        if (!$this->lockManager->isLocked()) {
            $result['done'] = 1;
        }

        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData($result);
    }
}
