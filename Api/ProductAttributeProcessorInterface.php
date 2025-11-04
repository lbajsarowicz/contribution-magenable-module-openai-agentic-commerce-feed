<?php

declare(strict_types=1);

namespace Magenable\OpenAIAgenticCommerceFeed\Api;

use Magento\Catalog\Api\Data\ProductInterface;

interface ProductAttributeProcessorInterface
{
    public function processProductAttribute(
        string $feedAttributeCode,
        string $websiteAttributeCode,
        ProductInterface $product
    ): null|string|array;

    /**
     * @return array<int, string>
     */
    public function getFeedAttributeList(): array;
}
