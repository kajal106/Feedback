<?php

namespace Kajal\Feedback\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Psr\Log\LoggerInterface;


/**
 * Class Data
 * @package Ced\EbayMultiAccount\Helper
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper{

    protected $transportBuilder;
    protected $inlineTranslation;
    public $logger;

    public function __construct(
        Context $context,
        TransportBuilder $transportBuilder,
        StateInterface $state,
        LoggerInterface $logger
    )
    {
       parent::__construct($context);
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $state;
        $this->logger = $logger;
    }

    public function notifyEmail($feedback){
        try{
            $this->inlineTranslation->suspend();
            $to = $this->getReceiverEmail();
             if($to){
                $templateVars = [
                    'name' => $feedback['full_name'],
                    'message' => 'This is a custom email message send by the customer.',
                ];

                $senderInfo = [
                    'email' => $feedback['email'],
                    'name' => $feedback['full_name'],
                ];

                $receiverInfo = [
                    'name' => 'Pinblooms',
                    'email' => $to,
                ];
                $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
                $templateOptions = ['area' => \Magento\Framework\App\Area::AREA_FRONTEND, // Or \Magento\Framework\App\Area::AREA_ADMINHTML
                    'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID];
                //echo "<pre>"; print_r($templateVars); die('_TEXT_90');
                try{
                    $transport = $this->transportBuilder
                        ->setTemplateIdentifier('custom_email_template') // Identifier of email template
                        ->setTemplateOptions($templateOptions)
                        ->setTemplateVars($templateVars)
                        ->setFrom($senderInfo)
                        ->addTo($to)
                        ->getTransport();
                        $transport->sendMessage();
                        $this->inlineTranslation->resume();
                }catch(\Exception $e){
                    $this->logger->error($e->getMessage());
                }
            }
        }catch(\Exception $e){
            $this->logger->error($e->getMessage());
        }
    }
    public function getReceiverEmail()
    {
        return $this->scopeConfig->getvalue(
            'feedback_configuration/feedback_email/feedback_notify_email'
        );
    }
}
