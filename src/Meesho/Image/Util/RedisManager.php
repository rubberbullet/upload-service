<?php

namespace Meesho\Image\Util;

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
//        $frontCache = new FrontData([
//            'lifetime' => 1800
//        ]);
        foreach ($redisArr as $redisName => $config) {
            //  $this->redis[$redisName] = new Redis($frontCache, $config);
            $this->redis[$redisName] = new \Phalcon\Session\Adapter\Redis($config);
        }
    }

    public function getRedisConnection($name) {
        $session = $this->redis[$name];
        if ($session->status() !== $session::SESSION_ACTIVE) {
            $session->start();
        }
        return $this->redis[$name];
    }

}
