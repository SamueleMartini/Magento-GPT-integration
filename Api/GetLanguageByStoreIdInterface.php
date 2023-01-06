<?php

namespace SamueleMartini\GPT3\Api;

interface GetLanguageByStoreIdInterface
{
    /**
     * @param int $storeId
     * @return string
     */
    public function getLanguageByStoreId(int $storeId): string;
}
