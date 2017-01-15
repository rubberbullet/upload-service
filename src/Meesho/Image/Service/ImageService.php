<?php

namespace Meesho\Image\Service;

use Meesho\Image\Dao\ImageCacheService;

/**
 * Description of ImageService
 *
 * @author krishna.acharjee
 */
class ImageService
{

    public function getCounterId() {
        $imageCache = new ImageCacheService();
        return $imageCache->getIncrImageCounter();
    }

    public function deleteCache() {
        
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
        $path = $target_dir . $counterId . "_O." . $fileInfo["extension"];
        file_put_contents($path, $fileContent);
    }

    public function getResizedImage() {
        
    }

    public function insertImageDetail() {
        
    }

    public function getImageDetail() {
        
    }

    public function handleImage($name, $type, $size, $content) {
        $fileData = array('name' => $name, 'type' => $type, 'size' => $size, 'content' => $content);
        $counterId = $this->getCounterId();
        $imageCache = new ImageCacheService();
        $imageCache->insertCacheImage($counterId, $fileData);
        return $counterId;
    }

}
