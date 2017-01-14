<?php

namespace Meesho\Image\Util;

/**
 * Description of Redis
 *
 * @author krishna.acharjee
 */
class RedisConstant
{
    public static $redis = array('meeshoRedis' => array('host' => 'redis','port' => 6379, 'persistent' => false, 'lifetime' => 1800)); //'host' => 'redis', 'port' => 6379, 'persistent' => false, 'index' => 0));
}
