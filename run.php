#!/usr/bin/env php
<?php
declare(strict_types=1);

storeOrder(1, '2021-07-29 18:00:00', 800, 1, 600, 1);

function storeOrder(
    int $event_id,
    string $event_date,
    int $ticket_adult_price,
    int $ticket_adult_quantity,
    int $ticket_kid_price,
    int $ticket_kid_quantity
) {
    $needToGo = true;

    $i = 1;
    while ($needToGo) {
        echo 'Step 1: Generate barcode' . PHP_EOL;
        $barcode = getBarcode();
        echo 'Result: ' . $barcode . PHP_EOL . PHP_EOL;

        echo 'Step 2: Make first API request #' . $i . PHP_EOL;
        $responseFirst = makeApiRequestFirstStep(
            $event_id,
            $event_date,
            $ticket_adult_price,
            $ticket_adult_quantity,
            $ticket_kid_price,
            $ticket_kid_quantity
        );
        echo 'Result: ' . $responseFirst . PHP_EOL . PHP_EOL;

        $responseFirstArray = json_decode($responseFirst, true);
        $needToGo = key_exists('error', $responseFirstArray);

        $i++;
    }

    echo 'Step 3: Make second API request' . PHP_EOL;
    $responseSecond = makeApiRequestSecondStep($barcode);
    echo 'Result: ' . $responseSecond . PHP_EOL . PHP_EOL;

    $responseSecondArray = json_decode($responseSecond, true);

    echo 'Step 4: Store an order' . PHP_EOL;
    if (key_exists('message', $responseSecondArray)) {
        echo 'Result: Order stored successfully with barcode: ' . $barcode . PHP_EOL;

        exit();
    }

    echo 'Result: Order not stored with error: ' . $responseSecondArray['error'] . PHP_EOL;
}


function getBarcode(): string
{
    return sprintf("%08s", rand(0, 99999999));
}

function makeApiRequestFirstStep(
    int $event_id,
    string $event_date,
    int $ticket_adult_price,
    int $ticket_adult_quantity,
    int $ticket_kid_price,
    int $ticket_kid_quantity
): string {
//    $query = http_build_query([
//        'event_id' => $event_id,
//        'event_date' => $event_date,
//        'ticket_adult_price' => $ticket_adult_price,
//        'ticket_adult_quantity' => $ticket_adult_quantity,
//        'ticket_kid_price' => $ticket_kid_price,
//        'ticket_kid_quantity' => $ticket_kid_quantity,
//    ]);
//   return file_get_contents('https://api.site.com/book?' . $query);

    $responses = [
        ['message' => 'order successfully booked'],
        ['error' => 'barcode already exists'],
    ];

    return json_encode($responses[rand(0, count($responses) - 1)]);
}

function makeApiRequestSecondStep(string $barcode): string
{
//    $query = http_build_query([
//        'barcode' => $barcode,
//    ]);
//    return file_get_contents('https://api.site.com/approve?' . $query);

    $responses = [
        ['message' => 'order successfully approved'],
        ['error' => 'event cancelled'],
        ['error' => 'no tickets'],
        ['error' => 'no seats'],
        ['error' => 'fan removed'],
    ];

    return json_encode($responses[rand(0, count($responses) - 1)]);
}