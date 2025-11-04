<?php

declare(strict_types=1);

namespace Magenable\OpenAIAgenticCommerceFeed\Model;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Framework\Exception\LocalizedException;

class ProductsData
{
    private ProductCollectionFactory $productCollectionFactory;
    private array $collections = [];
    private ConfigProvider $configProvider;

    public function __construct(
        ProductCollectionFactory $productCollectionFactory,
        ConfigProvider $configProvider,
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->configProvider = $configProvider;
    }

    /**
     * @return ProductInterface[]
     * @throws LocalizedException
     */
    public function getProducts(int $storeId): array
    {
        $productCollection = $this->getProductCollection($storeId);
        $this->configProvider->setGenerationProgressCount(
            (int)$productCollection->count()
        );
        return $productCollection->getItems();
    }

    /**
     * @throws LocalizedException
     */
    private function getProductCollection(int $storeId): Collection
    {
        if (isset($this->collections[$storeId])) {
            return $this->collections[$storeId];
        }

        /** @var Collection $collection */
        $collection = $this->productCollectionFactory->create();

        $collection->addAttributeToSelect('*')
            ->addAttributeToFilter(ProductInterface::STATUS, Status::STATUS_ENABLED)
            ->addAttributeToFilter(ProductInterface::VISIBILITY, [
                'in' => [
                    Visibility::VISIBILITY_IN_CATALOG, Visibility::VISIBILITY_IN_SEARCH, Visibility::VISIBILITY_BOTH
                ]
            ])
            ->addStoreFilter($storeId);

        $this->collections[$storeId] = $collection;

        return $collection;
    }
}
