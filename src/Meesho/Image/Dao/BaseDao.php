<?php

namespace Naukri\Payment\Dao;

/**
 * Description of BaseDao
 *
 * @author Tarun Chabawral <tarun.chabarwal@naukri.com>
 */
class BaseDao
{

    protected function getConnection($tag = null) {
        if (null === $tag) {
            $tag = DB_TAG;
        }
        return \ncDatabaseManager::getInstance()->getDatabase($tag)->getConnection();
    }

}
