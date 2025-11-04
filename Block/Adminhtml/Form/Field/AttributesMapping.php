<?php

declare(strict_types=1);

namespace Magenable\OpenAIAgenticCommerceFeed\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;
use Magenable\OpenAIAgenticCommerceFeed\Helper\Data;

class AttributesMapping extends AbstractFieldArray
{
    private ?FeedAttributes $feedAttributeRenderer = null;
    private ?WebsiteAttributes $websiteAttributeRenderer = null;

    protected function _prepareToRender()
    {
        $this->addColumn(
            Data::FIELD_FEED_ATTRIBUTE,
            [
                'label' => __('Feed Attribute'),
                'class' => 'required-entry',
                'renderer' => $this->getFeedAttributeRenderer(),
            ]
        );
        $this->addColumn(
            Data::FIELD_WEBSITE_ATTRIBUTE,
            [
                'label' => __('Website Attribute'),
                'class' => 'required-entry',
                'renderer' => $this->getWebsiteAttributeRenderer(),
            ]
        );
        $this->addColumn(
            Data::FIELD_CUSTOM_VALUE,
            [
                'label' => __('Custom Value'),
            ]
        );
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add')->render();
    }

    protected function getFeedAttributeRenderer(): FeedAttributes
    {
        if (!$this->feedAttributeRenderer) {
            $this->feedAttributeRenderer = $this->getLayout()->createBlock(
                FeedAttributes::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }
        return $this->feedAttributeRenderer;
    }

    protected function getWebsiteAttributeRenderer(): WebsiteAttributes
    {
        if (!$this->websiteAttributeRenderer) {
            $this->websiteAttributeRenderer = $this->getLayout()->createBlock(
                WebsiteAttributes::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }
        return $this->websiteAttributeRenderer;
    }

    protected function _prepareArrayRow(DataObject $row): void
    {
        $feedAttribute = $row->getData(Data::FIELD_FEED_ATTRIBUTE);
        $websiteAttribute = $row->getData(Data::FIELD_WEBSITE_ATTRIBUTE);
        $options = [];

        if ($feedAttribute && $websiteAttribute) {
            $options['option_' . $this->getFeedAttributeRenderer()->calcOptionHash($feedAttribute)] =
            $options['option_' . $this->getWebsiteAttributeRenderer()->calcOptionHash($websiteAttribute)]
                = 'selected="selected"';
        }
        $row->setData('option_extra_attrs', $options);
    }
}
