<?php

namespace SamueleMartini\GPT3\Api;

use Exception;

interface GPT3ModelsInterface
{
    /**
     * @return array
     * @throws Exception
     */
    public function getGPT3Models(): array;
}
