<?php

namespace Meesho\Image\Dao;

/**
 * Description of DBException
 *
 * @author krishna.acharjee
 */
class DBException extends \Exception
{

    public function __construct($message, $code, $previous) {
        parent::__construct($message, $code, $previous);
    }

}
