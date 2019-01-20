<?php
namespace JsonParser;
require_once 'vendor/autoload.php';

use Guzzle\Http\Client;
use Carbon\Carbon;

// https://api.cryptowat.ch/markets/bitflyer/btcjpy/ohlc?periods=86400&after=1483196400
$client = new Client('https://api.cryptowat.ch/markets/bitflyer/');
$startDate = Carbon::create(2018, 1, 1, 0,0,0, 'Asia/Tokyo');
$secondPerDay = 60*60*24;


$request = $client->get("btcjpy/ohlc?periods={$secondPerDay}&after={$startDate->timestamp}");
$response = $request->send();
$data = $response->json();

$result = [];
$day = clone $startDate;

foreach($data['result'][$secondPerDay] as $daily) {
    $result[$day->toDateString()] = $daily[1];
    echo "{$day->toDateString()}\t{$daily[1]}\n";
    $day->addDay();
}
/*
print_r($result);
echo implode("\n", $result);
*/

