<?php
namespace Kajal\Feedback\Model;

use Magento\Framework\Model\AbstractModel;

class Feedback extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('Kajal\Feedback\Model\ResourceModel\Feedback');
    }
}
