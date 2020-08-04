<?php
// Set API access

use PayPay\OpenPaymentAPI\Models\CreateQrCodePayload;
use PayPay\OpenPaymentAPI\Models\OrderItem;

require_once('init_client.php');


$CQCPayload = new CreateQrCodePayload();
$OrderItems = [];
$OrderItems[] = (new OrderItem())
    ->setName('Cake')
    ->setQuantity(1)
    ->setUnitPrice(['amount' => 20, 'currency' => 'JPY']);
$CQCPayload
->setMerchantPaymentId('Test123')
->setAmount(['amount' => 20, 'currency' => 'JPY'])->setCodeType()->setOrderItems($OrderItems);

// Get data for QR code
$resp = $client->code->createQRCode($CQCPayload);
$data = $resp['data'];
if ($resp["resultInfo"]["code"] != 'SUCCESS') {
    die(var_dump($resp["resultInfo"]));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Creation</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <h1> Order Created</h1>
                <!--<textarea name="" id="" cols="30" rows="10">
                    <?= json_encode($resp) ?>
                </textarea>-->
                <iframe src="<?= $data['url'] ?>" width="100%" height="1024px" frameborder="0"></iframe>

            </div>
            <div class="col-md-4 ">
                <h2>Order Details</h2>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    QR Code expires at<strong> <?= date("Y-m-d H:i:s", substr($data['expiryDate'], 0, 10)) ?></strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Category</th>
                            <th scope="col">Product Id</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($CQCPayload->getOrderItems() as $index => $item) : ?>
                            <tr>
                                <th scope="row"><?= $index + 1 ?></th>
                                <td><?= $item['name'] ?></td>
                                <td><?= $item['category'] ?></td>
                                <td><?= $item['productId'] ?></td>
                                <td><?= $item['quantity'] ?></td>
                                <td><?= $item['unitPrice']['amount'] ?> <?= $item['unitPrice']['amount'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td>
                                <a target="_blank" href="delete_qr.php?id=<?= $data["codeId"] ?>" class="btn btn-danger">Delete QR</a>
                            </td>
                            <td>
                                <a target="_blank" href="payment_details.php?id=<?= $data["merchantPaymentId"] ?>" class="btn btn-info">Payment Details</a>
                            </td>
                            <td>
                                <a target="_blank" href="payment_cancel.php?id=<?= $data["codeId"] ?>" class="btn btn-danger">Cancel Payment</a>
                            </td>
                            <td>

                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>