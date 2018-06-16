<?php

namespace App\Command;

use App\Services\GalleryService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GenerateImagesCommand extends Command
{
    /**
     * @var GalleryService
     */
    private $galleryService;

    public function __construct(GalleryService $galleryService)
    {
        parent::__construct('generate:images');
        $this->galleryService = $galleryService;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $this->galleryService->getGallery();
    }
}
