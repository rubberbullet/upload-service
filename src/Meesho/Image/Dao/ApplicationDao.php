<?php

namespace Naukri\Payment\Dao;

use Naukri\Payment\Model\ApplicationModel;

/**
 * Description of ApplicationDao
 *
 * @author Tarun Chabawral <tarun.chabarwal@naukri.com>
 */
class ApplicationDao extends BaseDao
{

    /**
     * @param type $id
     * @return ApplicationModel
     * @throws DBException
     */
    public function getApplicationById($id) {
        try {
            $dbConn = $this->getConnection();
            $sql = "select id, app_name, callback_url, pref_gateway from application where id = :id";
            $pdoStmt = $dbConn->prepare($sql);
            $pdoStmt->bindValue(':id', $id, \PDO::PARAM_INT);
            $pdoStmt->execute();
            $data = $pdoStmt->fetch(\PDO::FETCH_ASSOC);
            if (false === $data) {
                throw new \UnexpectedValueException("app <{$id}> not registered");
            }
            $obj = new ApplicationModel();
            $obj->setId($data['id']);
            $obj->setAppName($data['app_name']);
            $obj->setCallbackUrl($data['callback_url']);
            $obj->setPrefGateway($data['pref_gateway']);
            return $obj;
        } catch (\Exception $e) {
            throw new DBException($e->getMessage(), $e->getCode(), $e);
        }
    }

}
