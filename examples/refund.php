<?php
require_once("init_client.php");
$id = $_GET['id'];
if (!isset($id)) {
    throw new Exception("Invalid id", 1);
}
$payload = new PayPay\OpenPaymentAPI\Models\Payload();
$payload->set_merchant_refund_id(uniqid());
$payload->set_merchant_payment_id($id);
$amount = [
    "amount" => 1,
    "currency" => "JPY"
];
$payload->set_amount($amount);
$payload->set_requested_at();
$payload->set_reason("Refunds test");
$resp = $client->refund->refundPayment($payload);
$data = $resp['data'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processing Refunds</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</head>

<body>
    <?= json_encode($resp); ?>
    <a target="_blank" href="refund-details.php?id=<?= $data['merchantRefundId'] ?>&pid=<?= $data['paymentId'] ?>" class="btn btn-info">Refund Details </a>

</body>

</html>