<?php
namespace Kajal\Feedback\Ui\DataProvider;

use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;

class FeedbackDataProvider extends SearchResult
{
    protected function _initSelect()
    {
        parent::_initSelect();
        return $this;
    }
}
