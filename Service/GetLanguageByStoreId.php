<?php

namespace SamueleMartini\GPT3\Service;

use SamueleMartini\GPT3\Api\GetLanguageByStoreIdInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Locale\ListsInterface;
use Magento\Store\Model\ScopeInterface;

class GetLanguageByStoreId implements GetLanguageByStoreIdInterface
{
    /**
     * @var ScopeConfigInterface
     */
    protected ScopeConfigInterface $scopeConfig;
    /**
     * @var ListsInterface
     */
    protected ListsInterface $lists;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param ListsInterface $lists
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ListsInterface $lists
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->lists = $lists;
    }

    /**
     * @param int $storeId
     * @return string
     */
    public function getLanguageByStoreId(int $storeId): string
    {
        $locale = $this->scopeConfig->getValue('general/locale/code', ScopeInterface::SCOPE_STORE, $storeId);
        $languages = $this->lists->getOptionLocales();

        foreach ($languages as $language) {
            if ($language['value'] === $locale) {
                $offset = (int)strpos($language['label'], '(');

                if ($offset > 0) {
                    return substr($language['label'], 0, $offset);
                }
                return $language['label'];
            }
        }

        return '';
    }
}
