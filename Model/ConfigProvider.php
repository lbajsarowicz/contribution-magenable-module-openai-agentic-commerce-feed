<?php

declare(strict_types=1);

namespace Magenable\OpenAIAgenticCommerceFeed\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\App\Config\ReinitableConfigInterface;
use Magento\Store\Model\ScopeInterface;

class ConfigProvider
{
    public const CONFIG_ENABLED = 'magenable_openai_agentic_commerce_feed/general/enabled';
    public const CONFIG_MAPPING = 'magenable_openai_agentic_commerce_feed/general/attributes_mapping';
    public const CONFIG_FILE_FORMAT = 'magenable_openai_agentic_commerce_feed/general/file_format';
    public const CONFIG_LAST_GENERATION_TIMESTAMP =
        'magenable_openai_agentic_commerce_feed/general/last_generation_timestamp';
    public const CONFIG_GENERATION_PROGRESS_COUNT =
        'magenable_openai_agentic_commerce_feed/general/generation_progress_count';
    public const CONFIG_GENERATION_CURRENT_PROGRESS =
        'magenable_openai_agentic_commerce_feed/general/generation_current_progress';
    public const CONFIG_GENERATION_PROGRESS_STORE =
        'magenable_openai_agentic_commerce_feed/general/generation_progress_store';

    private ScopeConfigInterface $scopeConfig;
    private WriterInterface $writer;
    private Json $json;
    private ReinitableConfigInterface $reinitableConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        WriterInterface $writer,
        Json $json,
        ReinitableConfigInterface $reinitableConfig,
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->writer = $writer;
        $this->json = $json;
        $this->reinitableConfig = $reinitableConfig;
    }

    public function moduleIsEnabled(): bool
    {
        return (bool)$this->scopeConfig->getValue(
            self::CONFIG_ENABLED,
            ScopeInterface::SCOPE_STORES
        );
    }

    public function getAttributesMapping(): array
    {
        $attributesMapping = $this->scopeConfig->getValue(
            self::CONFIG_MAPPING,
            ScopeInterface::SCOPE_STORES
        );

        return is_string($attributesMapping) ? $this->json->unserialize($attributesMapping) : $attributesMapping;
    }

    public function getFileFormat(): string
    {
        return $this->scopeConfig->getValue(
            self::CONFIG_FILE_FORMAT,
            ScopeInterface::SCOPE_STORES
        );
    }

    public function getLastGenerationTimestamp(): string
    {
        return (string)$this->scopeConfig->getValue(
            self::CONFIG_LAST_GENERATION_TIMESTAMP,
            ScopeInterface::SCOPE_STORES
        );
    }

    public function setLastGenerationTimestamp(string $date): void
    {
        $this->writer->save(self::CONFIG_LAST_GENERATION_TIMESTAMP, $date);
        $this->reinitableConfig->reinit();
    }

    public function getGenerationProgressCount(): ?int
    {
        $count = $this->scopeConfig->getValue(
            self::CONFIG_GENERATION_PROGRESS_COUNT,
            ScopeInterface::SCOPE_STORES
        );

        return $count ? (int)$count : null;
    }

    public function setGenerationProgressCount(int $count): void
    {
        $this->writer->save(self::CONFIG_GENERATION_PROGRESS_COUNT, $count);
        $this->reinitableConfig->reinit();
    }

    public function getGenerationCurrentProgress(): ?int
    {
        $current = $this->scopeConfig->getValue(
            self::CONFIG_GENERATION_CURRENT_PROGRESS,
            ScopeInterface::SCOPE_STORES
        );

        return $current ? (int)$current : null;
    }

    public function setGenerationCurrentProgress(int $current): void
    {
        $this->writer->save(self::CONFIG_GENERATION_CURRENT_PROGRESS, $current);
        $this->reinitableConfig->reinit();
    }

    public function getGenerationProgressStore(): ?int
    {
        $store = $this->scopeConfig->getValue(
            self::CONFIG_GENERATION_PROGRESS_STORE,
            ScopeInterface::SCOPE_STORES
        );

        return $store ? (int)$store : null;
    }

    public function setGenerationProgressStore(int $storeId): void
    {
        $this->writer->save(self::CONFIG_GENERATION_PROGRESS_STORE, $storeId);
        $this->reinitableConfig->reinit();
    }
}
