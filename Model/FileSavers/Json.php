<?php

declare(strict_types=1);

namespace Magenable\OpenAIAgenticCommerceFeed\Model\FileSavers;

use Magenable\OpenAIAgenticCommerceFeed\Api\FileSaverInterface;
use Magento\Framework\Serialize\Serializer\Json as JsonSerializer;
use Magenable\OpenAIAgenticCommerceFeed\Model\FileWriter;
use Magento\Store\Model\StoreManagerInterface;
use Magenable\OpenAIAgenticCommerceFeed\Helper\Data;
use Magento\Framework\Exception\LocalizedException;

class Json implements FileSaverInterface
{
    private JsonSerializer $jsonSerializer;
    private FileWriter $fileWriter;
    private StoreManagerInterface $storeManager;

    public function __construct(
        JsonSerializer $jsonSerializer,
        FileWriter $fileWriter,
        StoreManagerInterface $storeManager,
    ) {
        $this->jsonSerializer = $jsonSerializer;
        $this->fileWriter = $fileWriter;
        $this->storeManager = $storeManager;
    }

    /**
     * @throws LocalizedException
     */
    public function save(array $data, int $storeId): void
    {
        $jsonData = $this->jsonSerializer->serialize(['products' => $data]);
        $storeCode = $this->storeManager->getStore($storeId)->getCode();
        $this->fileWriter->write($jsonData, DATA::FEED_FILE_NAME . "_store_$storeCode.json");
    }
}
