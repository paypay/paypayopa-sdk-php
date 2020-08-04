<?php
require_once("init_client.php");
$id = $_GET['id'];
if (!isset($id)) {
    throw new Exception("Invalid id", 1);
}

header("content-type: application/json");
echo json_encode($client->refund->getRefundDetails($id));
