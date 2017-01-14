<?php

/**
 * Description of RedisException
 *
 * @author krishna.acharjee
 */
class RedisException extends \Exception
{
    public function __construct($message, $code, $previous) {
        parent::__construct($message, $code, $previous);
    }

}
