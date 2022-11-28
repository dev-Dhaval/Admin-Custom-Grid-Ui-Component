<?php
namespace Dynamic\Customgrid\Ui\Component\Listing\Customgrid\Column;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Dynamic\Customgrid\Model\Customgrid;
use Dynamic\Customgrid\Ui\Component\Listing\Customgrid\SkillOptions as optionArray;

class SkillList extends \Magento\Ui\Component\Listing\Columns\Column
{
 
	protected $_productloader;
	protected $_categoryloader;
    protected $customGrid;

    protected $optionArray;

	public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        Customgrid $customGrid,
        optionArray $optionArray,
    	array $components = [],
    	array $data = []
	) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->customGrid = $customGrid;
        $this->_optionArray = $optionArray;
	}
	public function prepareDataSource(array $dataSource)
	{
        $fieldName = $this->getData('name');
        $dataCollection = $this->_optionArray->toOptionArray();
    	    foreach ($dataSource['data']['items'] as &$item) {
                $p_id = $item['id'];
     	        $gridData =$this->customGrid->load($p_id);
                $skills = $gridData->getSkill();
                $skills = explode(',',$skills);
                $skillData = array();
                if(count($skills) ){
                    foreach($skills as $skill){
                        foreach($dataCollection as $child){
                            if($child['value'] == $skill){
                                $skillData[] = $child['label'];
                            }
                        }
                    }
                }
                $skills = implode(',',$skillData);
                $item[$fieldName] = $skills;
        	}
        return $dataSource;
	}
}