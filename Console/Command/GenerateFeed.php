<?php

declare(strict_types=1);

namespace Magenable\OpenAIAgenticCommerceFeed\Console\Command;

use Symfony\Component\Console\Command\Command;
use Magenable\OpenAIAgenticCommerceFeed\Model\GenerateFeedFactory as GenerateFeedModelFactory;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magenable\OpenAIAgenticCommerceFeed\Model\GenerateFeed as GenerateFeedModel;
use Magenable\OpenAIAgenticCommerceFeed\Exception\LockException;

class GenerateFeed extends Command
{
    private GenerateFeedModelFactory $generateFeedModelFactory;

    public function __construct(
        GenerateFeedModelFactory $generateFeedModelFactory
    ) {
        $this->generateFeedModelFactory = $generateFeedModelFactory;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('magenable:openai-agentic-commerce:generate-feed');
        $this->setDescription('Generate feed for OpenAI Agentic Commerce');

        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            /** @var GenerateFeedModel $generateFeedModel */
            $generateFeedModel = $this->generateFeedModelFactory->create();
            $generateFeedModel->execute();
            $output->writeln('<info>The feed successfully generated</info>');
        } catch (LockException $e) {
            $output->writeln('<comment>' . $e->getMessage() . '</comment>');
        }

        return 0;
    }
}
