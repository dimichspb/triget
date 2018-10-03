<?php
namespace app\helpers;

use Gregwar\Image\Image;

class ImageProcessor
{
    /**
     * @var Image
     */
    protected $imageLibrary;

    /**
     * ImageProcessor constructor.
     * @param Image $imageLibrary
     */
    public function __construct(Image $imageLibrary)
    {
        $this->imageLibrary = $imageLibrary;
    }

    /**
     * Resize original image
     * @param $stream
     * @param null $width
     * @param null $height
     * @param string $background
     * @return bool|resource
     */
    public function resize($stream, $width = null, $height = null, $background = 'white')
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