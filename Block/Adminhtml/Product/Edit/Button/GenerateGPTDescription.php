<?php

namespace SamueleMartini\GPT\Block\Adminhtml\Product\Edit\Button;

use Magento\Catalog\Block\Adminhtml\Product\Edit\Button\Generic;
use Magento\Framework\View\Element\UiComponent\Context;
use Magento\Framework\Registry;
use SamueleMartini\GPT\Helper\ModuleConfig;
use Magento\Backend\Model\UrlInterface;

class GenerateGPTDescription extends Generic
{
    const PRODUCT_DESCR_CONTROLLER_PATH = 'gpt/product/description';

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
     * @param Registry $registry
     * @param ModuleConfig $moduleConfig
     * @param UrlInterface $url
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ModuleConfig $moduleConfig,
        UrlInterface $url
    ) {
        $this->moduleConfig = $moduleConfig;
        $this->url = $url;
        parent::__construct($context, $registry);
    }

    /**
     * @return array
     */
    public function getButtonData(): array
    {
        $product = $this->getProduct();

        if ($product->isReadonly() || !$this->moduleConfig->isModuleEnable()) {
            return [];
        }

        $params = [
            'id' => $product->getId(),
            'store' => $product->getStoreId()
        ];

        return [
            'label' => __('Generate description with OpenAI GPT'),
            'class' => 'action-secondary',
            'on_click' => 'window.location.href="' . $this->url->getUrl(self::PRODUCT_DESCR_CONTROLLER_PATH, $params) . '"',
            'sort_order' => 10
        ];
    }
}
