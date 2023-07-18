<!DOCTYPE html>
<html lang="en">

<head>
    <title>Manufacturer Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script> -->
    <script src="include/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="include/bootstrap.min.css">
    
</head>

<body>

    <!-- <div class="p-5 bg-primary text-white text-center">
  <h1>My First Bootstrap 5 Page</h1>
  <p>Resize this responsive page to see the effect!</p> 
</div> -->

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
        <h2>Product List</h2>
        <p>Manufacturer Product List:</p>
        <a class="btn btn-info" type="button" href="<?php echo base_url('/addProduct'); ?>">Add</a>
        <table class="table table-hover" id="myTable">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Product code</th>
                    <th>Price</th>
                    <th>GST</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($product as $row) { ?>
                    <tr>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['code'] ?></td>
                        <td><?= $row['price'] ?></td>
                        <td><?= $row['gst'] ?></td>
                        <td class="justify-content-center">
                            <a href="addProduct?id=<?= $row['id'] ?>" class="btn btn-info btn-sm">Edit</a>
                            <a href="deleteItem/<?= $row['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>


    <div class="mt-5 p-4 bg-dark text-white text-center fixed-bottom">
        <p>Footer</p>
    </div>

</body>

</html>
<script src="include/jquery.min.js"></script>
<script src="include/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="include/dataTables.bootstrap5.min.css">
<script>
    $(document).ready(function() {
        $("#myTable").dataTable({});
        setTimeout(function() {
            $('.alert').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 1000); // Adjust the time interval (in milliseconds) as needed
    });
</script>