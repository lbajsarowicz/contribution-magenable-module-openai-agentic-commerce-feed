<?php

declare(strict_types=1);

namespace Magenable\OpenAIAgenticCommerceFeed\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magenable\OpenAIAgenticCommerceFeed\Model\LockManager;

class GenerationProgress implements ArgumentInterface
{
    private LockManager $lockManager;

    public function __construct(
        LockManager $lockManager,
    ) {
        $this->lockManager = $lockManager;
    }

    public function generationIsRunning(): int
    {
        if ($this->lockManager->isLocked()) {
            return 1;
        }

        return 0;
    }
}
