<?php

namespace SamueleMartini\GPT\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use SamueleMartini\GPT\Helper\ModuleConfig;
use SamueleMartini\GPT\Api\GPTImagesInterface;
use Symfony\Component\Console\Exception\RuntimeException;
use Exception;

class GenerateImages extends Command
{
    /**
     * @var ModuleConfig
     */
    protected ModuleConfig $moduleConfig;
    /**
     * @var GPTImagesInterface
     */
    protected GPTImagesInterface $GPTImages;

    /**
     * @param ModuleConfig $moduleConfig
     * @param GPTImagesInterface $GPTImages
     * @param null $name
     */
    public function __construct(
        ModuleConfig $moduleConfig,
        GPTImagesInterface $GPTImages,
        $name = null
    ) {
        $this->moduleConfig = $moduleConfig;
        $this->GPTImages = $GPTImages;
        parent::__construct($name);
    }

    /**
     * Initialization of the command.
     */
    protected function configure()
    {
        $this->setName('openai-dall-e:generate:images');
        $this->setDescription('Generate inages with OpenAI Dall-E API, providing description of images.');
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

        $images = $this->GPTImages->getGPTImages($imagesDescription, (int)$qty, $size);

        foreach ($images as $key => $image) {
            $output->writeln("\n" . ($key + 1) . ': ' . $image['url']);
        }
    }
}
