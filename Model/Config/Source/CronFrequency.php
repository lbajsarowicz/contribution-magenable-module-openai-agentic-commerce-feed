<?php

declare(strict_types=1);

namespace Magenable\OpenAIAgenticCommerceFeed\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class CronFrequency implements OptionSourceInterface
{
    public function toOptionArray(): array
    {
        return [
            '*/10 * * * *' => 'Every 10 Minutes',
            '*/30 * * * *' => 'Every 30 Minutes',
            '0 * * * *' => 'Every Hour',
            '0 */2 * * *' => 'Every Two Hours',
            '0 */6 * * *' => 'Every Six Hours',
            '0 */12 * * *' => 'Every 12 Hours',
            '*/5 9-17 * * *' => 'During the Work Day',
            '0 0 * * *' => 'Every day at Midnight',
        ];
    }
}
