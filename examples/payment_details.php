<?php
require_once('init_client.php');
$id=$_GET['id'];
if (!isset($id)) {
    throw new Exception("Invalid id", 1);
}
$resp =  $client->payment->getPaymentDetails($id);
$data = $resp['data'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</head>

<body>

    <h1>Data</h1>
    <pre>
<code>
<?= json_encode($data) ?>
</code>
</pre>
    <button type="button" class="btn btn-danger">Cancel Payment</button>
    <h5>Authorized payments </h5>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">¥</span>
        </div>
        <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
        <div class="input-group-append">
            <a target="_blank" class="btn btn-primary">Capture Payment Authorization</a>
        </div>
    </div>
    <div class="btn-group" role="group" aria-label="Basic example">

        <a target="_blank" class="btn btn-warning">Revert Payment Authorization </a>
    </div>
    <h5>Refunds</h5>
    <div class="btn-group" role="group" aria-label="Basic example">
        <a target="_blank" href="refund.php?id=<?=$id?>" class="btn btn-warning">Refund Payment</a>        
    </div>
</body>

</html>