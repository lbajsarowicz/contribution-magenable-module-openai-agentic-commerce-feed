<?php

declare(strict_types=1);

namespace Magenable\OpenAIAgenticCommerceFeed\Model\ProductAttributeProcessors;

use Magenable\OpenAIAgenticCommerceFeed\Api\ProductAttributeProcessorInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magenable\OpenAIAgenticCommerceFeed\Helper\FeedAttributes;

class Status implements ProductAttributeProcessorInterface
{
    public function processProductAttribute(
        string $feedAttributeCode,
        string $websiteAttributeCode,
        ProductInterface $product
    ): null|string|array {
        if (!in_array($feedAttributeCode, $this->getFeedAttributeList())) {
            return $product->getData($websiteAttributeCode);
        }

        if ((int)$product->getStatus() === 1) {
            return 'true';
        }

        return 'false';
    }

    public function getFeedAttributeList(): array
    {
        return [FeedAttributes::ATTR_ENABLE_SEARCH, FeedAttributes::ATTR_ENABLE_CHECKOUT];
    }
}
