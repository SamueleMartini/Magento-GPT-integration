<?php

namespace SamueleMartini\GPT\Model\Config\GPT;

use Magento\Framework\Data\OptionSourceInterface;
use SamueleMartini\GPT\Helper\ModuleConfig;
use SamueleMartini\GPT\Api\GPTModelsInterface;
use Exception;

class Models implements OptionSourceInterface
{
    /**
     * @var ModuleConfig
     */
    protected ModuleConfig $moduleConfig;
    /**
     * @var GPTModelsInterface
     */
    protected GPTModelsInterface $GPTModels;

    /**
     * @param ModuleConfig $moduleConfig
     * @param GPTModelsInterface $GPTModels
     */
    public function __construct(
        ModuleConfig $moduleConfig,
        GPTModelsInterface $GPTModels
    ) {
        $this->moduleConfig = $moduleConfig;
        $this->GPTModels = $GPTModels;
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

        foreach ($this->GPTModels->getGPTModels() as $model) {
            $return[] = [
                'value' => $model['id'],
                'label' => $model['root']
            ];
        }

        return $return;
    }
}
