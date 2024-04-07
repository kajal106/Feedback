<?php

namespace Kajal\Feedback\Controller\Adminhtml\Action;

class InlineEdit extends \Magento\Backend\App\Action
{

    protected $jsonFactory;
    protected $modalFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Kajal\Feedback\Model\FeedbackFactory $modalFactory
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->modalFactory= $modalFactory;
    }

    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParams();
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach ($postItems['items'] as $key => $entityId) {
                    $entityId['product_id'] =$key;
                    $model = $this->modalFactory->create()->load($entityId['product_id']);
                    unset($entityId['id']);
                    try {
                        $model->setData(array_merge($model->getData(), $entityId));
                        $model->save();
                    } catch (\Exception $e) {
                        $messages[] = "[Error:]  {$e->getMessage()}";
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}
