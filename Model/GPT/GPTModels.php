<?php

namespace SamueleMartini\GPT\Model\GPT;

use SamueleMartini\GPT\Api\GPTModelsInterface;
use SamueleMartini\GPT\Helper\ModuleConfig;
use SamueleMartini\GPT\Api\ConnectionInterface as GPTConnection;
use OpenAI\Client as OpenAIClient;
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
     * @var OpenAIClient|null
     */
    protected ?OpenAIClient $openAIClient = null;

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
        if (empty($this->openAIClient)) {
            $this->openAIClient = $this->connection->initClient();
        }

        $models = $this->openAIclient->models()->list()->toArray();

        return $models['data'];
    }
}
