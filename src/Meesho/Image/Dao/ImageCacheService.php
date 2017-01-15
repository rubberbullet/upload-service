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
        try {
            return $this->redisConn->incr('counter');
        } catch (\Exception $e) {
            throw new RedisException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function insertCacheImage($key, $fileData) {
        try {
            return $this->redisConn->hmset($key, $fileData);
        } catch (\Exception $e) {
            throw new RedisException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function getCacheImage($key) {
        try {
            return $this->redisConn->hgetall($key);
        } catch (\Exception $e) {
            throw new RedisException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function deleteCacheImage($key) {
        try {
            return $this->redisConn->del($key);
        } catch (\Exception $e) {
            throw new RedisException($e->getMessage(), $e->getCode(), $e);
        }
    }

}
