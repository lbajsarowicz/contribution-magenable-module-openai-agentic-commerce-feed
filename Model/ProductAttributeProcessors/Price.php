<?php

declare(strict_types=1);

namespace Magenable\OpenAIAgenticCommerceFeed\Model\ProductAttributeProcessors;

use Magenable\OpenAIAgenticCommerceFeed\Api\ProductAttributeProcessorInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magenable\OpenAIAgenticCommerceFeed\Helper\FeedAttributes;

class Price implements ProductAttributeProcessorInterface
{
    private StoreManagerInterface $storeManager;

    public function __construct(StoreManagerInterface $storeManager)
    {
        $this->storeManager = $storeManager;
    }

    /**
     * @throws NoSuchEntityException
     */
    public function processProductAttribute(
        string $feedAttributeCode,
        string $websiteAttributeCode,
        ProductInterface $product
    ): null|string|array {
        if (!in_array($feedAttributeCode, $this->getFeedAttributeList())) {
            return $product->getData($websiteAttributeCode);
        }

        return [
            'value' => $product->getPriceInfo()->getPrice('final_price')->getValue(),
            'currency' => $this->storeManager->getStore(
                (int)$product->getStoreId()
            )->getCurrentCurrencyCode()
        ];
    }

    public function getFeedAttributeList(): array
    {
        return [FeedAttributes::ATTR_PRICE];
    }
}
