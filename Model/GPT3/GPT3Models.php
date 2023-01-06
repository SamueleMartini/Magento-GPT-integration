<?php

namespace SamueleMartini\GPT3\Model\GPT3;

use SamueleMartini\GPT3\Api\GPT3ModelsInterface;
use SamueleMartini\GPT3\Helper\ModuleConfig;
use SamueleMartini\GPT3\Api\ConnectionInterface as GPT3Connection;
use Exception;

class GPT3Models implements GPT3ModelsInterface
{
    /**
     * @var ModuleConfig
     */
    protected ModuleConfig $moduleConfig;
    /**
     * @var Connection
     */
    protected GPT3Connection $connection;

    /**
     * @param ModuleConfig $moduleConfig
     * @param Connection $connection
     */
    public function __construct(
        ModuleConfig $moduleConfig,
        GPT3Connection $connection
    ) {
        $this->moduleConfig = $moduleConfig;
        $this->connection = $connection;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getGPT3Models(): array
    {
        $headers = ['OpenAI-Organization' => $this->moduleConfig->getOrgId()];
        $method = 'models';

        $models = $this->connection->webserviceCall($method, $headers);

        return $models['data'];
    }
}
