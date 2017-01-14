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
    echo Phalcon\Version::get();die();
    $requestParams = $app->request->getPost();
    $imageServ = new ImageService();
    $imageServ->getCounterId();
//    $pg = \Naukri\Payment\Service\PaymentHandlerFactory::getPaymentHandler();
//    $resp = $pg->getTemplate($requestParams);
//    $response = new Phalcon\Http\Response();
//    $response->setJsonContent($resp);
//    $response->send();
});

$app->get('/download', function() use ($app) {

    $requestParams = $app->request->getJsonRawBody(true);

//    $apiMgr = new Naukri\Payment\Api\TransactionStatusApi(Naukri\Payment\Service\TransactionManagerFactory::getTransactionManager());
//    $resp = $apiMgr->getTransactionStatus($requestParams['REFID']);
//    $response = new Phalcon\Http\Response();
//    $response->setJsonContent($resp);
//    $response->setContentType('application/json')->sendHeaders();
//    $response->send();
});

$app->handle();
