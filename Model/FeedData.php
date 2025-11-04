<?php

declare(strict_types=1);

namespace Magenable\OpenAIAgenticCommerceFeed\Model;

use Magenable\OpenAIAgenticCommerceFeed\Helper\Data;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\Exception\LocalizedException;

class FeedData
{
    private ConfigProvider $configProvider;
    private ProductsData $productsData;
    private ProductAttributeProcessor $productAttributeProcessor;

    public function __construct(
        ConfigProvider $configProvider,
        ProductsData $productsData,
        ProductAttributeProcessor $productAttributeProcessor
    ) {
        $this->configProvider = $configProvider;
        $this->productsData = $productsData;
        $this->productAttributeProcessor = $productAttributeProcessor;
    }

    /**
     * @throws LocalizedException
     */
    public function getData(int $storeId): array
    {
        $allProducts = $this->productsData->getProducts($storeId);
        $feedData = [];
        $key = 0;
        foreach ($allProducts as $product) {
            $feedData[] = $this->getItemData($product);

            if (++$key % 10 === 0) {
                $this->configProvider->setGenerationCurrentProgress($key);
            }
        }
        $this->configProvider->setGenerationCurrentProgress($key);

        return $feedData;
    }

    /**
     * @throws LocalizedException
     */
    public function getItemData(ProductInterface $product): array
    {
        $itemData = [];
        foreach ($this->configProvider->getAttributesMapping() as $mapping) {
            $feedAttribute = $mapping[Data::FIELD_FEED_ATTRIBUTE];
            $websiteAttribute = $mapping[Data::FIELD_WEBSITE_ATTRIBUTE];
            $customValue = $mapping[Data::FIELD_CUSTOM_VALUE];

            if ($customValue) {
                $itemData[$feedAttribute] = $customValue;
                continue;
            }

            $itemData[$feedAttribute] = $this->productAttributeProcessor->processProductAttribute(
                $feedAttribute,
                $websiteAttribute,
                $product
            );
        }

        return $itemData;
    }
}
