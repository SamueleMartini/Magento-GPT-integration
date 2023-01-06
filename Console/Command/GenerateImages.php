<?php

namespace SamueleMartini\GPT3\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use SamueleMartini\GPT3\Helper\ModuleConfig;
use SamueleMartini\GPT3\Api\GPT3ImagesInterface;
use Symfony\Component\Console\Exception\RuntimeException;
use Exception;

class GenerateImages extends Command
{
    /**
     * @var ModuleConfig
     */
    protected ModuleConfig $moduleConfig;
    /**
     * @var GPT3ImagesInterface
     */
    protected GPT3ImagesInterface $GPT3Images;

    /**
     * @param ModuleConfig $moduleConfig
     * @param GPT3ImagesInterface $GPT3Images
     * @param null $name
     */
    public function __construct(
        ModuleConfig $moduleConfig,
        GPT3ImagesInterface $GPT3Images,
        $name = null
    ) {
        $this->moduleConfig = $moduleConfig;
        $this->GPT3Images = $GPT3Images;
        parent::__construct($name);
    }

    /**
     * Initialization of the command.
     */
    protected function configure()
    {
        $this->setName('gpt-3:generate:images');
        $this->setDescription('Generate inages with GPT-3 Open AI API, providing description of images.');
        $this->addOption(
            'images_description',
            'd',
            InputOption::VALUE_REQUIRED,
            'Images description'
        );
        $this->addOption(
            'quantity',
            'y',
            InputOption::VALUE_OPTIONAL,
            'Number of images to return'
        );
        $this->addOption(
            'size',
            's',
            InputOption::VALUE_OPTIONAL,
            'Size of images to return'
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

        $imagesDescription = $input->getOption('images_description');
        if (!$imagesDescription) {
            throw new RuntimeException('Not enough arguments (missing: "images_description").');
        }

        $qty = $input->getOption('quantity') ? $input->getOption('quantity') : 1;
        $size = $input->getOption('size') ? $input->getOption('size') : '1024x1024';

        $images = $this->GPT3Images->getGPT3Images($imagesDescription, (int)$qty, $size);

        foreach ($images as $key => $image) {
            $output->writeln("\n" . ($key + 1) . ': ' . $image['url']);
        }
    }
}
