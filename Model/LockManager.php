<?php

declare(strict_types=1);

namespace Magenable\OpenAIAgenticCommerceFeed\Model;

use Magento\Framework\Lock\LockManagerInterface;
use Magenable\OpenAIAgenticCommerceFeed\Exception\LockException;

class LockManager
{
    public const LOCK_NAME = 'MAGENABLE_OPENAI_AGENTIC_COMMERCE_FEED_025a453255975dc659a8ef6a937fef86';

    private LockManagerInterface $lockManager;

    public function __construct(
        LockManagerInterface $lockManager
    ) {
        $this->lockManager = $lockManager;
    }

    public function isLocked(): bool
    {
        return $this->lockManager->isLocked(self::LOCK_NAME);
    }

    /**
     * @throws LockException
     */
    public function lock(): bool
    {
        if (!$this->lockManager->lock(self::LOCK_NAME)) {
            throw new LockException(__('Could not lock for the feed generation process'));
        }

        return true;
    }

    public function unlock(): bool
    {
        if (!$this->lockManager->unlock(self::LOCK_NAME)) {
            throw new LockException(__('Could not unlock for the feed generation process'));
        }

        return true;
    }
}
