<?php

use Transip\Api\Library\TransipAPI;

require_once (__DIR__ . '/key.php');
require_once(__DIR__ . '/vendor/autoload.php');

$api = new TransipAPI(
    $login,
    $privateKey,
    false,
    '',
    'http://api.fe.avahidnia.dev.transip.us/v6'
);
$response = $api->test()->test();

array_shift($argv);
$results = $api->domainAvailability()->checkMultipleDomainNames($argv);

foreach ($results as $result) {
    echo $result->getDomainName(). " : " . $result->getStatus() . PHP_EOL;
}