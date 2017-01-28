<?php

namespace Meesho\Image\Service;

use Meesho\Image\Dao\TaskDao;
use Meesho\Image\Model\TaskModel;

/**
 * Description of ImageService
 *
 * @author krishna.acharjee
 */
class TaskService
{

    public function addTask($funcId, $param = array()) {
        $taskDao = new TaskDao();
        $taskModel = new TaskModel();
        $taskModel->setFuncId($funcId);
        $taskModel->setFirstName($param['first_name']);
        $taskModel->setUserid($param['user_id']);
        return $taskDao->insertTask($taskModel);
    }

    public function getLatestTask() {
        $taskDao = new TaskDao();
        $taskModelArr = $taskDao->getLatestTask();
        $latestTask = $taskModelArr[0];
        return $latestTask;
    }

    public function completeTask($taskId) {
        try {
            $taskDao = new TaskDao();
            $taskDao->sendTaskToLog($taskId);
            //Do your task
            $taskDao->markTaskComplete($taskId);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

//    private function getTaskStatus() {
//        
//    }
}
