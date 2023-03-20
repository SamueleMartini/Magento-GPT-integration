<?php

namespace SamueleMartini\GPT\Block\Adminhtml\Category\Edit\Button;

use Magento\Catalog\Block\Adminhtml\Category\AbstractCategory;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Catalog\Model\ResourceModel\Category\Tree;
use Magento\Framework\Registry;
use Magento\Catalog\Model\CategoryFactory;
use SamueleMartini\GPT\Helper\ModuleConfig;
use Magento\Backend\Model\UrlInterface;

class GenerateGPTDescription extends AbstractCategory implements ButtonProviderInterface
{
    const PRODUCT_DESCR_CONTROLLER_PATH = 'gpt/category/description';

    /**
     * @var ModuleConfig
     */
    protected ModuleConfig $moduleConfig;
    /**
     * @var UrlInterface
     */
    protected UrlInterface $url;

    /**
     * @param Context $context
     * @param Tree $categoryTree
     * @param Registry $registry
     * @param CategoryFactory $categoryFactory
     * @param ModuleConfig $moduleConfig
     * @param UrlInterface $url
     * @param array $data
     */
    public function __construct(
        Context $context,
        Tree $categoryTree,
        Registry $registry,
        CategoryFactory $categoryFactory,
        ModuleConfig $moduleConfig,
        UrlInterface $url,
        array $data = []
    ) {
        $this->moduleConfig = $moduleConfig;
        $this->url = $url;
        parent::__construct($context, $categoryTree, $registry, $categoryFactory, $data);
    }

    /**
     * @return array
     */
    public function getButtonData(): array
    {
        $category = $this->getCategory();

        if ($category->isReadonly() || !$this->hasStoreRootCategory() || !$this->moduleConfig->isModuleEnable()) {
            return [];
        }

        $params = [
            'id' => $category->getId(),
            'store' => $category->getStoreId()
        ];

        return [
            'label' => __('Generate description with OpenAI GPT'),
            'class' => 'action-secondary',
            'on_click' => 'window.location.href="' . $this->url->getUrl(self::PRODUCT_DESCR_CONTROLLER_PATH, $params) . '"',
            'sort_order' => 10
        ];
    }
}
