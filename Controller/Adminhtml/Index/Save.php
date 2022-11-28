<?php

namespace Dynamic\Customgrid\Controller\Adminhtml\Index;
use Magento\Backend\App\Action;
use Magento\Backend\Model\Session;
use Dynamic\Customgrid\Model\Customgrid;

use Magento\Framework\Filesystem;
use Magento\Framework\Validation\ValidationException;
use Magento\MediaStorage\Model\File\UploaderFactory;

class Save extends \Magento\Backend\App\Action
{
    /**
     *
     * @var UploaderFactory
     */
    protected $uploaderFactory;

    protected $customGrid;
    /**
     * @var Session
     */
    protected $adminsession;
    /**
     * @param Action\Context $context
     * @param customGrid           $customGrid
     * @param Session        $adminsession
     */
    public function __construct(
        Action\Context $context,
        Customgrid $customGrid,
        Session $adminsession,
        UploaderFactory $uploaderFactory,
        Filesystem $filesystem
    ) {
        parent::__construct($context);
        $this->customGrid = $customGrid;
        $this->adminsession = $adminsession;
        $this->uploaderFactory = $uploaderFactory;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
    }
    /**
     * Save data record action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {

        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $id = $this->getRequest()->getParam('id');
            if ($id) {
                $this->customGrid->load($id);
            }
            if(is_array($data['skill'])){
                $data['skill'] = implode(',',$data['skill']);
            }
            
            try {
                    $fileUploader = null;
                        $imageId = 'profile';
                        $imageFlag = '';
                        if (isset($data['profile']) && count($data['profile'])) {
                            $imageId = $data['profile'][0];
                            if(isset($imageId['tmp_name'])){
                                if (!file_exists($imageId['tmp_name'])) {
                                    $imageId['tmp_name'] = $imageId['path'] . '/' . $imageId['file'];
                                    $fileUploader = $this->uploaderFactory->create(['fileId' => $imageId]);
                                    $fileUploader->setAllowedExtensions(['jpg', 'jpeg', 'png']);
                                    $fileUploader->setAllowRenameFiles(true);
                                    $fileUploader->setAllowCreateFolders(true);
                                    $fileUploader->validateFile();
                                    //upload image
                                    $info = $fileUploader->save($this->mediaDirectory->getAbsolutePath('imageUploader/images'));
                                    /** @var \VENDOR\ImageUploader\Model\Image */
                                    $data['profile'] = $this->mediaDirectory->getRelativePath('imageUploader/images') . '/' . $info['file'];
                                }
                            }else{
                                $data['profile'] = $data['profile'][0]['name'];
                            }
                            
                        }else{
                            $data['profile'] = '';
                        }
                $this->customGrid->setData($data);       
                $this->customGrid->save();
                $this->messageManager->addSuccess(__('The data has been saved.'));
                $this->adminsession->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    if ($this->getRequest()->getParam('back') == 'add') {
                        return $resultRedirect->setPath('*/*/index');
                    } else {
                        return $resultRedirect->setPath('*/*/addrow', ['id' => $this->customGrid->getId(), '_current' => true]);
                    }
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the data.'));
            }
            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/addrow', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}