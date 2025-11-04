<?php

declare(strict_types=1);

namespace Magenable\OpenAIAgenticCommerceFeed\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magenable\OpenAIAgenticCommerceFeed\Model\ConfigProvider;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\Stdlib\DateTime;

class LastGenerationDate implements ArgumentInterface
{
    private ConfigProvider $configProvider;
    private TimezoneInterface $timezone;
    private DateTime $dateTime;

    public function __construct(
        ConfigProvider $configProvider,
        TimezoneInterface $timezone,
        DateTime $dateTime
    ) {
        $this->configProvider = $configProvider;
        $this->timezone = $timezone;
        $this->dateTime = $dateTime;
    }

    public function getDate(): string
    {
        if (!$timestamp = $this->configProvider->getLastGenerationTimestamp()) {
            return '';
        }

        return $this->dateTime->formatDate(
            $this->timezone->date($timestamp)
        );
    }
}
