<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
    <script src="include/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="include/bootstrap.min.css">
</head>

<body>

    <div class="container">
        <h2>Login</h2>
        <?php $session = session(); ?>
        <?php if ($session->getFlashdata('invalid_error')) : ?>
            <div class="alert alert-danger">
                <?php echo $session->getFlashdata('invalid_error'); ?>
            </div>
        <?php endif; ?>
        <form action="action" method="post">
            <div class="mb-3 mt-1">
                <label for="username">Usernme:</label>
                <input type="text" class="form-control" id="username" placeholder="Enter Username" name="username" minlength="8" maxlength="20">
                <span class="text-danger" id="err_username"></span>
            </div>
            <div class="mb-3 mt-1">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" placeholder="Enter Password" name="password" minlength="8" maxlength="20">
                <span class="text-danger" id="err_password"></span>
            </div>
            <button type="submit" id='submit' class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-danger">Reset</button>
            <a class="btn btn-info" type="button" href="<?php echo base_url('/register'); ?>">Register</a>

        </form>
    </div>

</body>
<!-- oninput="this.value = this.value.replace(/[^a-zA-Z ]/, '')" -->

</html>

<script src="include/jquery.min.js"></script>
<script>
    $('#username').on('keyup', function() {
        var regex = /[^a-zA-Z0-9]/;
        var username = $("#username").val();
        var result = !username.match(regex);
        if(result){
            $("#err_username").text('');
        }else{            
            this.value = this.value.replace(/[^a-zA-Z0-9]/,'');
            $("#err_username").text('Username should be alphabets and numbers only.');
            return false;
        }
    });

    $('#submit').on('click', function() {
        var is_valid = true;
        var username = $("#username").val();
        var password = $("#password").val();
        if(username==""){
            $("#username").focus();
            $("#err_username").text('Enter Username');
            is_valid=false;
            // return false;
        }else{
            is_valid=true;
        }
        if(password==""){
            $("#password").focus();
            $("#err_password").text('Enter password');
            is_valid=false;
            // return false;
        }else{
            is_valid=true;
        }

        if(is_valid==true){
            return true;
        }else{
            return false;
        }
    });
</script>