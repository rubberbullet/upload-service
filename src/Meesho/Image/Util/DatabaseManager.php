<?php

namespace Meesho\Image\Util;

use Phalcon\Db\Adapter\Pdo\Mysql;
use DatabaseConstant;

/**
 * Description of DatabaseManager
 *
 * @author krishna.acharjee
 */
class DatabaseManager
{

    protected $databases = array();
    private static $instance;

    public static function getInstance() {
        if (!isset(self::$instance)) {
            $class = __CLASS__;
            self::$instance = new $class();
        }

        return self::$instance;
    }

    private function __construct() {
        $dbArr = DatabaseConstant::database;
        foreach ($dbArr as $db) {
            $this->databases[$db] = new Mysql(RedisConstant::$db);
        }
    }

    public function getDatabaseConnection($name) {
        return $this->databases[$name];
    }

}
