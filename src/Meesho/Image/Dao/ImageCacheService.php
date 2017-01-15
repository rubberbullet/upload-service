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

    private $redisConn;

    public function __construct() {
        $this->redisConn = RedisManager::getInstance()->getRedisConnection('meeshoRedis');
    }

    public function getIncrImageCounter() {
        return $this->redisConn->incr('counter');
    }

    public function insertCacheImage($key, $fileData) {
        return $this->redisConn->hmset($key, $fileData);
    }

    public function getCacheImage($key) {
        return $this->redisConn->hgetall($key);
    }

    public function deleteCacheImage($key) {
        return $this->redisConn->del($key);
    }

}
