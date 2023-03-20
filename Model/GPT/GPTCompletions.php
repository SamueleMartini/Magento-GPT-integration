<?php

namespace SamueleMartini\GPT\Model\GPT;

use SamueleMartini\GPT\Api\GPTCompletionsInterface;
use SamueleMartini\GPT\Helper\ModuleConfig;
use SamueleMartini\GPT\Api\ConnectionInterface as GPTConnection;
use Exception;

class GPTCompletions implements GPTCompletionsInterface
{
    /**
     * @var ModuleConfig
     */
    protected ModuleConfig $moduleConfig;
    /**
     * @var GPTConnection
     */
    protected GPTConnection $connection;

    /**
     * @param ModuleConfig $moduleConfig
     * @param GPTConnection $connection
     */
    public function __construct(
        ModuleConfig $moduleConfig,
        GPTConnection $connection
    ) {
        $this->moduleConfig = $moduleConfig;
        $this->connection = $connection;
    }

    /**
     * @param string $prompt
     * @return string
     * @throws Exception
     */
    public function getGPTCompletions(string $prompt): string
    {
        $headers = ['Content-Type' => 'application/json'];
        $method = 'completions';
        $params = [
            'model' => $this->moduleConfig->getGPTModel(),
            'prompt' => $prompt,
            'temperature' => 0,
            'max_tokens' => 2000
        ];

        $response = $this->connection->webserviceCall($method, $headers, 'POST', $params);

        return trim($response['choices'][0]['text']);
    }
}
