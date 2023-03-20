<?php

namespace SamueleMartini\GPT\Api;

use Exception;

interface GPTModelsInterface
{
    /**
     * @return array
     * @throws Exception
     */
    public function getGPTModels(): array;
}
