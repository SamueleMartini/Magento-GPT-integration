<?php

namespace SamueleMartini\GPT\Api;

use Exception;

interface ConnectionInterface
{
    const ENDPOINT = 'https://api.openai.com/v1/';

    /**
     * @param string $method
     * @param array $headers
     * @param string $requestType
     * @param array $params
     * @return array
     * @throws Exception
     */
    public function webserviceCall(string $method, array $headers = [], string $requestType = 'GET', array $params = []): array;
}
