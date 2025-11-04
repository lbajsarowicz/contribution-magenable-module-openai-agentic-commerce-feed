<?php

declare(strict_types=1);

namespace Magenable\OpenAIAgenticCommerceFeed\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magenable\OpenAIAgenticCommerceFeed\Helper\FeedAttributes as HelperFeedAttributes;

class FeedAttributes implements OptionSourceInterface
{
    public function toOptionArray(): array
    {
        return [
            HelperFeedAttributes::ATTR_ENABLE_SEARCH => [
                'value' => HelperFeedAttributes::ATTR_ENABLE_SEARCH,
                'label' => HelperFeedAttributes::ATTR_ENABLE_SEARCH . ' - Controls whether the product can be surfaced
                    in ChatGPT search results (true, false)'
            ],
            HelperFeedAttributes::ATTR_ENABLE_CHECKOUT => [
                'value' => HelperFeedAttributes::ATTR_ENABLE_CHECKOUT,
                'label' => HelperFeedAttributes::ATTR_ENABLE_CHECKOUT . ' - Allows direct purchase inside ChatGPT
                    (true, false)'
            ],
            'id' => [
                'value' => 'id',
                'label' => 'id - Merchant product ID (unique)'
            ],
            'gtin' => [
                'value' => 'gtin',
                'label' => 'gtin - Universal product identifier (GTIN, UPC, ISBN)'
            ],
            'mpn' => [
                'value' => 'mpn',
                'label' => 'mpn - Manufacturer part number (mpn)'
            ],
            'title' => [
                'value' => 'title',
                'label' => 'title - Product title'
            ],
            'description' => [
                'value' => 'description',
                'label' => 'description - Full product description'
            ],
            HelperFeedAttributes::ATTR_LINK => [
                'value' => HelperFeedAttributes::ATTR_LINK,
                'label' => HelperFeedAttributes::ATTR_LINK . ' - Product detail page URL'
            ],
            'condition' => [
                'value' => 'condition',
                'label' => 'condition - Condition of product (new, refurbished, used)'
            ],
            'product_category' => [
                'value' => 'product_category',
                'label' => 'product_category - Category path (Category taxonomy)'
            ],
            'brand' => [
                'value' => 'brand',
                'label' => 'brand - Product brand'
            ],
            'material' => [
                'value' => 'material',
                'label' => 'material - Primary material(s)'
            ],
            'dimensions' => [
                'value' => 'dimensions',
                'label' => 'dimensions - Overall dimensions (Example: LxWxH unit)'
            ],
            'length' => [
                'value' => 'length',
                'label' => 'length - Individual dimension (Length) (Example: 10 mm)'
            ],
            'width' => [
                'value' => 'width',
                'label' => 'width - Individual dimension (Width) (Example: 10 mm)'
            ],
            'height' => [
                'value' => 'height',
                'label' => 'height - Individual dimension (Height) (Example: 10 mm)'
            ],
            'weight' => [
                'value' => 'weight',
                'label' => 'weight - Product weight (Example: 1.5 lb)'
            ],
            'age_group' => [
                'value' => 'age_group',
                'label' => 'age_group - Target demographic (newborn, infant, toddler, kids, adult)'
            ],
            HelperFeedAttributes::ATTR_IMAGE_LINK => [
                'value' => HelperFeedAttributes::ATTR_IMAGE_LINK,
                'label' => HelperFeedAttributes::ATTR_IMAGE_LINK . ' - Main product image URL'
            ],
            'additional_image_link' => [
                'value' => 'additional_image_link',
                'label' => 'additional_image_link - Extra images URLs'
            ],
            'video_link' => [
                'value' => 'video_link',
                'label' => 'video_link - Product video link'
            ],
            'model_3d_link' => [
                'value' => 'model_3d_link',
                'label' => 'model_3d_link - 3D model link'
            ],
            HelperFeedAttributes::ATTR_PRICE => [
                'value' => HelperFeedAttributes::ATTR_PRICE,
                'label' => HelperFeedAttributes::ATTR_PRICE . ' - Regular price'
            ],
            'applicable_taxes_fees' => [
                'value' => 'applicable_taxes_fees',
                'label' => 'applicable_taxes_fees - Additional taxes/fees'
            ],
            'sale_price' => [
                'value' => 'sale_price',
                'label' => 'sale_price - Discounted price'
            ],
            'sale_price_effective_date' => [
                'value' => 'sale_price_effective_date',
                'label' => 'sale_price_effective_date - Sale window (Example: 2025-07-01 / 2025-07-15)'
            ],
            'unit_pricing_measure' => [
                'value' => 'unit_pricing_measure',
                'label' => 'unit_pricing_measure - Unit price measure (Example: 16 oz)'
            ],
            'base_measure' => [
                'value' => 'base_measure',
                'label' => 'base_measure - Base measure (Example: 1 oz)'
            ],
            'pricing_trend' => [
                'value' => 'pricing_trend',
                'label' => 'pricing_trend - Lowest price in N months (Example: Lowest price in 6 months)'
            ],
            HelperFeedAttributes::ATTR_AVAILABILITY => [
                'value' => HelperFeedAttributes::ATTR_AVAILABILITY,
                'label' => HelperFeedAttributes::ATTR_AVAILABILITY . ' - Product availability
                    (in_stock, out_of_stock, preorder)'
            ],
            'availability_date' => [
                'value' => 'availability_date',
                'label' => 'availability_date - Availability date if preorder (Example: 2025-12-01)'
            ],
            HelperFeedAttributes::ATTR_INVENTORY_QUANTITY => [
                'value' => HelperFeedAttributes::ATTR_INVENTORY_QUANTITY,
                'label' => HelperFeedAttributes::ATTR_INVENTORY_QUANTITY . ' - Stock count (Example: 25)'
            ],
            'expiration_date' => [
                'value' => 'expiration_date',
                'label' => 'expiration_date - Remove product after date (Example: 2025-12-01)'
            ],
            'pickup_method' => [
                'value' => 'pickup_method',
                'label' => 'pickup_method - Pickup options (in_store, reserve, not_supported)'
            ],
            'pickup_sla' => [
                'value' => 'pickup_sla',
                'label' => 'pickup_sla - Pickup SLA (Example: 1 day)'
            ],
            'item_group_id' => [
                'value' => 'item_group_id',
                'label' => 'item_group_id - Variant group ID (Example: SHOE123GROUP)'
            ],
            'item_group_title' => [
                'value' => 'item_group_title',
                'label' => 'item_group_title - Group product title (Example: Men\'s Trail Running Shoes)'
            ],
            'color' => [
                'value' => 'color',
                'label' => 'color - Variant color (Example: Blue)'
            ],
            'size' => [
                'value' => 'size',
                'label' => 'size - Variant size (Example: 10)'
            ],
            'size_system' => [
                'value' => 'size_system',
                'label' => 'size_system - Size System (Example: US)'
            ],
            'gender' => [
                'value' => 'gender',
                'label' => 'gender - Gender (Example: male)'
            ],
            'offer_id' => [
                'value' => 'offer_id',
                'label' => 'offer_id - Offer ID (SKU+seller+price)	(Example: SKU12345-Blue-79.99)'
            ],
            'Custom_variant1_category' => [
                'value' => 'Custom_variant1_category',
                'label' => 'Custom_variant1_category - Custom variant dimension 1 (Example: Size_Type)'
            ],
            'Custom_variant1_option' => [
                'value' => 'Custom_variant1_option',
                'label' => 'Custom_variant1_option - Custom variant 1 option (Example: Petite / Tall / Maternity)'
            ],
            'Custom_variant2_category' => [
                'value' => 'Custom_variant2_category',
                'label' => 'Custom_variant2_category - Custom variant dimension 2 (Example: Wood_Type)'
            ],
            'Custom_variant2_option' => [
                'value' => 'Custom_variant2_option',
                'label' => 'Custom_variant2_option - Custom variant 2 option (Example: Oak / Mahogany / Walnut)'
            ],
            'Custom_variant3_category' => [
                'value' => 'Custom_variant3_category',
                'label' => 'Custom_variant3_category - Custom variant dimension 3 (Example: Cap_Type)'
            ],
            'Custom_variant3_option' => [
                'value' => 'Custom_variant3_option',
                'label' => 'Custom_variant3_option - Custom variant 3 option (Example: Snapback / Fitted)'
            ],
            'shipping' => [
                'value' => 'shipping',
                'label' => 'shipping - Shipping method/cost/region (Example: US:CA:Overnight:16.00 USD)'
            ],
            'delivery_estimate' => [
                'value' => 'delivery_estimate',
                'label' => 'delivery_estimate - Estimated arrival date (Example: 2025-08-12)'
            ],
            'seller_name' => [
                'value' => 'seller_name',
                'label' => 'seller_name - Seller name (Example: My Store)'
            ],
            'seller_url' => [
                'value' => 'seller_url',
                'label' => 'seller_url - Seller page URL (Example: https://example.com/store)'
            ],
            'seller_privacy_policy' => [
                'value' => 'seller_privacy_policy',
                'label' => 'seller_privacy_policy - Seller-specific policies (Example: https://example.com/privacy)'
            ],
            'seller_tos' => [
                'value' => 'seller_tos',
                'label' => 'seller_tos - Seller-specific terms of service (Example: https://example.com/terms)'
            ],
            'return_policy' => [
                'value' => 'return_policy',
                'label' => 'return_policy - Return policy URL (Example: https://example.com/returns)'
            ],
            'return_window' => [
                'value' => 'return_window',
                'label' => 'return_window - Days allowed for return (Example: 30)'
            ],
            'popularity_score' => [
                'value' => 'popularity_score',
                'label' => 'popularity_score - Popularity indicator (example: 4.7)'
            ],
            'return_rate' => [
                'value' => 'return_rate',
                'label' => 'return_rate - Return rate	(Example: 2%)'
            ],
            'warning' => [
                'value' => 'warning',
                'label' => 'warning - Product disclaimers (Example: Contains lithium battery, or CA Prop 65 warning)'
            ],
            'warning_url' => [
                'value' => 'warning_url',
                'label' => 'warning_url - Warning URL'
            ],
            'age_restriction' => [
                'value' => 'age_restriction',
                'label' => 'age_restriction - Minimum purchase age (Example: 21)'
            ],
            'product_review_count' => [
                'value' => 'product_review_count',
                'label' => 'product_review_count - Number of product reviews (Example: 254)'
            ],
            'product_review_rating' => [
                'value' => 'product_review_rating',
                'label' => 'product_review_rating - Average review score (Example: 4.6)'
            ],
            'store_review_count' => [
                'value' => 'store_review_count',
                'label' => 'store_review_count - Number of brand/store reviews (Example: 2000)'
            ],
            'store_review_rating' => [
                'value' => 'store_review_rating',
                'label' => 'store_review_rating - Average store rating (Example: 4.8)'
            ],
            'q_and_a' => [
                'value' => 'q_and_a',
                'label' => 'q_and_a - FAQ content (Example: Q: Is this waterproof? A: Yes)'
            ],
            'raw_review_data' => [
                'value' => 'raw_review_data',
                'label' => 'raw_review_data - Raw review payload'
            ],
            'related_product_id' => [
                'value' => 'related_product_id',
                'label' => 'related_product_id - Associated product IDs (Example: SKU67890)'
            ],
            'relationship_type' => [
                'value' => 'relationship_type',
                'label' => 'relationship_type - Relationship type (part_of_set, required_part, often_bought_with,
                    substitute, different_brand, accessory)'
            ],
            'geo_price' => [
                'value' => 'geo_price',
                'label' => 'geo_price - Price by region (Example: 79.99 USD (California))'
            ],
            'geo_availability' => [
                'value' => 'geo_availability',
                'label' => 'geo_availability - Availability per region (Example: in_stock (Texas),
                    out_of_stock (New York))'
            ],
        ];
    }
}
