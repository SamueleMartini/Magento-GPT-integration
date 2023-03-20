<?php

namespace SamueleMartini\GPT\Api;

use Exception;

interface GPTCompletionsInterface
{
    /**
     * @param string $prompt
     * @return string
     * @throws Exception
     */
    public function getGPTCompletions(string $prompt): string;
}
