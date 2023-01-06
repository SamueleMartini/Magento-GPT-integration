<?php

namespace SamueleMartini\GPT3\Service;

use SamueleMartini\GPT3\Api\GenerateCategoryDescriptionInterface;
use SamueleMartini\GPT3\Api\GPT3CompletionsInterface;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use SamueleMartini\GPT3\Api\GetLanguageByStoreIdInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Exception;

class GenerateCategoryDescription implements GenerateCategoryDescriptionInterface
{
    /**
     * @var GPT3CompletionsInterface
     */
    protected GPT3CompletionsInterface $GPT3Completions;
    /**
     * @var CategoryRepositoryInterface
     */
    protected CategoryRepositoryInterface $categoryRepository;
    /**
     * @var GetLanguageByStoreIdInterface
     */
    protected GetLanguageByStoreIdInterface $getLanguageByStoreId;

    /**
     * @param GPT3CompletionsInterface $GPT3Completions
     * @param CategoryRepositoryInterface $categoryRepository
     * @param GetLanguageByStoreIdInterface $getLanguageByStoreId
     */
    public function __construct(
        GPT3CompletionsInterface $GPT3Completions,
        CategoryRepositoryInterface $categoryRepository,
        GetLanguageByStoreIdInterface $getLanguageByStoreId
    ) {
        $this->GPT3Completions = $GPT3Completions;
        $this->categoryRepository = $categoryRepository;
        $this->getLanguageByStoreId = $getLanguageByStoreId;
    }

    /**
     * @param string $categoryName
     * @param string $language
     * @return string
     * @throws Exception
     */
    public function getCategoryDescription(string $categoryName, string $language): string
    {
        $prompt = 'Write a description for ' . $categoryName . ' in ' . $language . ' language';
        return $this->GPT3Completions->getGPT3Completions($prompt);
    }

    /**
     * @param int $categoryId
     * @param int $storeId
     * @return string
     * @throws Exception|NoSuchEntityException
     */
    public function getCategoryDescriptionById(int $categoryId, int $storeId = 0): string
    {
        $category = $this->categoryRepository->get($categoryId, $storeId);
        $categoryName = $category->getName();
        $language = $this->getLanguageByStoreId->getLanguageByStoreId($storeId);

        if (empty($language)) {
            $language = 'English';
        }

        return $this->getCategoryDescription($categoryName, $language);
    }
}
