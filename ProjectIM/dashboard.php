<?php 
    include "includes/header.php";
    $app = "<script src='js/app.register.js'></script>";
?>
<!DOCTYPE html>
<html>
<head>
 <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Admin Table</title>
</head>
<style>
    h2{
        font-size: 2rem;
        margin: 0;
        padding: 0;
        text-align: center;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translateX(-50%);
    }
</style>
<body style="background: lightcyan;">
<?php if($role == 2): ?>
    <div class="d-flex" id="wrapper">
        <!--sidebar starts here-->
        <div class="sidebar" id="sidebar-wrapper" style="background: black;">
            <div class="list-group list-group-flush my-3">
                <a href="dashboard.php"  class="list-group-item list-group-item-action text-dark fw-bold">
                    <i class=" me-2"></i> Dashboard
                </a>
                <a href="UserList.php"   class="list-group-item list-group-item-action text-dark  fw-bold">
                    <i class=" me-2" aria-hidden="true"></i> User Record
                </a>
                <a href="logout.php"   class="list-group-item list-group-item-action text-dark fw-bold" id="btn_logout">
                    <i class="fa-solid  me-2"></i> Log Out
                </a>
            </div>
        </div>
        <div class="text-center">
                            <h2 style="text-align: justify;">Welcome to the Admin Dashboard</h2>
                        </div>
    <!-- <nav class="navbar" style="background: black;">
                            <div class="container">
                                <div class="menu">
                                    <a href="dashboard.php">Dashboard</a>
                                    <a href="UserList.php">User Record</a>
                                </div>
                                <button class="btn btn-danger"><a href="logout.php"   class="list-group-item list-group-item-action  fw-bold" id="btn_logout">
                                        <i class="fa-solid  me-2 "></i> Log Out
                                    </a>
                                    </button>
                            </div>
                        </nav>
                        <div class="text-center">
                            <h2>Welcome to the Admin Dashboard</h2>
                        </div> -->
    <?php endif ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/vue.3.js"></script>
<script src="js/axios.js"></script>
 <script src="js/script.js"></script>
 <?php echo $app; ?>
</body>
</html>
    
