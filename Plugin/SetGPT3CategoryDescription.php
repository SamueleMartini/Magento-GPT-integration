<?php

namespace SamueleMartini\GPT3\Plugin;

use Magento\Catalog\Controller\Adminhtml\Category\Edit as Subject;
use Magento\Framework\Exception\NoSuchEntityException;
use SamueleMartini\GPT3\Helper\ModuleConfig;
use Magento\Framework\Message\ManagerInterface;
use SamueleMartini\GPT3\Api\GenerateCategoryDescriptionInterface;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\Session;
use Exception;

class SetGPT3CategoryDescription
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
     * @var GenerateCategoryDescriptionInterface
     */
    protected GenerateCategoryDescriptionInterface $generateCategoryDescription;
    /**
     * @var Session
     */
    protected Session $session;

    /**
     * @param ModuleConfig $moduleConfig
     * @param ManagerInterface $messageManager
     * @param GenerateCategoryDescriptionInterface $generateCategoryDescription
     * @param Context $context
     */
    public function __construct(
        ModuleConfig $moduleConfig,
        ManagerInterface $messageManager,
        GenerateCategoryDescriptionInterface $generateCategoryDescription,
        Context $context
    ) {
        $this->moduleConfig = $moduleConfig;
        $this->messageManager = $messageManager;
        $this->generateCategoryDescription = $generateCategoryDescription;
        $this->session = $context->getSession();
    }

    /**
     * @param Subject $subject
     * @return array
     */
    public function beforeExecute(Subject $subject): array
    {
        $request = $subject->getRequest();

        if ($request->getParam('generateDescription') === 'true') {
            if (!$this->moduleConfig->isModuleEnable()) {
                $this->messageManager->addErrorMessage(__('Module is disabled! Go to "Stores -> Settings -> Configuration" to enable it'));
                return [];
            }

            $categoryId = $request->getParam('id');
            $storeId = $request->getParam('store') ? $request->getParam('store') : '0';

            try {
                $description = $this->generateCategoryDescription->getCategoryDescriptionById($categoryId, $storeId);

                $this->session->setCategoryData(['description' => $description]);

                $this->messageManager->addSuccessMessage(__('Description generated!'));
                $this->messageManager->addNoticeMessage(__('The generated description is just a preview. You must review it and save the category to consolidate it.'));
            } catch (NoSuchEntityException|Exception $e) {
            }
        }
        return [];
    }
}
