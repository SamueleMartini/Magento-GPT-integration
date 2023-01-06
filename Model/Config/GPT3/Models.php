<?php

namespace SamueleMartini\GPT3\Model\Config\GPT3;

use Magento\Framework\Data\OptionSourceInterface;
use SamueleMartini\GPT3\Helper\ModuleConfig;
use SamueleMartini\GPT3\Api\GPT3ModelsInterface;
use Exception;

class Models implements OptionSourceInterface
{
    /**
     * @var ModuleConfig
     */
    protected ModuleConfig $moduleConfig;
    /**
     * @var GPT3ModelsInterface
     */
    protected GPT3ModelsInterface $GPT3Models;

    /**
     * @param ModuleConfig $moduleConfig
     * @param GPT3ModelsInterface $GPT3Models
     */
    public function __construct(
        ModuleConfig $moduleConfig,
        GPT3ModelsInterface $GPT3Models
    ) {
        $this->moduleConfig = $moduleConfig;
        $this->GPT3Models = $GPT3Models;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function toOptionArray(): array
    {
        if (empty($this->moduleConfig->getApiKey()) || empty($this->moduleConfig->getOrgId())) {
            return [];
        }

        $return = [];

        foreach ($this->GPT3Models->getGPT3Models() as $model) {
            $return[] = [
                'value' => $model['id'],
                'label' => $model['root']
            ];
        }

        return $return;
    }
}
