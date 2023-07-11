<?php

namespace SamueleMartini\GPT\Model\GPT;

use SamueleMartini\GPT\Api\GPTImagesInterface;
use SamueleMartini\GPT\Helper\ModuleConfig;
use SamueleMartini\GPT\Api\ConnectionInterface as GPTConnection;
use OpenAI\Client as OpenAIClient;
use Exception;

class GPTImages implements GPTImagesInterface
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
     * @param string $imageDescription
     * @param int $qty
     * @param string $size
     * @return array
     * @throws Exception
     */
    public function getGPTImages(string $imageDescription, int $qty = 1, string $size = '1024x1024'): array
    {
        if (empty($this->openAIClient)) {
            $this->openAIClient = $this->connection->initClient();
        }

        $response = $this->openAIClient->images()->create([
            'prompt' => $imageDescription,
            'n' => $qty,
            'size' => $size,
            'response_format' => 'url'
        ])->toArray();

        return $response['data'];
    }
}
