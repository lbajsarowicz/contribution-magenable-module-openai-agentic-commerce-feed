<?php

declare(strict_types=1);

namespace Magenable\OpenAIAgenticCommerceFeed\Model;

use Magenable\OpenAIAgenticCommerceFeed\Api\FileSaverInterface;
use Magento\Framework\Exception\LocalizedException;

class FileSaver implements FileSaverInterface
{
    private array $fileSavers;
    private ConfigProvider $configProvider;

    public function __construct(
        array $fileSavers,
        ConfigProvider $configProvider,
    ) {
        $this->fileSavers = $fileSavers;
        $this->configProvider = $configProvider;
    }

    /**
     * @throws LocalizedException
     */
    public function save(array $data, int $storeId): void
    {
        $configuredFileFormat = $this->configProvider->getFileFormat();
        if (!isset($this->fileSavers[$configuredFileFormat])) {
            throw new LocalizedException(
                __(
                    'No File Saver was found for the configured file format `%1`.',
                    $configuredFileFormat
                )
            );
        }

        $fileSaver = $this->fileSavers[$configuredFileFormat];
        if (gettype($fileSaver) !== 'object') {
            throw new LocalizedException(__(
                'The provided File Saver `%1` should be of type `object` but it has type `%2`.',
                $configuredFileFormat,
                gettype($fileSaver)
            ));
        }
        if (!$fileSaver instanceof FileSaverInterface) {
            throw new LocalizedException(
                __(
                    'The provided File Saver `%1` should be instance of `%2`.',
                    $configuredFileFormat,
                    FileSaverInterface::class
                )
            );
        }

        $fileSaver->save($data, $storeId);
    }
}
