<?php

namespace SamueleMartini\GPT\Api;

use Exception;
use Magento\Framework\Exception\NoSuchEntityException;

interface GenerateCategoryDescriptionInterface
{
    /**
     * @param string $categoryName
     * @param string $language
     * @return string
     * @throws Exception
     */
    public function getCategoryDescription(string $categoryName, string $language): string;

    /**
     * @param int $categoryId
     * @param int $storeId
     * @return string
     * @throws Exception|NoSuchEntityException
     */
    public function getCategoryDescriptionById(int $categoryId, int $storeId = 0): string;
}
