<?php

namespace SamueleMartini\GPT3\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class ModuleConfig extends AbstractHelper
{
    const GPT3 = 'gpt_3/';
    const GENERAL = self::GPT3 . 'general/';
    const MODULE_ENABLE = self::GENERAL . 'enable';
    const API_KEY = self::GENERAL . 'api_key';
    const ORG_ID = self::GENERAL . 'org_id';
    const MODEL = self::GENERAL . 'model';

    /**
     * @return bool
     */
    public function isModuleEnable(): bool
    {
        return $this->scopeConfig->isSetFlag(self::MODULE_ENABLE, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return (string)$this->scopeConfig->getValue(self::API_KEY, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string
     */
    public function getOrgId(): string
    {
        return (string)$this->scopeConfig->getValue(self::ORG_ID, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string
     */
    public function getGPT3Model(): string
    {
        return (string)$this->scopeConfig->getValue(self::MODEL, ScopeInterface::SCOPE_STORE);
    }
}
