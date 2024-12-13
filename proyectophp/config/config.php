<?php
define("CLIENT_ID", "AT_uvoO4QKOFF1EBkddTFP4ASVeYnp9ccdj7N7Q75sg69CmXE1KkYMSMntCjqmryNH3fNIuh5HwcncB-");
define("KEY_TOKEN", "APR.wqc-354*");
define("CURRENCY", "MXN");
define("MONEDA", "$");

session_start();

$num_cart = 0;
if(isset($_SESSION['carrito']['productos'])){
    $num_cart = count($_SESSION['carrito']['productos']);
}
?>
