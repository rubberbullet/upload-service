<?php

namespace Meesho\Image\Dao;

use Meesho\Image\Util\DatabaseManager;
use Phalcon\Db\Column;
use Meesho\Image\Model\ImageModel;
use Meesho\Image\Dao\DBException;

/**
 * Description of ImageDao
 *
 * @author krishna.acharjee
 */
class ImageDao
{

    private $dbConn;

    public function __construct() {
        $this->dbConn = DatabaseManager::getInstance()->getDatabaseConnection('meeshoDB');
    }

    public function insertImageDetail(ImageModel $image) {
        try {
            $sql = $this->dbConn->prepare('INSERT INTO IMAGE(IMAGE_ID, NAME, MOD_NAME, LOCATION, TYPE) VALUES(:IMAGE_ID, :NAME, :MOD_NAME, :LOCATION, :TYPE)');
            return $this->dbConn->executePrepared($sql, ['IMAGE_ID' => $image->getImageId(), 'NAME' => $image->getName(), 'MOD_NAME' => $image->getModName(), 'LOCATION' => $image->getLocation(), 'TYPE' => $image->getType()], ['IMAGE_ID' => Column::BIND_PARAM_INT, 'NAME' => Column::BIND_PARAM_STR, 'MOD_NAME' => Column::BIND_PARAM_STR, 'LOCATION' => Column::BIND_PARAM_STR, 'TYPE' => Column::BIND_PARAM_STR]);
        } catch (\Exception $e) {
            throw new DBException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function getAllImage() {
        try {
            $imageArr = $this->dbConn->fetchAll("SELECT IMAGE_ID, NAME, MOD_NAME, LOCATION, TYPE FROM IMAGE");
            return $this->getImageModelArr($imageArr);
        } catch (\Exception $e) {
            throw new DBException($e->getMessage(), $e->getCode(), $e);
        }
    }

    private function getImageModelArr($imageArr) {
        $imageModelArr = array();
        foreach ($imageArr as $image) {
            $imageModel = new ImageModel();
            $imageModel->setImageId($image['IMAGE_ID']);
            $imageModel->setName($image['NAME']);
            $imageModel->setModName($image['MOD_NAME']);
            $imageModel->setLocation($image['LOCATION']);
            $imageModel->setType($image['TYPE']);
            $imageModelArr[] = $imageModel;
        }
        return $imageModelArr;
    }

}
