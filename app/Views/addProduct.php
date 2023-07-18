<!DOCTYPE html>
<html lang="en">

<head>
    <title>Manufacturer Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="include/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="include/bootstrap.min.css">
    </style>
</head>

<body>
    <?php
    if (!empty($product_info)) {
        $pdata = 1;
    } else {
        $pdata = '';
    } ?>

    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="<?php echo base_url('/manufacturerDashboard'); ?>">Dashboard</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link disabled" href="#">Add Product</a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('/logout'); ?>">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-3">
        <h4>Add Product</h4>
        <!-- <p>Manufacturer Product List:</p> -->
        <a class="btn btn-info" type="button" href="<?php echo base_url('/manufacturerDashboard'); ?>">Back</a>
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

        <form action="addItem" method="post" id="product_form" enctype="multipart/form-data">
            <div class="row">
                <div class="col-4 mb-3">
                    <label for="name">Product Name:</label>
                    <input type="text" class="form-control" id="pname" autocomplete="off" placeholder="Enter Product Name" name="pname" value="<?php if ($pdata != "") {echo $product_info['name'];} ?>">
                    <span id="err_pname" class="text-danger"></span>
                </div>
                <div class="col-4 mb-3">
                    <label for="code">Product Code:</label>
                    <input type="text" class="form-control" id="pcode" autocomplete="off" placeholder="Enter Product Code" name="pcode" value="<?php if ($pdata != "") {echo $product_info['code'];} ?>">
                    <span id="err_pcode" class="text-danger"></span>
                </div>
                <div class="col-4 mb-3">
                    <label for="price">Product Price:</label>
                    <input type="text" class="form-control" id="price" autocomplete="off" placeholder="Enter Product Price" name="price" value="<?php if ($pdata != "") {echo $product_info['price'];} ?>">
                    <span id="err_price" class="text-danger"></span>
                </div>
                <div class="col-4 mb-3">
                    <label for="gst">Product GST:</label>
                    <input type="text" class="form-control" id="gst" autocomplete="off" placeholder="Enter Product GST" name="gst" value="<?php if ($pdata != "") {echo $product_info['gst'];} ?>">
                    <span id="err_gst" class="text-danger"></span>
                </div>
                <div class="col-4 mb-3">
                <label for="qty">Product Quantity:</label>
                    <input type="text" name="quantity" id="quantity" class="form-control" placeholder="Enter Product Quantity" value="<?php if ($pdata != "") {echo $product_info['quantity'];} ?>">
                    <span id="err_qty" class="text-danger"></span>
                </div>
                <div class="col-4 mb-3">
                <label for="qty">Product Image:</label>
                    <input type="file" name="userfile" id="userfile" class="form-control" placeholder="Upload Product Image" accept="image/jpeg">
                    <span id="err_img" class="text-danger"></span>
                </div>
            </div>


            <input type="hidden" name="id" value="<?php if ($pdata != "") {echo $product_info['id'];} ?>">
            <button type="submit" class="btn btn-primary" onclick="return submitButton()">Submit</button>
            <button type="reset" class="btn btn-danger">Reset</button>
        </form>
        <?php //endforeach;
        ?>
    </div>


    <div class="bg-dark text-white text-center fixed-bottom">
        <p>Footer</p>
    </div>

</body>

</html>

<script src="include/jquery.min.js"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script> -->
<script>
    function submitButton() {
        var is_valid = true;
        var pname = $("#pname").val();
        var pcode = $("#pcode").val();
        var quantity = $("#quantity").val();
        var price = $("#price").val();
        var gst = $("#gst").val();
        var userfile = $("#userfile").val();

        if (userfile == "") {
            $("#err_img").html('Select Product Image');
            is_valid = false;
        } else {
            $("#err_img").html('');
        }

        if (quantity == "") {
            $("#err_qty").html('Enter Product Quantity');
            is_valid = false;
        } else {
            $("#err_qty").html('');
        }

        if (pname == "") {
            $("#err_pname").html('Enter Product Name');
            is_valid = false;
        } else {
            $("#err_pname").html('');
        }

        if (pcode == "") {
            $("#err_pcode").html('Enter Product Code');
            is_valid = false;
        } else {
            $("#err_pcode").html('');
        }

        if (price == "") {
            $("#err_price").html('Enter Product Price');
            is_valid = false;
        } else {
            $("#err_price").html('');
        }

        if (gst == "") {
            $("#err_gst").html('Enter Product GST');
            is_valid = false;
        } else {
            $("#err_gst").html('');
        }

        if (is_valid == true) {
            $("#product_form").submit();
        } else {
            return false;
        }
    }
</script>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('.alert').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 1000); // Adjust the time interval (in milliseconds) as needed
    });
</script>