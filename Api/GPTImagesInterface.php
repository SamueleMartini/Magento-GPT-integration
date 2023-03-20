<?php

namespace SamueleMartini\GPT\Api;

use Exception;

interface GPTImagesInterface
{
    /**
     * @param string $imageDescription
     * @param int $qty
     * @param string $size
     * @return array
     * @throws Exception
     */
    public function getGPTImages(string $imageDescription, int $qty = 1, string $size = '1024x1024'): array;
}
