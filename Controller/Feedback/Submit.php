<?php

namespace Kajal\Feedback\Controller\Feedback;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Kajal\Feedback\Model\FeedbackFactory;
use Kajal\Feedback\Helper\Data;
use Psr\Log\LoggerInterface;
use Magento\Framework\Controller\Result\RedirectFactory;


class Submit extends Action
{
    protected $resultPageFactory;
    public $feedbackFactory;
    public $resultRedirectFactory;
    public $data;
    public $logger;
    public $emailSender;

    public function __construct(Context $context,
        PageFactory $resultPageFactory,
        FeedbackFactory $feedbackFactory,
        RedirectFactory $resultRedirectFactory,
        LoggerInterface $logger,
        Data $data,
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->feedbackFactory = $feedbackFactory;
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->logger = $logger;
        $this->data = $data;
        parent::__construct($context);
    }

    public function execute()
    {
        $feedback = $this->getRequest()->getPostValue();
        if ($feedback) {
            try {
                $feedbackModel = $this->feedbackFactory->create();
                $feedbackModel->setData($feedback);
                $feedbackModel->save();
                $this->data->notifyEmail($feedback);
                $this->messageManager->addSuccessMessage(__('Feedback Send Successfully.'));
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage());
                $this->messageManager->addErrorMessage(__('An error occurred while saving form data.'));
            }
        }

        // Redirect back to the form page
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('feedback/feedback/index');
        return $resultRedirect;
    }

}
