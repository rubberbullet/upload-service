<?php

use \Meesho\Image\Service\ImageService;
use \Meesho\Image\Service\TaskService;

error_reporting(E_ALL);
$loader = new \Phalcon\Loader();

require_once "../vendor/autoload.php";

$app = new Phalcon\Mvc\Micro();

$app["view"] = function () {
    $view = new \Phalcon\Mvc\View\Simple();
    $view->setViewsDir("../src/Meesho/Image/View/");
    return $view;
};

$app->get(
    "/image/upload", function () use ($app) {
    echo $app["view"]->render(
        "upload"
    );
}
);

$app->get(
    "/image/download", function () use ($app) {
    echo $app["view"]->render(
        "download"
    );
}
);

$app->get('/', function() {
    $response = new Phalcon\Http\Response();
    $response->setContent("<h1>Service is up & running...</h1>");
    $response->send();
});

$app->post('/upload', function() use ($app) {
    $response = new Phalcon\Http\Response();
    try {
        $imageService = new ImageService();
        $fileContent = file_get_contents($_FILES["image"]["tmp_name"]);
        $errMsg = $imageService->validateImage($_FILES["image"]["tmp_name"], $_FILES["image"]["size"]);
        $counterId = $imageService->handleImage($_FILES["image"]["name"], $_FILES["image"]["type"], $_FILES["image"]["size"], $fileContent);
        $response->setJsonContent(array('success' => true, 'key' => $counterId, 'error' => $errMsg));
    } catch (\Exception $e) {
        $response->setJsonContent(array('success' => false, 'key' => "", 'error' => "Sorry, there was an error saving your file"));
    }
    $response->send();
});

$app->post('/save', function() use ($app) {
    $response = new Phalcon\Http\Response();
    try {
        $requestParam = $app->request->getPost();
        $imageService = new ImageService();
        $imageService->saveImage($requestParam['key']);
        $response->setJsonContent(array('success' => true, 'error' => ""));
    } catch (\Exception $e) {
        $response->setJsonContent(array('success' => false, 'error' => "Sorry, there was an error uploading your file"));
    }
    $response->send();
});

$app->get('/download', function() use ($app) {
    $response = new Phalcon\Http\Response();
    try {
        $imageService = new ImageService();
        $imageService->downloadImage();
        $response->setJsonContent(array('success' => true, 'error' => ""));
    } catch (\Exception $e) {
        $response->setJsonContent(array('success' => false, 'error' => "Sorry, there was an error downloading your file"));
    }
    $response->send();
});

$app->post('/task/add', function() use ($app) {
    $response = new Phalcon\Http\Response();
    try {
        $requestParam = $app->request->getJsonRawBody();
        $taskService = new TaskService();
        $taskId = $taskService->addTask($requestParam->func_id, array('first_name' => $requestParam->params->first_name, 'user_id' => $requestParam->params->user_id));
        $response->setJsonContent(array('success' => true, 'task_id' => $taskId));
    } catch (\Exception $e) {
        $response->setJsonContent(array('success' => false));
    }
    $response->send();
});

$app->get('/task/fetch', function() use ($app) {
    $response = new Phalcon\Http\Response();
    try {
        $taskService = new TaskService();
        $taskModel = $taskService->getLatestTask();
        $response->setJsonContent(array('success' => true, 'task_id' => $taskModel->getTaskId(), 'func_id' => $taskModel->getFuncId(), 'params' => array('first_name' => $taskModel->getFirstName(), 'user_id' => $taskModel->getUserid())));
    } catch (\Exception $e) {
        $response->setJsonContent(array('success' => false));
    }
    $response->send();
});

$app->post('/task/complete', function() use ($app) {
    $response = new Phalcon\Http\Response();
    try {
        $requestParam = $app->request->getJsonRawBody();
        $taskService = new TaskService();
        $isComplete = $taskService->completeTask($requestParam->task_id);
        if ($isComplete) {
            $response->setJsonContent(array('success' => true));
        } else {
            $response->setJsonContent(array('success' => false));
        }
    } catch (\Exception $e) {
        $response->setJsonContent(array('success' => false));
    }
    $response->send();
});

$app->handle();
