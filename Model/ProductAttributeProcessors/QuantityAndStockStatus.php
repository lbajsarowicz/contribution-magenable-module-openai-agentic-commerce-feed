<?php

declare(strict_types=1);

namespace Magenable\OpenAIAgenticCommerceFeed\Model\ProductAttributeProcessors;

use Magenable\OpenAIAgenticCommerceFeed\Api\ProductAttributeProcessorInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\InventorySalesApi\Api\StockResolverInterface;
use Magento\InventorySalesApi\Api\GetProductSalableQtyInterface;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable as ConfigurableType;
use Magento\GroupedProduct\Model\Product\Type\Grouped as GroupedType;
use Magento\Bundle\Model\Product\Type as BundleType;
use Magento\Catalog\Api\ProductRepositoryInterface;

use Magento\Catalog\Model\Product\Type as ProductType;
use Magento\Downloadable\Model\Product\Type as DownloadableProductType;
use Magento\Catalog\Api\Data\ProductInterface;
use Magenable\OpenAIAgenticCommerceFeed\Helper\FeedAttributes;
use Magento\Catalog\Model\Product;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\NoSuchEntityException;

class QuantityAndStockStatus implements ProductAttributeProcessorInterface
{
    private StoreManagerInterface $storeManager;
    private StockResolverInterface $stockResolver;
    private GetProductSalableQtyInterface $getProductSalableQty;
    private ConfigurableType $configurableType;
    private GroupedType $groupedType;
    private BundleType $bundleType;
    private ProductRepositoryInterface $productRepository;

    public function __construct(
        StoreManagerInterface $storeManager,
        StockResolverInterface $stockResolver,
        GetProductSalableQtyInterface $getProductSalableQty,
        ConfigurableType $configurableType,
        GroupedType $groupedType,
        BundleType $bundleType,
        ProductRepositoryInterface $productRepository,
    ) {
        $this->storeManager = $storeManager;
        $this->stockResolver = $stockResolver;
        $this->getProductSalableQty = $getProductSalableQty;
        $this->configurableType = $configurableType;
        $this->groupedType = $groupedType;
        $this->bundleType = $bundleType;
        $this->productRepository = $productRepository;
    }

    /**
     * @throws LocalizedException
     */
    public function processProductAttribute(
        string $feedAttributeCode,
        string $websiteAttributeCode,
        ProductInterface $product
    ): ?string {
        if (!in_array($feedAttributeCode, $this->getFeedAttributeList())) {
            return $product->getData($websiteAttributeCode);
        }
        if ($feedAttributeCode === FeedAttributes::ATTR_AVAILABILITY) {
            return $product->isSalable() ? 'in_stock' : 'out_of_stock';
        }

        if (in_array(
            $product->getTypeId(),
            [ConfigurableType::TYPE_CODE, GroupedType::TYPE_CODE, BundleType::TYPE_CODE]
        )) {
            return $this->get($product);
        }
        if (in_array(
            $product->getTypeId(),
            [ProductType::TYPE_SIMPLE, DownloadableProductType::TYPE_DOWNLOADABLE]
        )) {
            return (string)$this->getProductQty($product);
        }

        return null;
    }

    public function getFeedAttributeList(): array
    {
        return [FeedAttributes::ATTR_AVAILABILITY, FeedAttributes::ATTR_INVENTORY_QUANTITY];
    }

    /**
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    private function get(ProductInterface $product): string
    {
        $children = [];
        /** @var Product $product */
        switch ($product->getTypeId()) {
            case ConfigurableType::TYPE_CODE:
                foreach ($this->configurableType->getUsedProducts($product) as $child) {
                    $children[] = $child->getId();
                }
                break;
            case GroupedType::TYPE_CODE:
                foreach ($this->groupedType->getAssociatedProducts($product) as $child) {
                    $children[] = $child->getId();
                }
                break;
            case BundleType::TYPE_CODE:
                $optionIds = $this->bundleType->getOptionsIds($product);
                $selections = $this->bundleType->getSelectionsCollection($optionIds, $product);
                foreach ($selections as $selection) {
                    $children[] = (int)$selection->getProductId();
                }
                break;
        }

        $maxQty = 0;
        foreach ($children as $child) {
            $childProduct = $this->productRepository->getById((int)$child);
            $qty = $this->getProductQty($childProduct);
            if ($qty > $maxQty) {
                $maxQty = $qty;
            }
        }

        return (string)$maxQty;
    }

    /**
     * @throws NoSuchEntityException
     * @throws InputException
     * @throws LocalizedException
     */
    private function getProductQty(ProductInterface $product): int
    {
        $stock = $this->stockResolver->execute(
            'website',
            $this->storeManager->getStore((int)$product->getStoreId())->getWebsite()->getCode()
        );

        return (int)$this->getProductSalableQty->execute(
            $product->getSku(),
            $stock->getStockId()
        );
    }
}
