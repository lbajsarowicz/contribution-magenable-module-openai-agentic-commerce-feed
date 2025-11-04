<?php

declare(strict_types=1);

namespace Magenable\OpenAIAgenticCommerceFeed\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Io\File;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magenable\OpenAIAgenticCommerceFeed\Helper\Data;
use Magento\Framework\UrlInterface;
use Magento\Framework\Exception\LocalizedException;

class FeedFiles implements ArgumentInterface
{
    private Filesystem $filesystem;
    private File $ioFile;
    private StoreManagerInterface $storeManager;

    public function __construct(Filesystem $filesystem, File $ioFile, StoreManagerInterface $storeManager)
    {
        $this->filesystem = $filesystem;
        $this->ioFile = $ioFile;
        $this->storeManager = $storeManager;
    }

    /**
     * @return array<int, array{name: string, url: string}>
     * @throws LocalizedException
     */
    public function getFiles(): array
    {
        $files = [];
        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        $path = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath(Data::FEED_FOLDER_NAME);
        if (!$this->ioFile->fileExists($path, false)) {
            return [];
        }
        $this->ioFile->cd($path);

        foreach ($this->ioFile->ls() as $file) {
            $files[] = [
                'name' => $file['text'],
                'url' => $mediaUrl . Data::FEED_FOLDER_NAME
                    . DIRECTORY_SEPARATOR . $file['text']
            ];
        }

        return $files;
    }
}
