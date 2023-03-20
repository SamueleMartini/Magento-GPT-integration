<?php

namespace SamueleMartini\GPT\Controller\Adminhtml\Product;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

class Description extends Action implements HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'Magento_Catalog::products';

    /**
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        $request = $this->getRequest();
        $productId = $request->getParam('id');
        $storeId = $request->getParam('store');

        if (!$productId && $productId !== 0 && $productId !== '0') {
            $this->messageManager->addErrorMessage(__("Missing parameter product ID"));
            return $this->returnRedirect($productId, $storeId);
        }

        if (!$storeId && $storeId !== 0 && $storeId !== '0') {
            $this->messageManager->addErrorMessage(__("Missing parameter store ID"));
            return $this->returnRedirect($productId, $storeId);
        }

        return $this->returnRedirect($productId, $storeId, true);
    }

    /**
     * @param $productId
     * @param $storeId
     * @param bool $generateDescription
     * @return Redirect
     */
    protected function returnRedirect($productId, $storeId, bool $generateDescription = false): Redirect
    {
        $params = ['id' => $productId, 'store' => $storeId];

        if ($generateDescription) {
            $params['generateDescription'] = 'true';
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('catalog/product/edit', $params);

        return $resultRedirect;
    }
}
