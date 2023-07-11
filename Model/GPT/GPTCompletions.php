<?php

namespace SamueleMartini\GPT\Model\GPT;

use SamueleMartini\GPT\Api\GPTCompletionsInterface;
use SamueleMartini\GPT\Helper\ModuleConfig;
use SamueleMartini\GPT\Api\ConnectionInterface as GPTConnection;
use OpenAI\Client as OpenAIClient;
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
     * @var OpenAIClient|null
     */
    protected ?OpenAIClient $openAIClient = null;

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
        if (empty($this->openAIClient)) {
            $this->openAIClient = $this->connection->initClient();
        }

        try {
            $result = $this->openAIClient->completions()->create([
                'model' => $this->moduleConfig->getGPTModel(),
                'prompt' => $prompt
            ]);

            return trim($result['choices'][0]['text']);
        } catch (Exception $e) {
            $result = $this->openAIClient->chat()->create([
                'model' => $this->moduleConfig->getGPTModel(),
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
            ])->toArray();

            return trim($result['choices'][0]['message']['content']);
        }
    }
}
