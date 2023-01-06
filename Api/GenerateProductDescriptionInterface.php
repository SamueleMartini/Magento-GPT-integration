<?php

namespace SamueleMartini\GPT3\Api;

use Exception;
use Magento\Framework\Exception\NoSuchEntityException;

interface GenerateProductDescriptionInterface
{
    /**
     * @param string $productName
     * @param string $language
     * @return string
     * @throws Exception
     */
    public function getProductDescription(string $productName, string $language): string;

    /**
     * @param string $sku
     * @param int $storeId
     * @return string
     * @throws Exception|NoSuchEntityException
     */
    public function getProductDescriptionBySku(string $sku, int $storeId): string;

    /**
     * @param int $productId
     * @param int $storeId
     * @return string
     * @throws Exception|NoSuchEntityException
     */
    public function getProductDescriptionById(int $productId, int $storeId): string;
}
