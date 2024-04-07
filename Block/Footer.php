<?php
namespace Kajal\Feedback\Block;

use Magento\Framework\UrlInterface;

class Footer extends \Magento\Framework\View\Element\Html\Link
{
    protected $_template = 'Kajal_Feedback::link.phtml';

    protected $urlBuilder;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        UrlInterface $urlBuilder,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->urlBuilder = $urlBuilder;
    }
    public function getHref()
    {
        return $this->urlBuilder->getUrl('feedback/feedback/index');
    }
    public function getLabel()
    {
        return __('Feedback');
    }
}
?>
