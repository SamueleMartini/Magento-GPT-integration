<?php

namespace SamueleMartini\GPT3\Plugin;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Controller\Adminhtml\Product\Builder as Subject;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use SamueleMartini\GPT3\Helper\ModuleConfig;
use Magento\Framework\Message\ManagerInterface;
use SamueleMartini\GPT3\Api\GenerateProductDescriptionInterface;
use Exception;

class SetGPT3ProductDescription
{
    /**
     * @var ModuleConfig
     */
    protected ModuleConfig $moduleConfig;
    /**
     * @var ManagerInterface
     */
    protected ManagerInterface $messageManager;
    /**
     * @var GenerateProductDescriptionInterface
     */
    protected GenerateProductDescriptionInterface $generateProductDescription;

    /**
     * @param ModuleConfig $moduleConfig
     * @param ManagerInterface $messageManager
     * @param GenerateProductDescriptionInterface $generateProductDescription
     */
    public function __construct(
        ModuleConfig $moduleConfig,
        ManagerInterface $messageManager,
        GenerateProductDescriptionInterface $generateProductDescription
    ) {
        $this->moduleConfig = $moduleConfig;
        $this->messageManager = $messageManager;
        $this->generateProductDescription = $generateProductDescription;
    }

    /**
     * @param Subject $subject
     * @param ProductInterface $product
     * @param RequestInterface $request
     * @return ProductInterface
     */
    public function afterBuild(Subject $subject, ProductInterface $product, RequestInterface $request): ProductInterface
    {
        if ($request->getParam('generateDescription') === 'true') {
            if (!$this->moduleConfig->isModuleEnable()) {
                $this->messageManager->addErrorMessage(__('Module is disabled! Go to "Stores -> Settings -> Configuration" to enable it'));
                return $product;
            }

            $productId = $request->getParam('id');
            $storeId = $request->getParam('store') ? $request->getParam('store') : '0';

            try {
                $description = $this->generateProductDescription->getProductDescriptionById($productId, $storeId);
                $product->setDescription($description);
                $this->messageManager->addSuccessMessage(__('Description generated!'));
                $this->messageManager->addNoticeMessage(__('The generated description is just a preview. You must review it and save the product to consolidate it.'));
            } catch (NoSuchEntityException|Exception $e) {
                $this->messageManager->addErrorMessage(__($e->getMessage()));
            }
        }

        return $product;
    }
}
