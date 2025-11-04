<?php

declare(strict_types=1);

namespace Magenable\OpenAIAgenticCommerceFeed\Block\Adminhtml\System\Config;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Backend\Block\Template\Context;
use Magenable\OpenAIAgenticCommerceFeed\ViewModel\LastGenerationDate as LastGenerationDateViewModel;
use Magento\Framework\View\Helper\SecureHtmlRenderer;
use Magento\Framework\Data\Form\Element\AbstractElement;

class LastGenerationDate extends Field
{
    private LastGenerationDateViewModel $viewModel;

    public function __construct(
        Context $context,
        LastGenerationDateViewModel $viewModel,
        array $data = [],
        ?SecureHtmlRenderer $secureRenderer = null
    ) {
        parent::__construct($context, $data, $secureRenderer);
        $this->viewModel = $viewModel;
    }

    protected function _prepareLayout()
    {
        if (!$this->viewModel->getDate()) {
            return $this;
        }
        parent::_prepareLayout();
        $this->setTemplate('Magenable_OpenAIAgenticCommerceFeed::system/config/last-generation-date.phtml');
        return $this;
    }

    public function render(AbstractElement $element)
    {
        if (!$this->viewModel->getDate()) {
            return '';
        }
        $element = clone $element;
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    public function getViewModel(): LastGenerationDateViewModel
    {
        return $this->viewModel;
    }

    protected function _getElementHtml(AbstractElement $element): string
    {
        $this->addData(
            [
                'html_id' => $element->getHtmlId(),
            ]
        );

        return $this->_toHtml();
    }
}
