<?php

declare(strict_types=1);

namespace Magenable\OpenAIAgenticCommerceFeed\Controller\Adminhtml\System\Config;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magenable\OpenAIAgenticCommerceFeed\Model\RemoveFeedFiles as RemoveFeedFilesModel;
use Magento\Framework\Controller\Result\Json;
use Exception;

class RemoveFeedFiles extends Action
{
    const ADMIN_RESOURCE = 'Magenable_OpenAIAgenticCommerceFeed::configuration';
    private JsonFactory $resultJsonFactory;
    private RemoveFeedFilesModel $removeFeedFilesModel;

    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        RemoveFeedFilesModel $removeFeedFilesModel,
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->removeFeedFilesModel = $removeFeedFilesModel;
    }

    public function execute(): Json
    {
        $result = [
            'success' => false,
            'errorMessage' => '',
        ];

        try {
            $this->removeFeedFilesModel->execute();
            $result['success'] = true;
        } catch (Exception $e) {
            $result['errorMessage'] = $e->getMessage();
        }

        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData($result);
    }
}
