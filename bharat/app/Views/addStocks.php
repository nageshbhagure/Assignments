<!DOCTYPE html>
<html lang="en">

<head>
    <title>Seller Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="include/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="include/bootstrap.min.css">
</head>

<body>

    <!-- <div class="p-5 bg-primary text-white text-center">
  <h1>My First Bootstrap 5 Page</h1>
  <p>Resize this responsive page to see the effect!</p> 
</div> -->

    <?php if (!empty($_GET['id'])) {
        $data = 1;
    } else {
        $data = 0;
    }  ?>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="<?php echo base_url('/sellerDashboard'); ?>">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Add Product</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('/logout'); ?>">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h2>Seller Dashboard</h2>
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
        <form action="addStock" method="post" id="product_form" enctype="multipart/form-data">
            <div class="row">
                <div class="col-4 mb-3">
                    <label for="select">Select Products:</label>
                    <select name="pname" id="pname" class="form-control" required>
                        <option value="">Select Product</option>
                        <?php foreach ($products as $row) { //print_r($row);die;
                        ?>
                            <option value="<?php echo $row['id']; ?>" <?php if($data==1 && $_GET['id']==$row['id']){echo"selected";}?>>
                                <?= $row['name'] ?></option>
                        <?php } ?>
                    </select>
                    <span id="err_pname" class="text-danger"></span>
                </div>
            </div>
            <div class="row" id="hidden_qty">
                <div class="col-4 mb-3">
                    <label for="select">
                        <p id="qty"></p>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col-4 mb-3">
                    <label for="qty">Enter Products Quantity:</label>
                    <input type="text" name="quantity" id="quantity" placeholder="Enter Quantity" class="form-control">
                    <span id="err_qty" class="text-danger"></span>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" onclick="return submitButton()">Submit</button>
        </form>
    </div>

    <!-- <div class="mt-5 p-4 bg-dark text-white text-center fixed-bottom">
        <p>Footer</p>
    </div> -->

</body>

</html>
<script src="include/jquery.min.js"></script>
<script src="include/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="include/dataTables.bootstrap5.min.css">
</script>

<script>
    $(document).ready(function() {
        $("#hidden_qty").hide();
        $("#myTable").dataTable({

        });
        setTimeout(function() {
            $('.alert').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 1000); // Adjust the time interval (in milliseconds) as needed
    });

    function submitButton() {
        var is_valid = true;
        var pname = $("#pname").val();
        var quantity = $("#quantity").val();

        if (quantity == "") {
            $("#err_qty").html('Enter Product Quantity');
            is_valid = false;
        } else {
            $("#err_qty").html('');
        }
        if (pname == "") {
            $("#err_pname").html('Select Product');
            is_valid = false;
        } else {
            $("#err_pname").html('');
        }

        if (is_valid == true) {
            $("#product_form").submit();
        } else {
            return false;
        }
    }

    $('#pname').on('change', function() {
        $('#quantity').val('');
        var id = $('#pname').val();
        $.ajax({
            type: "POST",
            url: "get_quantity",
            data: {
                'id': id
            },
            cache: false,
            success: function(data) {
                // console.log(data);return false;
                var parse_data = JSON.parse(data);
                if (parse_data.status == 1) {
                    $("#hidden_qty").show();
                    $("#err_pname").html('');
                    $("#qty").text("Available Quantity : " + parse_data.quantity);
                    return false;
                } else if (parse_data.status == 0) {
                    alert('Record not available');
                    $('#pname').focus();
                    return false;
                } else {
                    alert('Something Serious issue..');
                    return false;
                }
            }
        });
        return false;
    });

    $('#quantity').on('keyup', function() {
        var id = $('#pname').val();
        var quantity = $('#quantity').val();
        if (id == "") {
            $("#err_pname").html('Select Product');
            is_valid = false;
        }

        $.ajax({
            type: "POST",
            url: "get_quantity",
            data: {
                'id': id
            },
            cache: false,
            success: function(data) {
                var parse_data = JSON.parse(data);
                var qty = parseInt(quantity);
                var res_qty = parseInt(parse_data.quantity);
                // console.log(parse_data);return false;
                if (qty > res_qty) {
                    $("#err_qty").html(qty + ' Product not available..');
                    $('#quantity').val('');
                    $('#quantity').focus();
                    return false;
                } else {
                    $("#err_qty").html('');
                    return false;
                }
            }
        });
        return false;
    });
</script>