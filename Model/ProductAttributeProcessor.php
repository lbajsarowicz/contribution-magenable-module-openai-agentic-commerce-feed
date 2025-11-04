<?php

declare(strict_types=1);

namespace Magenable\OpenAIAgenticCommerceFeed\Model;

use Magenable\OpenAIAgenticCommerceFeed\Api\ProductAttributeProcessorInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\Exception\LocalizedException;

class ProductAttributeProcessor
{
    private array $processors;

    public function __construct(
        array $processors,
    ) {
        $this->processors = $processors;
    }

    /**
     * @throws LocalizedException
     */
    public function processProductAttribute(
        string $feedAttributeCode,
        string $websiteAttributeCode,
        ProductInterface $product
    ): null|string|array {
        if (!isset($this->processors[$websiteAttributeCode])) {
            return trim((string)$product->getData($websiteAttributeCode));
        }

        $processor = $this->processors[$websiteAttributeCode];
        if (gettype($processor) !== 'object') {
            throw new LocalizedException(__(
                'The provided Product Attribute Processor `%1` should be of type `object` but it has type `%2`.',
                $websiteAttributeCode,
                gettype($processor)
            ));
        }
        if (!$processor instanceof ProductAttributeProcessorInterface) {
            throw new LocalizedException(
                __(
                    'The provided Product Attribute Processor `%1` should be instance of `%2`.',
                    $websiteAttributeCode,
                    ProductAttributeProcessorInterface::class
                )
            );
        }

        $result = $processor->processProductAttribute($feedAttributeCode, $websiteAttributeCode, $product);

        if (!is_array($result)) {
            return $result;
        }

        return $this->convertSimpleValuesToStrings($result);
    }

    public function hasProcessorForAttribute(string $attributeCode): bool
    {
        if (!isset($this->processors[$attributeCode])) {
            return false;
        }

        return true;
    }

    public function getProcessorForAttribute(string $attributeCode): null|ProductAttributeProcessorInterface
    {
        if (!isset($this->processors[$attributeCode])) {
            return null;
        }

        return $this->processors[$attributeCode];
    }

    private function convertSimpleValuesToStrings(array $array): array
    {
        foreach ($array as $key => $value) {
            if (is_array($value) || is_object($value)) {
                $array[$key] = $this->convertSimpleValuesToStrings($value);
            } else {
                $array[$key] = (string)$value;
            }
        }

        return $array;
    }
}
