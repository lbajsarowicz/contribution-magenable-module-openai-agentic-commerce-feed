<?php

declare(strict_types=1);

namespace Magenable\OpenAIAgenticCommerceFeed\Block\Adminhtml\System\Config;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Backend\Block\Template\Context;
use Magenable\OpenAIAgenticCommerceFeed\ViewModel\FeedFiles as FeedFilesViewModel;
use Magento\Framework\View\Helper\SecureHtmlRenderer;
use Magento\Framework\Data\Form\Element\AbstractElement;

class RemoveFeedFiles extends Field
{
    private FeedFilesViewModel $viewModel;

    public function __construct(
        Context $context,
        FeedFilesViewModel $viewModel,
        array $data = [],
        ?SecureHtmlRenderer $secureRenderer = null
    ) {
        $data['template'] = 'Magenable_OpenAIAgenticCommerceFeed::system/config/remove-feed-files.phtml';
        parent::__construct($context, $data, $secureRenderer);
        $this->viewModel = $viewModel;
    }

    protected function _prepareLayout()
    {
        if (!$this->viewModel->getFiles()) {
            return $this;
        }
        parent::_prepareLayout();
        return $this;
    }

    public function render(AbstractElement $element)
    {
        if (!$this->viewModel->getFiles()) {
            return '';
        }
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
                    'magenable_openai_agentic_commerce_feed/system_config/removefeedfiles'
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
