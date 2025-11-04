<?php

declare(strict_types=1);

namespace Magenable\OpenAIAgenticCommerceFeed\Model\ProductAttributeProcessors;

use Magenable\OpenAIAgenticCommerceFeed\Api\ProductAttributeProcessorInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magenable\OpenAIAgenticCommerceFeed\Helper\FeedAttributes;

class UrlKey implements ProductAttributeProcessorInterface
{
    public function processProductAttribute(
        string $feedAttributeCode,
        string $websiteAttributeCode,
        ProductInterface $product
    ): ?string {
        if (!in_array($feedAttributeCode, $this->getFeedAttributeList())) {
            return $product->getData($websiteAttributeCode);
        }

        return $product->getProductUrl();
    }

    public function getFeedAttributeList(): array
    {
        return [FeedAttributes::ATTR_LINK];
    }
}
