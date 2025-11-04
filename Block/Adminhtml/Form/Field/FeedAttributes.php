<?php

declare(strict_types=1);

namespace Magenable\OpenAIAgenticCommerceFeed\Block\Adminhtml\Form\Field;

use Magenable\OpenAIAgenticCommerceFeed\Model\Config\Source\FeedAttributes as FeedAttributesSource;
use Magento\Framework\View\Element\Context;
use Magento\Framework\View\Element\Html\Select;

class FeedAttributes extends Select
{
    private FeedAttributesSource $feedAttributes;

    public function __construct(
        Context $context,
        FeedAttributesSource $feedAttributes,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->feedAttributes = $feedAttributes;
    }

    protected function _toHtml()
    {
        if (!$this->getOptions()) {
            $this->setOptions($this->feedAttributes->toOptionArray());
        }
        return parent::_toHtml();
    }

    public function setInputName(string $value): FeedAttributes
    {
        return $this->setName($value);
    }
}
