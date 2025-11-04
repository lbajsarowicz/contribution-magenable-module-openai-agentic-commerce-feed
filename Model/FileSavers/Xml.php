<?php

declare(strict_types=1);

namespace Magenable\OpenAIAgenticCommerceFeed\Model\FileSavers;

use Magenable\OpenAIAgenticCommerceFeed\Api\FileSaverInterface;
use Magento\Framework\Xml\GeneratorFactory as XmlGeneratorFactory;
use Magenable\OpenAIAgenticCommerceFeed\Model\FileWriter;
use Magento\Store\Model\StoreManagerInterface;
use Magenable\OpenAIAgenticCommerceFeed\Helper\Data;
use Magento\Framework\Exception\LocalizedException;

class Xml implements FileSaverInterface
{
    private XmlGeneratorFactory $xmlGeneratorFactory;
    private FileWriter $fileWriter;
    private StoreManagerInterface $storeManager;

    public function __construct(
        XmlGeneratorFactory $xmlGeneratorFactory,
        FileWriter $fileWriter,
        StoreManagerInterface $storeManager,
    ) {
        $this->xmlGeneratorFactory = $xmlGeneratorFactory;
        $this->fileWriter = $fileWriter;
        $this->storeManager = $storeManager;
    }

    /**
     * @throws LocalizedException
     */
    public function save(array $data, int $storeId): void
    {
        $xmlGenerator = $this->xmlGeneratorFactory->create();
        $xmlGenerator->setIndexedArrayItemName('product');
        try {
            $xmlData = $xmlGenerator->arrayToXml(['products' => $data]);
        } catch (\DOMException $e) {
            throw new LocalizedException(__('Could not generate XML data.'));
        }

        $storeCode = $this->storeManager->getStore($storeId)->getCode();
        $this->fileWriter->write((string)$xmlData, DATA::FEED_FILE_NAME . "_store_$storeCode.xml");
    }
}
