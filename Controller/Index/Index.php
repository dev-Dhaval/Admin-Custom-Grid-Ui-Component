<?php

namespace Dynamic\Customgrid\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
	/**
	 * @param Context $context
	 * @param PageFactory $resultPageFactory
	 */
	public function __construct(
		Context $context,
		PageFactory $resultPageFactory,
	) {
		$this->_resultPageFactory = $resultPageFactory;
		parent::__construct($context);
	}

	public function execute()
	{
		$resultPage = $this->_resultPageFactory->create();
		$pageLabel = "";
		$resultPage->getConfig()->getTitle()->set(__());
		$layout = $resultPage->getLayout();
		return $resultPage;
	}
}