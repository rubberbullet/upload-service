<?php

namespace Meesho\Image\Util;

use Redis;
use Meesho\Image\Util\RedisConstant;

/**
 * Description of RedisManager
 *
 * @author krishna.acharjee
 */
class RedisManager
{

    protected $redis = array();
    private static $instance;

    public static function getInstance() {
        if (!isset(self::$instance)) {
            $class = __CLASS__;
            self::$instance = new $class();
        }

        return self::$instance;
    }

    private function __construct() {
        $redisArr = RedisConstant::$redis;
        foreach ($redisArr as $redisName => $config) {
            $this->redis[$redisName] = new Redis();
            $this->redis[$redisName]->connect('redis');
        }
    }

    public function getRedisConnection($name) {
        return $this->redis[$name];
    }

}
