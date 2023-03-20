<?php

namespace SamueleMartini\GPT\Model\GPT;

use SamueleMartini\GPT\Api\GPTModelsInterface;
use SamueleMartini\GPT\Helper\ModuleConfig;
use SamueleMartini\GPT\Api\ConnectionInterface as GPTConnection;
use Exception;

class GPTModels implements GPTModelsInterface
{
    /**
     * @var ModuleConfig
     */
    protected ModuleConfig $moduleConfig;
    /**
     * @var Connection
     */
    protected GPTConnection $connection;

    /**
     * @param ModuleConfig $moduleConfig
     * @param Connection $connection
     */
    public function __construct(
        ModuleConfig $moduleConfig,
        GPTConnection $connection
    ) {
        $this->moduleConfig = $moduleConfig;
        $this->connection = $connection;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getGPTModels(): array
    {
        $headers = ['OpenAI-Organization' => $this->moduleConfig->getOrgId()];
        $method = 'models';

        $models = $this->connection->webserviceCall($method, $headers);

        return $models['data'];
    }
}
