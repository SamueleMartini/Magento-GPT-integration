<?php

namespace SamueleMartini\GPT3\Model\GPT3;

use SamueleMartini\GPT3\Api\GPT3CompletionsInterface;
use SamueleMartini\GPT3\Helper\ModuleConfig;
use SamueleMartini\GPT3\Api\ConnectionInterface as GPT3Connection;
use Exception;

class GPT3Completions implements GPT3CompletionsInterface
{
    /**
     * @var ModuleConfig
     */
    protected ModuleConfig $moduleConfig;
    /**
     * @var GPT3Connection
     */
    protected GPT3Connection $connection;

    /**
     * @param ModuleConfig $moduleConfig
     * @param GPT3Connection $connection
     */
    public function __construct(
        ModuleConfig $moduleConfig,
        GPT3Connection $connection
    ) {
        $this->moduleConfig = $moduleConfig;
        $this->connection = $connection;
    }

    /**
     * @param string $prompt
     * @return string
     * @throws Exception
     */
    public function getGPT3Completions(string $prompt): string
    {
        $headers = ['Content-Type' => 'application/json'];
        $method = 'completions';
        $params = [
            'model' => $this->moduleConfig->getGPT3Model(),
            'prompt' => $prompt,
            'temperature' => 0,
            'max_tokens' => 2000
        ];

        $response = $this->connection->webserviceCall($method, $headers, 'POST', $params);

        return trim($response['choices'][0]['text']);
    }
}
