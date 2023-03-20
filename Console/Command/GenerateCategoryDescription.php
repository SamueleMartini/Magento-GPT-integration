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

class GenerateCategoryDescription extends Command
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
        $this->setName('openai-gpt:generate:category-description:by-name');
        $this->setDescription('Generate category description with OpenAI GPT model language API, providing category name and language.');
        $this->addOption(
            'category_name',
            'c',
            InputOption::VALUE_REQUIRED,
            'Category name'
        );
        $this->addOption(
            'language',
            'l',
            InputOption::VALUE_REQUIRED,
            'language'
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

        $categoryName = $input->getOption('category_name');
        if (!$categoryName) {
            throw new RuntimeException('Not enough arguments (missing: "category_name").');
        }

        $language = $input->getOption('language');
        if (!$language) {
            throw new RuntimeException('Not enough arguments (missing: "language").');
        }

        $description = $this->generateCategoryDescription->getCategoryDescription($categoryName, $language);
        $output->writeln($description);
    }
}
