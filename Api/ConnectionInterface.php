<?php

namespace SamueleMartini\GPT\Api;

use OpenAI\Client as OpenAIClient;

interface ConnectionInterface
{
    /**
     * @return OpenAIClient
     */
    public function initClient(): OpenAIClient;
}
