<?php

namespace SamueleMartini\GPT3\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use SamueleMartini\GPT3\Helper\ModuleConfig;
use SamueleMartini\GPT3\Api\GenerateProductDescriptionInterface;
use Symfony\Component\Console\Exception\RuntimeException;
use Exception;

class GenerateProductDescription extends Command
{
    /**
     * @var ModuleConfig
     */
    protected ModuleConfig $moduleConfig;
    /**
     * @var GenerateProductDescriptionInterface
     */
    protected GenerateProductDescriptionInterface $generateProductDescription;

    /**
     * @param ModuleConfig $moduleConfig
     * @param GenerateProductDescriptionInterface $generateProductDescription
     * @param null $name
     */
    public function __construct(
        ModuleConfig $moduleConfig,
        GenerateProductDescriptionInterface $generateProductDescription,
        $name = null
    ) {
        $this->moduleConfig = $moduleConfig;
        $this->generateProductDescription = $generateProductDescription;
        parent::__construct($name);
    }

    /**
     * Initialization of the command.
     */
    protected function configure()
    {
        $this->setName('gpt-3:generate:product-description:by-name');
        $this->setDescription('Generate product description with GPT-3 Open AI API, providing product name and language.');
        $this->addOption(
            'product_name',
            'p',
            InputOption::VALUE_REQUIRED,
            'Product name'
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

        $productName = $input->getOption('product_name');
        if (!$productName) {
            throw new RuntimeException('Not enough arguments (missing: "product_name").');
        }

        $language = $input->getOption('language');
        if (!$language) {
            throw new RuntimeException('Not enough arguments (missing: "language").');
        }

        $description = $this->generateProductDescription->getProductDescription($productName, $language);
        $output->writeln($description);
    }
}
