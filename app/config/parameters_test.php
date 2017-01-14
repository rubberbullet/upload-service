<?php

include_once __DIR__ . '/parameters_common.php';

// response will be handled by application and then passed payment service
define("PAYMENT_RESPONSE_URL", 'http://dev1.resume.infoedge.com:8080/pgredirect');
define("PAYTM_CALLBACK_HANDLER_URL", PAYMENT_RESPONSE_URL . '/paytm');
define("PAYTM_INDUSTRY_TYPE_ID", "Retail");

define("MOBIKWIK_CALLBACK_HANDLER_URL", PAYMENT_RESPONSE_URL . '/mobikwik');

//temporary to be moved in db
define("MOBIKWIK_STATUS_CHECK_URL", "https://test.mobikwik.com/mobikwik/checkstatus");
