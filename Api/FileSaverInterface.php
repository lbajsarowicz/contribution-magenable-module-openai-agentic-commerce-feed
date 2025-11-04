<?php

declare(strict_types=1);

namespace Magenable\OpenAIAgenticCommerceFeed\Api;

interface FileSaverInterface
{
    public function save(array $data, int $storeId): void;
}
