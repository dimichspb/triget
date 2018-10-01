<?php
namespace app\services\room;

interface FilesystemInterface
{
    public function getFileFromUploadBucket($filename);

    public function getFileFromOriginalBucket($filename);

    public function getFileFrom200x200Bucket($filename);

    public function getFileFrom400x400Bucket($filename);

    public function saveFileToUploadBucket($filename, $stream);
}