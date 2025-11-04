<?php

declare(strict_types=1);

namespace Magenable\OpenAIAgenticCommerceFeed\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Eav\Api\AttributeRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use Magenable\OpenAIAgenticCommerceFeed\Model\ProductAttributeProcessor;
use Magento\Catalog\Api\Data\ProductAttributeInterface;

class WebsiteAttributes implements OptionSourceInterface
{
    private AttributeRepositoryInterface $attributeRepository;
    private SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory;
    private ProductAttributeProcessor $productAttributeProcessor;

    public function __construct(
        AttributeRepositoryInterface $attributeRepository,
        SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory,
        ProductAttributeProcessor $productAttributeProcessor,
    ) {
        $this->attributeRepository = $attributeRepository;
        $this->searchCriteriaBuilderFactory = $searchCriteriaBuilderFactory;
        $this->productAttributeProcessor = $productAttributeProcessor;
    }

    public function toOptionArray(): array
    {
        return $this->getAllProductAttributes();
    }

    /**
     * @return array<int, array{value: string, label: string|null}>
     */
    public function getAllProductAttributes(): array
    {
        $entityType = ProductAttributeInterface::ENTITY_TYPE_CODE;
        $searchCriteriaBuilder = $this->searchCriteriaBuilderFactory->create();
        $attributesList = $this->attributeRepository->getList($entityType, $searchCriteriaBuilder->create());

        $result = [];
        foreach ($attributesList->getItems() as $attribute) {
            $attrCode = $attribute->getAttributeCode();
            $preparedLabel = $attrCode;
            $defaultLabel = $attribute->getDefaultFrontendLabel();
            if ($defaultLabel) {
                $preparedLabel .= ' - ' . $defaultLabel;
            }
            $preparedLabel .= $this->getAttributeProcessorLabel($attrCode);

            $result[] = [
                'value' => $attrCode,
                'label' => $preparedLabel,
            ];
        }

        return $result;
    }

    private function getAttributeProcessorLabel(string $attrCode): string
    {
        if (!$this->productAttributeProcessor->hasProcessorForAttribute($attrCode)) {
            return '';
        }

        $attributeProcessor = $this->productAttributeProcessor->getProcessorForAttribute($attrCode);
        $supportedFeedAttributes = implode(', ', $attributeProcessor->getFeedAttributeList());
        if ($supportedFeedAttributes) {
            return " |*| Has attribute processor for: $supportedFeedAttributes |*|";
        }

        return " |*| Has attribute processor |*|";
    }
}
