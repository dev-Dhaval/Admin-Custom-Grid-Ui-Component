<?php

namespace Dynamic\Customgrid\Controller\Adminhtml\Index;
use Magento\Backend\App\Action;
use Dynamic\Customgrid\Model\ResourceModel\Customgrid\CollectionFactory;
use Dynamic\Customgrid\Model\CustomgridFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;


class Delete extends \Magento\Backend\App\Action
{
    
    public $collectionFactory;

    public $filter;

    protected $CustomgridFactory;

    public function __construct(
        Action\Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory, 
        CustomgridFactory $CustomgridFactory
    ) {
        parent::__construct($context);
        $this->filter = $filter;
        $this->CustomgridFactory = $CustomgridFactory;
        $this->collectionFactory = $collectionFactory;
    }
    /**
     * delete data record action
     */
    public function execute()
    {
         try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            $count = 0;
            foreach ($collection as $model) {
                $model = $this->CustomgridFactory->create()->load($model->getId());
                $model->delete();
                $count++;
            }
            $this->messageManager->addSuccess(__('A total of %1 blog(s) have been deleted.', $count));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/');
    }
}