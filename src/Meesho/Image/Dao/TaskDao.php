<?php

namespace Meesho\Image\Dao;

use Meesho\Image\Util\DatabaseManager;
use Phalcon\Db\Column;
use Meesho\Image\Model\TaskModel;
use Meesho\Image\Dao\DBException;

/**
 * Description of TaskDao
 *
 * @author krishna.acharjee
 */
class TaskDao
{

    private $dbConn;

    public function __construct() {
        $this->dbConn = DatabaseManager::getInstance()->getDatabaseConnection('meeshoDB');
    }

    public function insertTask(TaskModel $task) {
        try {
            $sql = $this->dbConn->prepare('INSERT INTO TASK(FUNC_ID, USER_ID, FIRST_NAME) VALUES(:FUNC_ID, :USER_ID, :FIRST_NAME)');
            $this->dbConn->executePrepared($sql, ['FUNC_ID' => $task->getFuncId(), 'USER_ID' => $task->getUserid(), 'FIRST_NAME' => $task->getFirstName()], ['FUNC_ID' => Column::BIND_PARAM_INT, 'USER_ID' => Column::BIND_PARAM_STR, 'FIRST_NAME' => Column::BIND_PARAM_STR]);
            return $this->dbConn->lastInsertId();
        } catch (\Exception $e) {
            throw new DBException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function getLatestTask() {
        try {
            $taskArr = $this->dbConn->fetchAll("SELECT TASK_ID, FUNC_ID, USER_ID, FIRST_NAME FROM TASK WHERE TASK_ID = (SELECT MAX(TASK_ID) FROM TASK)");
            return $this->getTaskModelArr($taskArr);
        } catch (\Exception $e) {
            throw new DBException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function getTaskById($taskId) {
        try {
            $sql = $this->dbConn->prepare("SELECT TASK_ID, FUNC_ID, USER_ID, FIRST_NAME FROM TASK WHERE TASK_ID = :TASK_ID");
            $result = $this->dbConn->executePrepared($sql, ['TASK_ID' => $taskId], ['TASK_ID' => Column::BIND_PARAM_INT]);
            return $this->getTaskModelArr(array($result->fetch()));
        } catch (\Exception $e) {
            throw new DBException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function sendTaskToLog($taskId) {
        try {
            $this->deleteTask($taskId);
            $sql = $this->dbConn->prepare("INSERT INTO TASK_LOG(TASK_ID, STATUS) VALUES(:TASK_ID, 'PENDING')");
            return $this->dbConn->executePrepared($sql, ['TASK_ID' => $taskId], ['TASK_ID' => Column::BIND_PARAM_INT]);
        } catch (\Exception $e) {
            throw new DBException($e->getMessage(), $e->getCode(), $e);
        }
    }

    private function deleteTask($taskId) {
        try {
            $sql = $this->dbConn->prepare("DELETE FROM TASK WHERE TASK_ID = :TASK_ID");
            return $this->dbConn->executePrepared($sql, ['TASK_ID' => $taskId], ['TASK_ID' => Column::BIND_PARAM_INT]);
        } catch (\Exception $e) {
            throw new DBException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function markTaskComplete($taskId) {
        try {
            $sql = $this->dbConn->prepare("UPDATE TASK_LOG SET STATUS = 'DONE' WHERE TASK_ID = :TASK_ID");
            return $this->dbConn->executePrepared($sql, ['TASK_ID' => $taskId], ['TASK_ID' => Column::BIND_PARAM_INT]);
        } catch (\Exception $e) {
            throw new DBException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function getTaskStatus($taskId) {
        try {
            $sql = $this->dbConn->prepare("SELECT TASK_ID, STATUS FROM TASK_LOG WHERE TASK_ID = :TASK_ID");
            $result = $this->dbConn->executePrepared($sql, ['TASK_ID' => $taskId], ['TASK_ID' => Column::BIND_PARAM_INT]);
            $row = $result->fetch();
            return $row['STATUS'];
        } catch (\Exception $e) {
            throw new DBException($e->getMessage(), $e->getCode(), $e);
        }
    }

    private function getTaskModelArr($taskArr) {
        $taskModelArr = array();
        foreach ($taskArr as $task) {
            $taskModel = new TaskModel();
            $taskModel->setTaskId($task['TASK_ID']);
            $taskModel->setFuncId($task['FUNC_ID']);
            $taskModel->setUserid($task['USER_ID']);
            $taskModel->setFirstName($task['FIRST_NAME']);
            $taskModelArr[] = $taskModel;
        }
        return $taskModelArr;
    }

}
