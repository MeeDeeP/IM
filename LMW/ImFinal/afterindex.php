<?php 
session_start();
if(!isset($_SESSION['userid'])){
    header('location:login.php');
}
else if($_SESSION['counterlock'] >= 3){
    /*
    echo '
        <div class="bg-warning" style="width: 300px;">
            <h1>User Account Locked </h1>
            <button>OK</button>
        </div>
    ';*/
    echo '<script>alert("Account Locked")</script>'; 
    echo '<script>window.location.href="login.php"</script>';
    
}
    $app = "<script src='js/app.register.js'></script>";
    $role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
?>
<!DOCTYPE html>
<html>
<head>
 <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./class/css/style.css"> 
    <title>Customer list</title>
</head>
<body style="background: linear-gradient(to right, white, aqua);;">
<?php if($role == 1): ?>
    <nav class="navbar" style="background: black;">
        <div class="container">
            <div class="menu">
                <a href="#register-app">Instructor List</a>
                <a href="./class/Student.php">Create Student</a>
            </div>
            <button class="btn btn-info"><a href="logout.php"   class="list-group-item list-group-item-action  fw-bold" id="btn_logout">
                    <i class="fa-solid  me-2 "></i> Log Out
                </a>
                </button>
        </div>
    </nav>
        <div id="register-app">
  <div class="pt-5 text-center" id="wrapper">
        <div  id="sidebar-wrapper">
            </div>
        </div>
        <div id="page-content-wrapper">
                    <div class="container-fluid row my-5 pt-5 mt-5 text-center" id="user">
                        <div class="input-group rounded row">
                            <b><h3 class="fs-4 mb-3 col text-dark mt-5">List of User</h3></b>
                            <div class="col-12 col-lg-3">  
                                <div class="col mt-2 mb-3">
                                </div>
                            </div>
                        </div>
            <div class="col">
            <table class="table bg-white rounded shadow-sm table-bordered pt-5" style="border:2px solid black;">
               <thead>
        <tr>
            <th>Fullname</th>
            <th>Username</th>
            <th>Email</th>
            <th>Address</th>
            <th>Date Created</th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="user in users">
            <td>{{ user.firstname }}</td>
            <td>{{ user.username }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.address }}</td>
            <td>{{ user.datecreated }} </td>
            <td>
            </td>
        </tr>
    </tbody>
</table>
</div>
    </div>
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
