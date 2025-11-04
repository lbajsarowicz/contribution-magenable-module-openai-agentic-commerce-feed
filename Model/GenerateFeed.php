<?php

declare(strict_types=1);

namespace Magenable\OpenAIAgenticCommerceFeed\Model;

use Magento\Store\Model\StoreManagerInterface;
use Magenable\OpenAIAgenticCommerceFeed\Exception\LockException;
use Magento\Framework\Exception\LocalizedException;

class GenerateFeed
{
    private LockManager $lockManager;
    private StoreManagerInterface $storeManager;
    private FeedData $feedData;
    private FileSaver $fileSaver;
    private ConfigProvider $configProvider;

    public function __construct(
        LockManager $lockManager,
        StoreManagerInterface $storeManager,
        FeedData $feedData,
        FileSaver $fileSaver,
        ConfigProvider $configProvider,
    ) {
        $this->lockManager = $lockManager;
        $this->storeManager = $storeManager;
        $this->feedData = $feedData;
        $this->fileSaver = $fileSaver;
        $this->configProvider = $configProvider;
    }

    /**
     * @throws LockException
     * @throws LocalizedException
     */
    public function execute(): void
    {
        if ($this->lockManager->isLocked()) {
            throw new LockException(__('The feed generation process is already works, the generation is skipped'));
        }
        $this->lockManager->lock();

        try {
            foreach ($this->storeManager->getStores() as $store) {
                $storeId = (int)$store->getId();
                $this->configProvider->setGenerationProgressStore($storeId);
                $feedData = $this->feedData->getData($storeId);
                $this->fileSaver->save($feedData, $storeId);
            }

            $this->configProvider->setLastGenerationTimestamp((string)time());
        } finally {
            $this->lockManager->unlock();
        }
    }
}
