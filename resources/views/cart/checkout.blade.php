<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="og:Barla" property="og:Barla Shop" content="Barla hediyelik eşya satış ve inceleme web uygulaması">
    <meta name="description" content="Barla Hediyelik">
    <meta name="description" content="Barla">
    <meta name="description" content="Barla Shop">
    <meta name="description" content="Barla Tasrım">
    <meta name="description" content="Tasarım ve Hediye">
    <meta name="description" content="Tasarım">
    <meta name="description" content="Tasarım Seçme Çanta Ve Hediyelik Eşya">
    <meta name="robots" content="index, follow">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barla Design</title>
    <link rel="icon" href="https://dmih5ui1qqea9.cloudfront.net/logo_234/Barlatasarim5017_IMG_20210508_003307_059.jpg" type="image/x-icon" />

    <!-- <link rel="stylesheet" href="style.css"> -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap');

        body {
            text-align: center;
            font-family: 'Bebas Neue', cursive;
            /* background: linear-gradient(180deg, rgb(115, 175, 214) 10%, rgb(236, 149, 222) 100%);*/
            background-color: rgb(255, 180, 226);

        }

        #navigation {
            margin-bottom: 24px;
        }

        #navigation .link {
            padding: 24px;
        }

        #navigation .link:hover {
            background-color: rgb(255, 174, 0);
            color: rgb(255, 255, 255);
            cursor: pointer;
            box-shadow: rgb(226, 20, 20) 3px 3px 3px;
        }

        .urun img {
            width: 80%;
            max-width: 240px;
        }

        h1 {
            text-shadow: rgb(255, 255, 255) 3px 3px 3px;
        }
    </style>

</head>

<body>
<div id="smart-button-container">
      <div style="text-align: center;">
        <div id="paypal-button-container"></div>
      </div>
    </div>
    <script src="https://www.paypal.com/sdk/js?client-id=sb&enable-funding=venmo&currency=USD" data-sdk-integration-source="button-factory"></script>
  <script>
    function initPayPalButton() {
      paypal.Buttons({
        style: {
          shape: 'rect',
          color: 'gold',
          layout: 'vertical',
          label: 'paypal',
          
        },

        createOrder: function(data, actions) {
          return actions.order.create({
            purchase_units: [{"description":"Wayak Template","amount":{"currency_code":"USD","value":2}}]
          });
        },

        onApprove: function(data, actions) {
          return actions.order.capture().then(function(orderData) {
            
            // Full available details
            console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));

            // Show a success message within this page, e.g.
            const element = document.getElementById('paypal-button-container');
            element.innerHTML = '';
            element.innerHTML = '<h3>Thank you for your payment!</h3>';

            // Or go to another URL:  actions.redirect('thank_you.html');
            
          });
        },

        onError: function(err) {
          console.log(err);
        }
      }).render('#paypal-button-container');
    }
    initPayPalButton();
  </script>
</body>

</html>