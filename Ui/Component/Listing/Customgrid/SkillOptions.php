<?php
namespace Dynamic\Customgrid\Ui\Component\Listing\Customgrid;

class SkillOptions implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray(){
        return [
            ["value" => 0, "label" => "Magento"],
            ["value" => 1, "label" => "Shopify"],
            ["value" => 2, "label" => "Wordpress"],
            
        ];
        
    }
}