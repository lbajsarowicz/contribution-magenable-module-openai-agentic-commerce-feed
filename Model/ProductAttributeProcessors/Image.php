<?php

declare(strict_types=1);

namespace Magenable\OpenAIAgenticCommerceFeed\Model\ProductAttributeProcessors;

use Magenable\OpenAIAgenticCommerceFeed\Api\ProductAttributeProcessorInterface;
use Magento\Catalog\Model\Product\Media\Config as MediaConfig;
use Magento\Catalog\Api\Data\ProductInterface;
use Magenable\OpenAIAgenticCommerceFeed\Helper\FeedAttributes;
use Magento\Framework\UrlInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class Image implements ProductAttributeProcessorInterface
{
    private MediaConfig $mediaConfig;

    public function __construct(MediaConfig $mediaConfig)
    {
        $this->mediaConfig = $mediaConfig;
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
        if (!$image = $product->getData($websiteAttributeCode)) {
            return null;
        }

        return $product->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) .
            $this->mediaConfig->getBaseMediaPath() . $image;
    }

    public function getFeedAttributeList(): array
    {
        return [FeedAttributes::ATTR_IMAGE_LINK];
    }
}
