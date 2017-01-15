<?php

namespace Meesho\Image\Service;

use Meesho\Image\Dao\ImageCacheService;
use Meesho\Image\Dao\ImageDao;
use Meesho\Image\Model\ImageModel;

/**
 * Description of ImageService
 *
 * @author krishna.acharjee
 */
class ImageService
{

    private function getCounterId() {
        $imageCache = new ImageCacheService();
        return $imageCache->getIncrImageCounter();
    }

    private function deleteCache($key) {
        $imageCache = new ImageCacheService();
        return $imageCache->deleteCacheImage($key);
    }

    private function getCacheImage($key) {
        $imageCache = new ImageCacheService();
        return $imageCache->getCacheImage($key);
    }

    public function saveImage($counterId) {
        $target_dir = "/tmp/";
        $cacheImage = $this->getCacheImage($counterId);
        $fileContent = $cacheImage['content'];
        $fileInfo = pathinfo($cacheImage['name']);
        $fileName = $counterId . "_O." . $fileInfo["extension"];
        $path = $target_dir . $fileName;
        file_put_contents($path, $fileContent);
        $originalImage = $this->getImageModel($counterId, $cacheImage['name'], $fileName, $target_dir);
        $this->insertImageDetail($originalImage);
        $smallImageName = $counterId . "_S." . $fileInfo["extension"];
        $this->putResizedImage(256, $path, $target_dir . $smallImageName);
        $smallImage = $this->getImageModel($counterId, $cacheImage['name'], $smallImageName, $target_dir, 'S');
        $this->insertImageDetail($smallImage);
        $mediumImageName = $counterId . "_M." . $fileInfo["extension"];
        $this->putResizedImage(512, $path, $target_dir . $mediumImageName);
        $mediumImage = $this->getImageModel($counterId, $cacheImage['name'], $mediumImageName, $target_dir, 'M');
        $this->insertImageDetail($mediumImage);
        $this->deleteCache($counterId);
    }

    private function putResizedImage($pixel, $originalPath, $newPath) {
        $imagick = new \Imagick(realpath($originalPath));
        $imagick->scaleImage($pixel, 0, false);
        $imagick->writeImage($newPath);
    }

    private function insertImageDetail(ImageModel $image) {
        $imageDao = new ImageDao();
        $imageDao->insertImageDetail($image);
    }

    public function downloadImage() {
        $zip = new \ZipArchive();
        $imageDao = new ImageDao();
        $imageArr = $imageDao->getAllImage();
        $dir = "/tmp/";
        $zipname = 'meesho-image.zip';
        $zipPath = $dir . $zipname;
        unlink($zipPath);
        $zip->open($zipPath, \ZipArchive::CREATE);
        foreach ($imageArr as $image) {
            $filePath = ($image->getLocation()) . "/" . ($image->getModName());
            $fileInfo = pathinfo($image->getName());
            $zip->addFile($filePath, $fileInfo["filename"] . "_" . $image->getType() . "." . $fileInfo["extension"]);
        }
        $zip->close();

        header('Content-Type: application/zip');
        header("Content-Disposition: attachment; filename='" . $zipname . "'");
        header('Content-Length: ' . filesize($zipPath));
        header("Pragma: no-cache");
        header("Expires: 0");
        readfile($zipPath);
        exit;
    }

    public function handleImage($name, $type, $size, $content) {
        $fileData = array('name' => $name, 'type' => $type, 'size' => $size, 'content' => $content);
        $counterId = $this->getCounterId();
        $imageCache = new ImageCacheService();
        $imageCache->insertCacheImage($counterId, $fileData);
        return $counterId;
    }

    public function validateImage($content) {
        $errMsg = "";
        $size = getimagesize($content);
        if ($size === false) {
            $errMsg = "Please upload a proper Image";
        } else if ($size > 2000000) {
            $errMsg = "Uploaded image should be less than 2 MB";
        }
        return $errMsg;
    }

    private function getImageModel($counterId, $name, $modName, $path, $type = 'O') {
        $image = new ImageModel();
        $image->setImageId($counterId);
        $image->setName($name);
        $image->setModName($modName);
        $image->setLocation($path);
        $image->setType($type);
        return $image;
    }

}
