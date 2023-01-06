<?php

namespace SamueleMartini\GPT3\Model\GPT3;

use SamueleMartini\GPT3\Api\GPT3ImagesInterface;
use SamueleMartini\GPT3\Helper\ModuleConfig;
use SamueleMartini\GPT3\Api\ConnectionInterface as GPT3Connection;
use Exception;

class GPT3Images implements GPT3ImagesInterface
{
    /**
     * @var ModuleConfig
     */
    protected ModuleConfig $moduleConfig;

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
     * @param string $imageDescription
     * @param int $qty
     * @param string $size
     * @return array
     * @throws Exception
     */
    public function getGPT3Images(string $imageDescription, int $qty = 1, string $size = '1024x1024'): array
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
