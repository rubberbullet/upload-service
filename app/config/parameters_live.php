<?php

include_once __DIR__ . '/parameters_common.php';

// response will be handled by application and then passed payment service
define("PAYMENT_RESPONSE_URL", 'https://resume.naukri.com/pgredirect');

define("PAYTM_CALLBACK_HANDLER_URL", PAYMENT_RESPONSE_URL . '/paytm');
define("PAYTM_INDUSTRY_TYPE_ID", "Retail104");

define("MOBIKWIK_CALLBACK_HANDLER_URL", PAYMENT_RESPONSE_URL . '/mobikwik');


//@todo: temporary to be moved in db
define("MOBIKWIK_STATUS_CHECK_URL", "https://walletapi.mobikwik.com/checkstatus");
