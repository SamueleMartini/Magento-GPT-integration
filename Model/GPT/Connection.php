<?php

namespace SamueleMartini\GPT\Model\GPT;

use SamueleMartini\GPT\Api\ConnectionInterface;
use OpenAI;
use SamueleMartini\GPT\Helper\ModuleConfig;
use OpenAI\Client as OpenAIClient;

class Connection implements ConnectionInterface
{
    /**
     * @var OpenAI
     */
    protected OpenAI $openAI;
    /**
     * @var ModuleConfig
     */
    protected ModuleConfig $moduleConfig;

    /**
     * @param OpenAI $openAI
     * @param ModuleConfig $moduleConfig
     */
    public function __construct(
        OpenAI $openAI,
        ModuleConfig $moduleConfig
    ) {
        $this->openAI = $openAI;
        $this->moduleConfig = $moduleConfig;
    }

    /**
     * @return OpenAIClient
     */
    public function initClient(): OpenAIClient
    {
        $apiKey = $this->moduleConfig->getApiKey();
        $organization = $this->moduleConfig->getOrgId();

        return $this->openAI::client($apiKey, $organization);
    }
}
