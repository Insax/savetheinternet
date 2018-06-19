<?php

namespace App\Services;

use Symfony\Component\Finder\Finder;

class GalleryService
{
    /**
     * @var string
     */
    private $rootDir;

    /**
     * GalleryService constructor.
     *
     * @param string $rootDir
     */
    public function __construct(string $rootDir)
    {
        $this->rootDir = $rootDir;
    }

    public function getGallery(): array
    {
        $base = $this->rootDir.'/public/build/static/gallery';
        $files = $base.'/files/';
        $preview = $base.'/preview/';

        if (!is_dir($base) && !mkdir($base) && !is_dir($base)) {
            error_log('Could not create Basefolder for Images');

            return [];
        }

        if (!is_dir($files)) {
            error_log('Could not find Files Folder');

            return [];
        }

        if (!is_dir($preview) && !mkdir($preview) && !is_dir($preview)) {
            error_log('Could not create Preview Folder');

            return [];
        }

        $finder = new Finder();

        $finder->files()->depth('< 3')->name('/\.(png|jpg)$/i')->in($files);

        $galleryImages = [];

        foreach ($finder as $file) {
            $name = $file->getFilename();
            $langcode = basename(\dirname($file->getRealPath()));
            $thumb = sprintf('%s/thumb_%s', $langcode, $name);

            if (!file_exists($preview.$thumb)) {
                $writeReturn = $this->resizeImage($file->getRealPath(), $preview.$thumb);

                if ($writeReturn === false) {
                    error_log('Could not write File: '.$file->getRealPath());
                }
            }

            $galleryImages[] = [
                'name'     => sprintf('%s/%s', $langcode, $name),
                'thumb'    => $thumb,
                'langcode' => $langcode,
            ];
        }

        return $galleryImages;
    }

    private function resizeImage(string $filePath, $destinationName): bool
    {
        try {
            $imagick = new \Imagick($filePath);

            $imagick->resizeImage(453, 640, 0, 1, true);
            /*$imageWidth = $imagick->getImageWidth();
            if($imagick->getImageHeight() > $imageWidth * 1.5) {
                $imagick->cropImage($imageWidth,$imageWidth * 1.5,0,0);
            }*/

            if (is_writable(\dirname($destinationName))) {
                return $imagick->writeImage($destinationName);
            }
        } catch (\ImagickException $e) {
        }

        return false;
    }
}
