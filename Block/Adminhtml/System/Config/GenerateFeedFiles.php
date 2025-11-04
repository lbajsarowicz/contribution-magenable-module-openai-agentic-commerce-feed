<?php

declare(strict_types=1);

namespace Magenable\OpenAIAgenticCommerceFeed\Block\Adminhtml\System\Config;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class GenerateFeedFiles extends Field
{
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->setTemplate('Magenable_OpenAIAgenticCommerceFeed::system/config/generate-feed-files.phtml');
        return $this;
    }

    public function render(AbstractElement $element)
    {
        $element = clone $element;
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    protected function _getElementHtml(AbstractElement $element): string
    {
        $originalData = $element->getOriginalData();
        $this->addData(
            [
                'button_label' => __($originalData['button_label']),
                'html_id' => $element->getHtmlId(),
                'ajax_url' => $this->_urlBuilder->getUrl(
                    'magenable_openai_agentic_commerce_feed/system_config/generatefeedfiles'
                ),
                'field_mapping' => str_replace('"', '\\"', json_encode($this->_getFieldMapping()))
            ]
        );

        return $this->_toHtml();
    }

    protected function _getFieldMapping()
    {
        return [
            'file_format' => 'magenable_openai_agentic_commerce_feed_general_file_format'
        ];
    }
}
