<?php
 
namespace Dynamic\Customgrid\Model\ResourceModel;
 
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
 
class Customgrid extends AbstractDb
{
    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('company', 'id'); //hello is table of module
    }
}