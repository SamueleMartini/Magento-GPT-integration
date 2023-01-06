<?php

namespace SamueleMartini\GPT3\Api;

use Exception;

interface GPT3CompletionsInterface
{
    /**
     * @param string $prompt
     * @return string
     * @throws Exception
     */
    public function getGPT3Completions(string $prompt): string;
}
