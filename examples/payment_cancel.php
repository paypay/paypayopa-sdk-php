<?php
require_once('init_client.php');
$resp =  $client->payment->cancelPayment($_GET['id']);
header("content-type: application/json");
echo json_encode($resp);
