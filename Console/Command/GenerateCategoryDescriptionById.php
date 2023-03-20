<?php

namespace SamueleMartini\GPT\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use SamueleMartini\GPT\Helper\ModuleConfig;
use SamueleMartini\GPT\Api\GenerateCategoryDescriptionInterface;
use Symfony\Component\Console\Exception\RuntimeException;
use Exception;

class GenerateCategoryDescriptionById extends Command
{
    /**
     * @var ModuleConfig
     */
    protected ModuleConfig $moduleConfig;
    /**
     * @var GenerateCategoryDescriptionInterface
     */
    protected GenerateCategoryDescriptionInterface $generateCategoryDescription;

    /**
     * @param ModuleConfig $moduleConfig
     * @param GenerateCategoryDescriptionInterface $generateCategoryDescription
     * @param null $name
     */
    public function __construct(
        ModuleConfig $moduleConfig,
        GenerateCategoryDescriptionInterface $generateCategoryDescription,
        $name = null
    ) {
        $this->moduleConfig = $moduleConfig;
        $this->generateCategoryDescription = $generateCategoryDescription;
        parent::__construct($name);
    }

    /**
     * Initialization of the command.
     */
    protected function configure()
    {
        $this->setName('openai-gpt:generate:category-description:by-id');
        $this->setDescription('Generate category description with OpenAI GPT model language API, providing category ID and store ID.');
        $this->addOption(
            'category_id',
            'c',
            InputOption::VALUE_REQUIRED,
            'Category ID'
        );
        $this->addOption(
            'store_id',
            'i',
            InputOption::VALUE_REQUIRED,
            'Store ID'
        );
        parent::configure();
    }

    /**
     * CLI command description.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     * @throws Exception|RuntimeException
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        if (!$this->moduleConfig->isModuleEnable()) {
            throw new RuntimeException('Module is disabled!');
        }

        $categoryId = $input->getOption('category_id');
        if (!$categoryId) {
            throw new RuntimeException('Not enough arguments (missing: "category_id").');
        }

        $storeId = $input->getOption('store_id');
        if (!$storeId) {
            throw new RuntimeException('Not enough arguments (missing: "store_id").');
        }

        $description = $this->generateCategoryDescription->getCategoryDescriptionById($categoryId, $storeId);
        $output->writeln($description);
    }
}
