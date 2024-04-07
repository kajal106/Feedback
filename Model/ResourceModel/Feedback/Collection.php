<?php

namespace Kajal\Feedback\Model\ResourceModel\Feedback;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Kajal\Feedback\Model\Feedback', 'Kajal\Feedback\Model\ResourceModel\Feedback');
    }
}

