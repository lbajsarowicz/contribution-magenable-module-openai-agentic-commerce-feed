<?php

declare(strict_types=1);

namespace Magenable\OpenAIAgenticCommerceFeed\Block\Adminhtml\Form\Field;

use Magenable\OpenAIAgenticCommerceFeed\Model\Config\Source\WebsiteAttributes as WebsiteAttributesSource;
use Magento\Framework\View\Element\Context;
use Magento\Framework\View\Element\Html\Select;

class WebsiteAttributes extends Select
{
    private WebsiteAttributesSource $websiteAttributes;

    public function __construct(
        Context $context,
        WebsiteAttributesSource $websiteAttributes,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->websiteAttributes = $websiteAttributes;
    }

    protected function _toHtml()
    {
        if (!$this->getOptions()) {
            $this->setOptions($this->websiteAttributes->toOptionArray());
        }
        return parent::_toHtml();
    }

    public function setInputName(string $value): self
    {
        return $this->setName($value);
    }
}
