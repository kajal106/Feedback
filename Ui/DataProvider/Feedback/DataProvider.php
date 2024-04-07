<?php

namespace Kajal\Feedback\Ui\DataProvider\Feedback;

use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * Class DataProvider
 * @package Kajal\Feedback\Ui\DataProvider\JobScheduler
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var $collection
     */
    public $collection;

    /**
     * @var $addFieldStrategies
     */
    public $addFieldStrategies;

    /**
     * @var $addFilterStrategies
     */
    public $addFilterStrategies;

    /**
     * @var $size
     */
    public $size;

    /**
     * DataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param \Kajal\Feedback\Model\FeedbackFactory $collectionFactory
     * @param array $addFieldStrategies
     * @param array $addFilterStrategies
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Kajal\Feedback\Model\ResourceModel\Feedback\CollectionFactory $collectionFactory,
        $addFieldStrategies = [],
        $addFilterStrategies = [],
        $meta = [],
        $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection= $collectionFactory->create();
        $this->size = sizeof($this->collection->getData());
    }

    /**
     * @return array
     */
    public function getData()
    {
        if (!$this->getCollection()->isLoaded()) {
            $this->getCollection()->load();
        }

        $items = $this->getCollection()->getData();
        return [
            'totalRecords' => $this->size,
            'items' => array_values($items),

        ];
    }

    public function save()
    {
        $items = $this->getRequest()->getParam('items', []);
        foreach ($items as $itemData) {
            $itemId = $itemData[$this->getPrimaryFieldName()];
            if ($itemId) {
                $item = $this->getCollection()->getItemById($itemId);
                if ($item) {
                    // Update contact_no if it's present in itemData
                    if (isset($itemData['contact_no'])) {
                        $item->setContactNo($itemData['contact_no']);
                    }
                    // You can similarly handle other fields here

                    // Save the item
                    $item->save();
                }
            }
        }
        return $this;
    }

}
