<?php

namespace Meesho\Image\Dao;

use Meesho\Image\Util\RedisManager;

/**
 * Description of ImageCacheService
 *
 * @author krishna.acharjee
 */
class ImageCacheService
{

    public function getIncrImageCounter() {
        $redisConn = RedisManager::getInstance()->getRedisConnection('meeshoRedis');
        $redisConn->set('counter', 1);
    }

}
