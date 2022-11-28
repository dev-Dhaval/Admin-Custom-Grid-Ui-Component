<?php
 
namespace Dynamic\Customgrid\Model\ResourceModel\Customgrid;
 
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
 
class Collection extends AbstractCollection
{
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(
            'Dynamic\Customgrid\Model\Customgrid',
            'Dynamic\Customgrid\Model\ResourceModel\Customgrid'
        );
    }
}