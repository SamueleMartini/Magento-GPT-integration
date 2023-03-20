<?php

namespace SamueleMartini\GPT\Api;

interface GetLanguageByStoreIdInterface
{
    /**
     * @param int $storeId
     * @return string
     */
    public function getLanguageByStoreId(int $storeId): string;
}
