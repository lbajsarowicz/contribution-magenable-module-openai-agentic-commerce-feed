<?php

declare(strict_types=1);

namespace Magenable\OpenAIAgenticCommerceFeed\Model;

use Magento\Framework\Filesystem\Directory\WriteInterface;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magenable\OpenAIAgenticCommerceFeed\Helper\Data;
use Magento\Framework\Exception\FileSystemException;

class FileWriter
{
    private WriteInterface $mediaDirectory;

    /**
     * @throws FileSystemException
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
    }

    /**
     * @throws FileSystemException
     */
    public function write(string $content, string $fileName): void
    {
        $stream = $this->mediaDirectory->openFile(
            $this->mediaDirectory->getAbsolutePath() . DATA::FEED_FOLDER_NAME . DIRECTORY_SEPARATOR . $fileName,
            'w+'
        );
        $stream->write($content);
        $stream->close();
    }
}
