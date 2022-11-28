<?php

namespace Dynamic\Customgrid\Model;
use Dynamic\Customgrid\Model\ResourceModel\Customgrid\CollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var array
     */
    protected $loadedData;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $gridCollectionFactory,
        StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $gridCollectionFactory->create();
        $this->storeManager = $storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $company) {
            $this->loadedData[$company->getId()] = $company->getData();
            if ($company->getProfile()) {
                $m[0]['name'] = $company->getProfile();
                $m[0]['url'] = $this->getMediaUrl().$company->getProfile();
                $this->loadedData[$company->getId()]['profile'] = $m;
            }
        }
        return $this->loadedData;
    }
    public function getMediaUrl()
    {
        $mediaUrl = $this->storeManager->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        return $mediaUrl;
    }
}