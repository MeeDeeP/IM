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
    <title>Admin Table</title>
</head>
<style>
</style>
<body style="background: linear-gradient(to right, white, aqua);;">
<?php if($role == 2): ?>
 <div class="d-flex" id="wrapper" >
        <div id="sidebar-wrapper" style="background: black;">
            <div class="list-group list-group-flush my-3">
                <a href="dashboard.php"  class="list-group-item list-group-item-action  text-dark " style="background: linear-gradient(to right, white, aqua);;">
                    <i class=" me-2"></i>Admin Table
                </a>
                <a href="UserList.php"   class="list-group-item list-group-item-action  text-dark  fw-bold" style="background: linear-gradient(to right, white, aqua);;">
                    <i class=" me-2" aria-hidden="true"></i> UserList
                </a>
                <a href="logout.php"   class="list-group-item list-group-item-action text-dark fw-bold" id="btn_logout" style="background: linear-gradient(to right, white, aqua);;">
                    <i class=" me-2"></i> Log Out
                </a>
            </div>
        </div>
    </div> 
    <?php endif ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/vue.3.js"></script>
<script src="js/axios.js"></script>
 <script src="js/script.js"></script>
 <?php echo $app; ?>
</body>
</html>
    
