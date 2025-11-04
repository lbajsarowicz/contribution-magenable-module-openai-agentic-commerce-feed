<?php

declare(strict_types=1);

namespace Magenable\OpenAIAgenticCommerceFeed\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class FileFormats implements OptionSourceInterface
{
    public function toOptionArray(): array
    {
        return [
            'xml' => [
                'value' => 'xml',
                'label' => 'XML'
            ],
            'json' => [
                'value' => 'json',
                'label' => 'JSON'
            ],
        ];
    }
}
