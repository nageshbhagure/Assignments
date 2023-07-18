<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<body>

    <div class="container">
        <h2>Register</h2>
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



        <form action="add" method="post" id="login_form">
            <div class="mb-3 mt-1">
                <label for="username">Usernme:</label>
                <input type="text" class="form-control" id="username" autocomplete="off" placeholder="Enter Username" name="username">
                <span id="err_username" class="text-danger"></span>
            </div>
            <div class="mb-3 mt-1">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" autocomplete="off" placeholder="Enter Password" name="password">
                <span id="err_password" class="text-danger"></span>
            </div>
            <div class="mb-3 mt-1">
                <label for="cpassword">Confirm Password:</label>
                <input type="password" class="form-control" id="cpassword" autocomplete="off" placeholder="Enter Confirm Password" name="cpassword">
                <span id="err_cpassword" class="text-danger"></span>
            </div>
            <div class="mb-3 mt-1">
                <label for="role">Select Role:</label>
                <select name="role" id="role" class="form-control">
                    <option value="1">Manufacturer</option>
                    <option value="2">Seller</option>
                    <option value="3">Customer</option>
                </select>
                <span id="err_role" class="text-danger"></span>
            </div>
            <button type="submit" class="btn btn-primary" onclick="return submitButton()">Submit</button>
            <button type="reset" class="btn btn-danger">Reset</button>
            <input type="hidden" name="id" value="">
            <?php //echo anchor('login', 'Login', array('class' => 'btn btn-info')); 
            ?>
            <a class="btn btn-info" type="button" href="<?php echo base_url('/login'); ?>">Login</a>
        </form>
    </div>

</body>

</html>
<script src="include/jquery.min.js"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script> -->
<script>
    function submitButton() {
        var is_valid = true;
        var username = $("#username").val();
        var password = $("#password").val();
        var cpassword = $("#cpassword").val();
        if (username == "") {
            $("#err_username").html('Enter Username');
            is_valid = false;
        } else {
            $("#err_username").html('');
        }
        if (password == "") {
            $("#err_password").html('Enter password');
            is_valid = false;
        } else {
            $("#err_password").html('');
        }
        if (cpassword == "") {
            $("#err_cpassword").html('Enter confirm password');
            is_valid = false;
        } else if (cpassword != password) {
            $("#err_cpassword").html('Password not matching..');
            is_valid = false;
        } else {
            $("#err_cpassword").html('');
        }

        if (is_valid == true) {
            $("#login_form").submit();
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
<!-- oninput="this.value = this.value.replace(/[^a-zA-Z ]/, '')" -->