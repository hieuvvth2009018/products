<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>
<style>
    body{
        background: #00F7FFFF;
    }
</style>
<body>
<div class="container">
    <h2>Product</h2>
    @if(session('message'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Success!</strong>{{session('message')}}
        </div>
    @endif
    @if(session('remove'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Success!</strong>{{session('remove')}}
        </div>
    @endif
    <table class="table table-dark table-hover">
        <thead>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Thumbnail</th>
            <th>Quantity</th>
            <th>Subtotal</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @if($shoppingCart == null)
            Vui Lòng Thêm Mới Sản Phẩm
        @else
            <?php
            $totalPrice=0
            ?>
            @foreach($shoppingCart as $obj)
                <?php
                if (!empty($obj)){
                    $totalPrice += $obj->unitPrice*$obj->quantity;
                }
                ?>
                <form action="/add" method="get">
                    <input type="hidden" name="cartAction" value="update">
                    <input type="hidden" name="productId" value="{{$obj->id}}">
                    <tr>
                        <td>{{$obj->name}}</td>
                        <td>{{$obj->unitPrice}}</td>
                        <td>
                            <img width="100px" src="{{$obj->thumbnail}}">
                        </td>
                        <td><input type="number" min="1" name="productQuantity" value="{{$obj->quantity}}"></td>
                        <td>{{$obj->quantity*$obj->unitPrice}}</td>
                        <td>
                            <button class="btn btn-primary">Update</button>
                            <a href="/remove??productId={{$obj->id}}" class="btn btn-danger">Remove</a>
                        </td>
                    </tr>
                </form>
            @endforeach

        @endif
        </tbody>
    </table>
    <div>
        Total Price:{{$totalPrice}}
    </div>
    <div class="row mt-5 justify-content-end">
        <form class="col-6" action="/save" method="post">
            @csrf
            <div class="col-12 form-group">
                <input class="form-control" type="text" name="shipName" placeholder="Enter Name">
            </div>
            <div class="col-12 form-group">
                <input class="form-control" type="text" name="shipPhone" placeholder="Enter Phone">
            </div>
            <div class="col-12 form-group">
                <input class="form-control" type="text" name="shipAddress" placeholder="Enter Address">
            </div>
            <div class="col-12 form-group">
                <input class="form-control" type="text" name="note" placeholder="Enter Note">
            </div>
            <div class="form-group text-center">
                <button class=" btn btn-primary">Submit</button>
                <div id="paypal-button"></div>
            </div>
        </form>
    </div>
</div>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
    paypal.Button.render({
        // Configure environment
        env: 'sandbox',
        client: {
            sandbox: 'AatYcUleB7r9YYiyXrVRMF1KmHK8_fT9rIzBt4KH5tcDG3JBenBGsynaIST_-B__kuUawAaSADKxFBnw',
            production: 'demo_production_client_id'
        },
        // Customize button (optional)
        locale: 'en_US',
        style: {
            size: 'medium',
            color: 'gold',
            shape: 'pill',
        },

        // Enable Pay Now checkout flow (optional)
        commit: true,

        // Set up a payment
        payment: function(data, actions) {
            return actions.payment.create({
                transactions: [{
                    amount: {
                        total: '30.11',
                        currency: 'USD',
                        details: {
                            subtotal: '30.00',
                            tax: '0.07',
                            shipping: '0.03',
                            handling_fee: '1.00',
                            shipping_discount: '-1.00',
                            insurance: '0.01'
                        }
                    },
                    description: 'The payment transaction description.',
                    custom: '90048630024435',
                    //invoice_number: '12345', Insert a unique invoice number
                    payment_options: {
                        allowed_payment_method: 'INSTANT_FUNDING_SOURCE'
                    },
                    soft_descriptor: 'ECHI5786786',
                    item_list: {
                        items: [
                            {
                                name: 'hat',
                                description: 'Brown hat.',
                                quantity: '5',
                                price: '3',
                                tax: '0.01',
                                sku: '1',
                                currency: 'USD'
                            },
                            {
                                name: 'handbag',
                                description: 'Black handbag.',
                                quantity: '1',
                                price: '15',
                                tax: '0.02',
                                sku: 'product34',
                                currency: 'USD'
                            }],
                        shipping_address: {
                            recipient_name: 'Brian Robinson',
                            line1: '4th Floor',
                            line2: 'Unit #34',
                            city: 'San Jose',
                            country_code: 'US',
                            postal_code: '95131',
                            phone: '011862212345678',
                            state: 'CA'
                        }
                    }
                }],
                note_to_payer: 'Contact us for any questions on your order.'
            });
        },
        // Execute the payment
        onAuthorize: function(data, actions) {
            return actions.payment.execute().then(function() {
                // Show a confirmation message to the buyer
                window.alert('Thank you for your purchase!');
            });
        }
    }, '#paypal-button');

</script>
</body>
</html>

