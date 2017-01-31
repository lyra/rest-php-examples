# Lyra Network REST API code samples

Lyra Network REST API code examples using [our PHP SDK](https://github.com/LyraNetwork/krypton-php-sdk).

## available examples

Available examples are:

| php file                | Description                                   |
|-------------------------|-----------------------------------------------|
| minimalEmbeddedForm.php | Embedded payment form example                 |
| minimalPopInForm.php    | PopIn payment form example                    |
| SDKTest.php             | How to initialize the SDK                     |
| paid.php                | Landing page example if a payment is accepted |
| ipn.php                 | Instant Payment Notification script example   |
| createACardToken.php    | How-to create a card token for later use      |
| chargeAToken.php        | How-to use a card token                       |


## Try it with docker

To run our examples using docker, you first need to install:

* [docker engine](https://docs.docker.com/engine/installation/) 
* and [docker-compose](https://docs.docker.com/compose/install/)

Start the container:

    docker-compose up -d

and go to http://localhost:6980

## Try it using apache

Copy src/ directory content to your PHP server, and go to *index.html* page. 

## Simulate IPN Call

To simulate Instant Payment Notification call with CURL, do:

    curl http://localhost:6980/ipn.php \
        -X POST \
        -H 'Content-type: application/json' \
        -d '{ "orderId": "7d25c5e45cf74198b9f86ad656b3daf3",
            "_type": "V3/Charge/TransactionIPN",
            "shopId": "69876357",
            "transactions": [
                {"id": "5cd1b2538c4b4fb3939ea75310b3210f"}
            ]
            }'

