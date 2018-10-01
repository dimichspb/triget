<?php
namespace app\helpers;

use Gregwar\Image\Image;

class ImageProcessor
{
    protected $imageLibrary;

    public function __construct(Image $imageLibrary)
    {
        $this->imageLibrary = $imageLibrary;
    }

    public function resize($stream, $width = null, $height = null, $background = 'transparent')
    {
        $content = stream_get_contents($stream);
        $image = $this->imageLibrary->fromResource(imagecreatefromstring($content));
        $image = $image->resize($width, $height, $background);
        $stream = fopen('php://memory','w+');
        fwrite($stream, $image->get());
        rewind($stream);

        return $stream;
    }
}