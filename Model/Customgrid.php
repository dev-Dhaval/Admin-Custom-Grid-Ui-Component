<?php
 
namespace Dynamic\Customgrid\Model;
 
use Magento\Framework\Model\AbstractModel;
 
class Customgrid extends AbstractModel
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('Dynamic\Customgrid\Model\ResourceModel\Customgrid');
    }
}