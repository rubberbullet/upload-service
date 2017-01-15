<?php

namespace Meesho\Image\Dao;

use Meesho\Image\Util\DatabaseManager;
use Phalcon\Db\Column;

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

    public function insertImageDetail() {
        $sql = $this->dbConn->prepare('INSERT INTO IMAGE(IMAGE_ID, NAME, MOD_NAME, LOCATION, TYPE) VALUES(:IMAGE_ID, :NAME, :MOD_NAME, :LOCATION, :TYPE)');
        $result = $this->dbConn->executePrepared($sql, ['IMAGE_ID' => 123, 'NAME' => 'test', 'MOD_NAME' => 'testMod', 'LOCATION' => '\apps\abc', 'TYPE' => 'S'], ['IMAGE_ID' => Column::BIND_PARAM_INT, 'NAME' => Column::BIND_PARAM_STR, 'MOD_NAME' => Column::BIND_PARAM_STR, 'LOCATION' => Column::BIND_PARAM_STR, 'TYPE' => Column::BIND_PARAM_STR]);
    }

    public function getAllImage() {
        return $this->dbConn->fetchAll("SELECT IMAGE_ID, NAME, MOD_NAME, LOCATION, TYPE FROM IMAGE");
    }

}
