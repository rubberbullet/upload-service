<?php

use \Meesho\Image\Service\ImageService;

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
    $imageService = new ImageService();
    $fileContent = file_get_contents($_FILES["image"]["tmp_name"]);
    $counterId = $imageService->handleImage($_FILES["image"]["name"], $_FILES["image"]["type"], $_FILES["image"]["size"], $fileContent);
    $response = new Phalcon\Http\Response();
    $response->setJsonContent(array('key' => $counterId, 'errorMsg' => '', 'errorCount' => ''));
    $response->send();
});

$app->post('/save', function() use ($app) {
    $requestParam = $app->request->getPost();
    $imageService = new ImageService();
    $imageService->saveImage($requestParam['key']);
});

$app->get('/download', function() use ($app) {

    $imageService = new ImageService();
    $imageService->downloadImage();
});

$app->handle();
