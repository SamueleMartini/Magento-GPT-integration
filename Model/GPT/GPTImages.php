<?php

namespace SamueleMartini\GPT\Model\GPT;

use SamueleMartini\GPT\Api\GPTImagesInterface;
use SamueleMartini\GPT\Helper\ModuleConfig;
use SamueleMartini\GPT\Api\ConnectionInterface as GPTConnection;
use Exception;

class GPTImages implements GPTImagesInterface
{
    /**
     * @var ModuleConfig
     */
    protected ModuleConfig $moduleConfig;

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
        $headers = ['Content-Type' => 'application/json'];
        $method = 'images/generations';
        $params = [
            'prompt' => $imageDescription,
            'n' => $qty,
            'size' => $size
        ];

        $response = $this->connection->webserviceCall($method, $headers, 'POST', $params);

        return $response['data'];
    }
}
