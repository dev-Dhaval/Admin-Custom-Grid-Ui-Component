<?php

namespace Dynamic\Customgrid\Ui\Component\DataProvider;

use Magento\Framework\Data\Collection;
use Magento\Framework\Api\Filter;

/**
 * Class RegularFilter
 */
class RegularFilter implements \Magento\Framework\View\Element\UiComponent\DataProvider\FilterApplierInterface
{
    /**
     * Apply regular filters like collection filters
     *
     * @param Collection $collection
     * @param Filter $filter
     * @return void
     */
    public function apply(Collection $collection, Filter $filter)
    {
        if($filter->getField() == 'skill'){
            $dataValue = [];
            foreach($filter->getValue() as $value){
                $dataValue[] = ['finset' => $value];
            }
            $collection->addFieldToFilter($filter->getField(), [$dataValue]);
        }else{
            $collection->addFieldToFilter($filter->getField(), [$filter->getConditionType() => $filter->getValue()]);
        }
        
    }
}
