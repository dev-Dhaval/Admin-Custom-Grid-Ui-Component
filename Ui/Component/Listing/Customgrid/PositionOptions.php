<?php
namespace Dynamic\Customgrid\Ui\Component\Listing\Customgrid;

class PositionOptions implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray(){
        return [
            ["value" => 0, "label" => "Senior"],
            ["value" => 1, "label" => "Junior"],
            ["value" => 2, "label" => "Trainee"],
            
        ];
        
    }
}