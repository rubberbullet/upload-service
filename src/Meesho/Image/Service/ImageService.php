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
    public function getCounterId(){
        $imageCache = new ImageCacheService();
        $imageCache->getIncrImageCounter();
    }
    
    public function insertCacheImage(){
           
    }
    
    public function deleteCacheImage(){
        
    }
    
    public function getCacheImageDetail(){
        
    }
    
    public function saveImage(){
        
    }
    
    public function getResizedImage(){
        
    }
    
    public function insertImageDetail(){
        
    }
    
    public function getImageDetail(){
        
    }
}
