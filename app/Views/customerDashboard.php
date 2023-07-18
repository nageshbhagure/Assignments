<!DOCTYPE html>
<html lang="en">

<head>
    <title>Customer Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="include/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="include/bootstrap.min.css">
    <!-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .cart_div {
            float: right;
            font-weight: bold;
            position: relative;
        }

        .cart_div a {
            color: #000;
        }

        .cart_div span {
            font-size: 12px;
            line-height: 14px;
            background: #F68B1E;
            padding: 2px;
            border: 2px solid #fff;
            border-radius: 50%;
            position: absolute;
            top: -1px;
            left: 13px;
            color: #fff;
            width: 20px;
            height: 20px;
            text-align: center;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="<?php echo base_url('/customerDashboard'); ?>">Dashboard</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link disabled" href="#">Add Product</a>
                </li> -->
                <!-- <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('/customerCart'); ?>">Bag</a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('/logout'); ?>">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container flex">
        <?php $session = session(); ?>
        <?php if ($session->getFlashdata('valid_message')) : ?>
            <div class="alert alert-success">
                <?php echo $session->getFlashdata('valid_message'); ?>
            </div>
        <?php endif; ?>

        <?php if ($session->getFlashdata('invalid_error')) : ?>
            <div class="alert alert-danger">
                <?php echo $session->getFlashdata('invalid_error'); ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <?php
            if (!empty($_SESSION["shopping_cart"])) {
                $cart_count = count(array_keys($_SESSION["shopping_cart"]));
            ?>
                <!-- <button type="button" > -->
                <div class="cart_div" data-bs-toggle="modal" data-bs-target="#myModal">
                    <img src="<?php echo base_url() . 'uploads' . DIRECTORY_SEPARATOR . 'cart.png' ?>" height="40" width="40" class="btn btn-sm" />
                    <span><?php echo $cart_count; ?></span>
                </div>
                <!-- </button> -->

            <?php
            }
            ?>

            <div class="card-group">
                <?php foreach ($product as $row) {
                    // $row['prod_name']
                ?>
                    <div class="card">
                        <form method="post" action="<?php echo base_url(); ?>customerBag">
                            <h5 class="card-title"><?= $row->prod_name ?></h5>
                            <img class="card-img-top" width="50px" height="200px" src="<?php echo base_url() . 'uploads\product_img' . DIRECTORY_SEPARATOR . $row->filename; ?>">
                            <div class="card-body">
                                <p class="card-text">Price : <?= $row->prod_price ?></p>
                                <label for="qty">Quantity:</label>
                                <input type="text" style="width: 150px; height: 30px" class="form-control" id="qty_<?= $row->prod_id ?>" autocomplete="off" placeholder="Enter Product Quantity" name="qty" value="1">
                                <input type="hidden" name="prod_id" value="<?= $row->prod_id ?>" id="prod_id_<?= $row->prod_id ?>">
                                <button class="btn btn-primary btn-sm" type="submit">Add to Cart</button></a>
                            </div>
                        </form>
                    </div>
                <?php } ?>
            </div>
        </div>


        <!-- The Modal -->
        <div class="modal fade" id="myModal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Shopping Cart</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        
                            <?php
                            if (isset($_SESSION["shopping_cart"])) {
                                $total_price = 0;
                            ?>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td>ITEM NAME</td>
                                            <td></td>
                                            <td>QUANTITY</td>
                                            <td>UNIT PRICE</td>
                                            <td>ITEMS TOTAL</td>
                                        </tr>
                                        <?php
                                        foreach ($_SESSION["shopping_cart"] as $product) {
                                        ?>
                                            <tr>
                                                <td>
                                                    <img src='<?php echo base_url() . 'uploads\product_img' . DIRECTORY_SEPARATOR . $product['image']; ?>' width="50" height="40" />
                                                </td>
                                                <td><?php echo $product["name"]; ?>
                                                        
                                                </td>
                                                <td><button id="delete_<?=$product["code"]?>"><i class="fa-solid fa-trash"></i></button></td>
                                                <td><?=$product["quantity"]?>
                                                </td>
                                                <td><?php echo "₹" . $product["price"]; ?></td>
                                                <td><?php echo "₹" . $product["price"] * $product["quantity"]; ?></td>
                                            </tr>
                                        <?php
                                            $total_price += ($product["price"] * $product["quantity"]);
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="6" align="right">
                                                <strong>TOTAL: <?php echo "₹" . $total_price; ?></strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            <?php
                            } else {
                                echo "<h3>Your cart is empty!</h3>";
                            }
                            ?>


                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>

        <!-- <div class="mt-5 p-4 bg-dark text-white text-center fixed-bottom">
            <p>Footer</p>
        </div> -->

</body>

</html>

<script src="include/jquery.min.js"></script>
<script src="include/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="include/dataTables.bootstrap5.min.css">
<script>
    // sessionStorage.removeItem('itemName');
    $(document).ready(function() {
        setTimeout(function() {
            $('.alert').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 1000);
    });
    $('input[type=text]').on('keyup', function() {
        // alert('sdf');
        var id = ($(this)[0].id);
        id = id.replace(/[^0-9]/g, '');
        var input_id = "#qty_" + id;
        var quantity = $(input_id).val();
        $.ajax({
            type: "POST",
            url: "get_quantity_stocks",
            data: {
                'id': id
            },
            cache: false,
            success: function(data) {
                var parse_data = JSON.parse(data);
                var qty = parseInt(quantity);
                var res_qty = parseInt(parse_data.quantity);
                if (qty > res_qty) {
                    alert('Only ' + res_qty + ' Product available..');
                    $(input_id).val('');
                    $(input_id).focus();
                    return false;
                } else {
                    $(input_id).focus();
                    return false;
                }
            }
        });
        return false;
    });
</script>