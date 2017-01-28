<?php

namespace Meesho\Image\Model;

/**
 * Description of TaskModel
 *
 * @author krishna.acharjee
 */
class TaskModel
{

    private $taskId;
    private $funcId;
    private $userid;
    private $firstName;

    function getTaskId() {
        return $this->taskId;
    }

    function setTaskId($taskId) {
        $this->taskId = $taskId;
    }

    function getFuncId() {
        return $this->funcId;
    }

    function getUserid() {
        return $this->userid;
    }

    function getFirstName() {
        return $this->firstName;
    }

    function setFuncId($funcId) {
        $this->funcId = $funcId;
    }

    function setUserid($userid) {
        $this->userid = $userid;
    }

    function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

}
