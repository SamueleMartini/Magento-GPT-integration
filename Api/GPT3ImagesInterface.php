<?php

namespace SamueleMartini\GPT3\Api;

use Exception;

interface GPT3ImagesInterface
{
    /**
     * @param string $imageDescription
     * @param int $qty
     * @param string $size
     * @return array
     * @throws Exception
     */
    public function getGPT3Images(string $imageDescription, int $qty = 1, string $size = '1024x1024'): array;
}
