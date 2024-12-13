<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://www.paypal.com/sdk/js?client-id=AT_uvoO4QKOFF1EBkddTFP4ASVeYnp9ccdj7N7Q75sg69CmXE1KkYMSMntCjqmryNH3fNIuh5HwcncB-&currency-MXN"></script>

<script>
</head>
<body>
    <div id="paypal-button-container"></div>

    <script>
    paypal.Buttons({
        style:{
            color: 'blue',
            shape: 'pill',
            label: 'pay'

        },
        createOrder: function(data, actions){
            return actions.order.create({
                purcharse_units: [{
                  amount: {
                    value: 100
                  }  
                }]
            })
        },
        onAprove: function(data,actions){
            actions.order.capture().then(function(detalles){
                console.log(detalles);
            });
        },

        onCancel: function(data){
            alert("Pago cancelado");
            console.log(data);
        }
    }).render('#paypal-button-container');
    </script>
</body>
</html>