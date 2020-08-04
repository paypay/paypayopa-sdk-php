<?php
// Set API access
require_once('init_client.php');
header("Content-Type: application/json");
$resp=$client->user->getUserAuthorizationStatus("e0953f5d-b15c-4fd6-af6e-b56736beef36");
echo(json_encode($resp));
