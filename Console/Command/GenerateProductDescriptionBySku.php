<?php

namespace SamueleMartini\GPT\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use SamueleMartini\GPT\Helper\ModuleConfig;
use SamueleMartini\GPT\Api\GenerateProductDescriptionInterface;
use Symfony\Component\Console\Exception\RuntimeException;
use Exception;

class GenerateProductDescriptionBySku extends Command
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
        $this->setName('openai-gpt:generate:product-description:by-sku');
        $this->setDescription('Generate product description with OpenAI GPT model language API, providing product sku and store ID.');
        $this->addOption(
            'sku',
            's',
            InputOption::VALUE_REQUIRED,
            'Product sku'
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

        $sku = $input->getOption('sku');
        if (!$sku) {
            throw new RuntimeException('Not enough arguments (missing: "sku").');
        }

        $storeId = $input->getOption('store_id');
        if (!$storeId) {
            throw new RuntimeException('Not enough arguments (missing: "store_id").');
        }

        $description = $this->generateProductDescription->getProductDescriptionBySku($sku, $storeId);
        $output->writeln($description);
    }
}
