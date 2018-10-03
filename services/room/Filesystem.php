<?php
namespace app\services\room;

use app\helpers\ImageProcessor;
use yii\web\NotFoundHttpException;

class Filesystem implements FilesystemInterface
{
    /**
     * @var \League\Flysystem\FilesystemInterface
     */
    protected $filesystem;

    /**
     * @var ImageProcessor
     */
    protected $imageProcessor;

    /**
     * @var string
     */
    protected $uploadBucketName;

    /**
     * @var string
     */
    protected $originalBucketName;

    /**
     * @var string
     */
    protected $size200x200BucketName;

    /**
     * @var string
     */
    protected $size400x400BucketName;

    /**
     * Filesystem constructor.
     * @param \League\Flysystem\FilesystemInterface $filesystem
     * @param ImageProcessor $imageProcessor
     * @param string $uploadBucketName
     * @param string $originalBucketName
     * @param string $size200x200BucketName
     * @param string $size400x400BucketName
     */
    public function __construct(\League\Flysystem\FilesystemInterface $filesystem, ImageProcessor $imageProcessor, $uploadBucketName = 'upload',
                                $originalBucketName = 'original', $size200x200BucketName = '200x200', $size400x400BucketName = '400x400')
    {
        $this->filesystem = $filesystem;
        $this->imageProcessor = $imageProcessor;

        $this->uploadBucketName = $uploadBucketName;
        $this->originalBucketName = $originalBucketName;
        $this->size200x200BucketName = $size200x200BucketName;
        $this->size400x400BucketName = $size400x400BucketName;
    }

    /**
     * Get File from Upload Bucket
     * @param $filename
     * @return false|resource
     * @throws NotFoundHttpException
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function getFileFromUploadBucket($filename)
    {
        $path = $this->buildPath($this->uploadBucketName, $filename);

        if (!$this->filesystem->has($path)) {
            throw new NotFoundHttpException('File not found: ' . $path);
        }

        return $this->filesystem->readStream($this->buildPath($this->uploadBucketName, $filename));
    }

    /**
     * Get File from Original Bucket
     * @param $filename
     * @return false|resource
     * @throws \League\Flysystem\FileExistsException
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function getFileFromOriginalBucket($filename)
    {
        $uploadPath = $this->buildPath($this->uploadBucketName, $filename);
        $path = $this->buildPath($this->originalBucketName, $filename);

        if (!$this->filesystem->has($path)) {
            $this->filesystem->writeStream($path, $this->imageProcessor->resize($this->filesystem->readStream($uploadPath)));
        }

        return $this->filesystem->readStream($path);
    }

    /**
     * Get File from 200x200 Bucket
     * @param $filename
     * @return false|resource
     * @throws \League\Flysystem\FileExistsException
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function getFileFrom200x200Bucket($filename)
    {
        $uploadPath = $this->buildPath($this->uploadBucketName, $filename);
        $path = $this->buildPath($this->size200x200BucketName, $filename);

        if (!$this->filesystem->has($path)) {
            $this->filesystem->writeStream($path, $this->imageProcessor->resize($this->filesystem->readStream($uploadPath), 200, 200));
        }

        return $this->filesystem->readStream($path);
    }

    /**
     * Get File from 400x400 Bucket
     * @param $filename
     * @return false|resource
     * @throws \League\Flysystem\FileExistsException
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function getFileFrom400x400Bucket($filename)
    {
        $uploadPath = $this->buildPath($this->uploadBucketName, $filename);
        $path = $this->buildPath($this->size400x400BucketName, $filename);

        if (!$this->filesystem->has($path)) {
            $this->filesystem->writeStream($path, $this->imageProcessor->resize($this->filesystem->readStream($uploadPath), 400, 400));
        }

        return $this->filesystem->readStream($path);
    }

    /**
     * Save file to Upload Bucket
     * @param $filename
     * @param $stream
     * @return bool
     * @throws \League\Flysystem\FileExistsException
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function saveFileToUploadBucket($filename, $stream)
    {
        $path = $this->buildPath($this->uploadBucketName, $filename);
        if ($this->filesystem->has($path)) {
            return $this->filesystem->updateStream($this->buildPath($this->uploadBucketName, $filename), $stream);
        } else {
            return $this->filesystem->writeStream($this->buildPath($this->uploadBucketName, $filename), $stream);
        }
    }

    /**
     * Build path to file
     * @param $bucketName
     * @param $filename
     * @return string
     */
    protected function buildPath($bucketName, $filename)
    {
        $bucketName = trim($bucketName, "\t\n\r\0\x0B\\\/");
        $filename = trim($filename, "\t\n\r\0\x0B\\\/");

        return implode(DIRECTORY_SEPARATOR, [
            $bucketName,
            $filename
        ]);
    }

}