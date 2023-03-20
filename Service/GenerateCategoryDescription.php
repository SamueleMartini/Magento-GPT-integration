<?php

namespace SamueleMartini\GPT\Service;

use SamueleMartini\GPT\Api\GenerateCategoryDescriptionInterface;
use SamueleMartini\GPT\Api\GPTCompletionsInterface;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use SamueleMartini\GPT\Api\GetLanguageByStoreIdInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Exception;

class GenerateCategoryDescription implements GenerateCategoryDescriptionInterface
{
    /**
     * @var GPTCompletionsInterface
     */
    protected GPTCompletionsInterface $GPTCompletions;
    /**
     * @var CategoryRepositoryInterface
     */
    protected CategoryRepositoryInterface $categoryRepository;
    /**
     * @var GetLanguageByStoreIdInterface
     */
    protected GetLanguageByStoreIdInterface $getLanguageByStoreId;

    /**
     * @param GPTCompletionsInterface $GPTCompletions
     * @param CategoryRepositoryInterface $categoryRepository
     * @param GetLanguageByStoreIdInterface $getLanguageByStoreId
     */
    public function __construct(
        GPTCompletionsInterface $GPTCompletions,
        CategoryRepositoryInterface $categoryRepository,
        GetLanguageByStoreIdInterface $getLanguageByStoreId
    ) {
        $this->GPTCompletions = $GPTCompletions;
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
        return $this->GPTCompletions->getGPTCompletions($prompt);
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
