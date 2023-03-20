<?php

namespace SamueleMartini\GPT\Service;

use SamueleMartini\GPT\Api\GenerateProductDescriptionInterface;
use SamueleMartini\GPT\Api\GPTCompletionsInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use SamueleMartini\GPT\Api\GetLanguageByStoreIdInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Exception;

class GenerateProductDescription implements GenerateProductDescriptionInterface
{
    /**
     * @var GPTCompletionsInterface
     */
    protected GPTCompletionsInterface $GPTCompletions;
    /**
     * @var ProductRepositoryInterface
     */
    protected ProductRepositoryInterface $productRepository;
    /**
     * @var GetLanguageByStoreIdInterface
     */
    protected GetLanguageByStoreIdInterface $getLanguageByStoreId;

    /**
     * @param GPTCompletionsInterface $GPTCompletions
     * @param ProductRepositoryInterface $productRepository
     * @param GetLanguageByStoreIdInterface $getLanguageByStoreId
     */
    public function __construct(
        GPTCompletionsInterface $GPTCompletions,
        ProductRepositoryInterface $productRepository,
        GetLanguageByStoreIdInterface $getLanguageByStoreId
    ) {
        $this->GPTCompletions = $GPTCompletions;
        $this->productRepository = $productRepository;
        $this->getLanguageByStoreId = $getLanguageByStoreId;
    }

    /**
     * @param string $productName
     * @param string $language
     * @return string
     * @throws Exception
     */
    public function getProductDescription(string $productName, string $language): string
    {
        $prompt = 'Write a description for product ' . $productName . ' in ' . $language . ' language';
        return $this->GPTCompletions->getGPTCompletions($prompt);
    }

    /**
     * @param string $sku
     * @param int $storeId
     * @return string
     * @throws Exception|NoSuchEntityException
     */
    public function getProductDescriptionBySku(string $sku, int $storeId): string
    {
        return $this->getProductDescriptionByIdentifier($sku, $storeId);
    }

    /**
     * @param int $productId
     * @param int $storeId
     * @return string
     * @throws Exception|NoSuchEntityException
     */
    public function getProductDescriptionById(int $productId, int $storeId): string
    {
        return $this->getProductDescriptionByIdentifier($productId, $storeId, 'id');
    }

    /**
     * @param $identifier
     * @param int $storeId
     * @param string $type
     * @return string
     * @throws Exception|NoSuchEntityException
     */
    protected function getProductDescriptionByIdentifier($identifier, int $storeId, string $type = 'sku'): string
    {
        $product = $this->getProduct($identifier, $storeId, $type);
        $language = $this->getLanguage($storeId);

        return $this->getProductDescription($product->getName(), $language);
    }

    /**
     * @param $identifier
     * @param int $storeId
     * @param string $type
     * @return ProductInterface
     * @throws NoSuchEntityException
     */
    protected function getProduct($identifier, int $storeId, string $type = 'sku'): ProductInterface
    {
        if ($type === 'sku') {
            return $this->productRepository->get($identifier, false, $storeId);
        } else {
            return $this->productRepository->getById($identifier, false, $storeId);
        }
    }

    /**
     * @param int $storeId
     * @return string
     */
    protected function getLanguage(int $storeId)
    {
        $language = $this->getLanguageByStoreId->getLanguageByStoreId($storeId);

        if (empty($language)) {
            $language = 'English';
        }

        return $language;
    }
}
