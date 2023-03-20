<?php

namespace SamueleMartini\GPT\Controller\Adminhtml\Category;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

class Description extends Action implements HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'Magento_Catalog::categories';

    /**
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        $request = $this->getRequest();
        $categoryId = $request->getParam('id');
        $storeId = $request->getParam('store');

        if (!$categoryId && $categoryId !== 0 && $categoryId !== '0') {
            $this->messageManager->addErrorMessage(__("Missing parameter category ID"));
            return $this->returnRedirect($categoryId, $storeId);
        }

        if (!$storeId && $storeId !== 0 && $storeId !== '0') {
            $this->messageManager->addErrorMessage(__("Missing parameter store ID"));
            return $this->returnRedirect($categoryId, $storeId);
        }

        return $this->returnRedirect($categoryId, $storeId, true);
    }

    protected function returnRedirect($categoryId, $storeId, bool $generateDescription = false): Redirect
    {
        $params = ['id' => $categoryId, 'store' => $storeId];

        if ($generateDescription) {
            $params['generateDescription'] = 'true';
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('catalog/category/edit', $params);

        return $resultRedirect;
    }
}
