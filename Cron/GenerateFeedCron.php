<?php

declare(strict_types=1);

namespace Magenable\OpenAIAgenticCommerceFeed\Cron;

use Magenable\OpenAIAgenticCommerceFeed\Model\GenerateFeed;
use Magenable\OpenAIAgenticCommerceFeed\Exception\LockException;
use Magento\Framework\Exception\LocalizedException;

class GenerateFeedCron
{
    private GenerateFeed $generateFeed;

    public function __construct(GenerateFeed $generateFeed)
    {
        $this->generateFeed = $generateFeed;
    }

    /**
     * @throws LocalizedException
     * @throws LockException
     */
    public function run(): void
    {
        $this->generateFeed->execute();
    }
}
