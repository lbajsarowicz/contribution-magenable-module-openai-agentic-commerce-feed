<?php

declare(strict_types=1);

namespace Magenable\OpenAIAgenticCommerceFeed\Model;

use Magento\Framework\Filesystem\Directory\WriteInterface;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Io\File;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magenable\OpenAIAgenticCommerceFeed\Helper\Data;
use Magento\Framework\Exception\FileSystemException;

class RemoveFeedFiles
{
    private WriteInterface $mediaDirectory;
    private File $ioFile;

    /**
     * @throws FileSystemException
     */
    public function __construct(Filesystem $filesystem, File $ioFile)
    {
        $this->mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->ioFile = $ioFile;
    }

    public function execute(): void
    {
        $path = $this->mediaDirectory->getAbsolutePath() . DATA::FEED_FOLDER_NAME;
        if (!$this->ioFile->fileExists($path, false)) {
            return;
        }

        $this->ioFile->rmdir($path, true);
    }
}
