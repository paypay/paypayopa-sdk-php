<?php
require_once('init_client.php');

$resp =  $client->code->deleteQRCode($_GET['id']);

?>
<pre>
    <?= json_encode($resp) ?>
</pre>