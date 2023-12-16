<?php 

session_start();

if(!isset($_SESSION['userid'])){
    header('location:login.php');
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
    <title>User list</title>
</head>
<body>
<?php if($role == 2): ?>
        <div id="register-app" style="background: linear-gradient(to right, white, aqua);;">
  <div class="d-flex" id="wrapper">
        <!--sidebar starts here-->
        <div  id="sidebar-wrapper" style="background: black;">
            <div class="list-group list-group-flush my-3">
                <a href="dashboard.php"  class="list-group-item list-group-item-action text-dark fw-bold" style="background: linear-gradient(to right, white, aqua);;">
                    <i class=" me-2"></i> Admin Table
                </a>
                <a href="UserList.php"   class="list-group-item list-group-item-action text-dark  fw-bold" style="background: linear-gradient(to right, white, aqua);;">
                    <i class=" me-2" aria-hidden="true"></i> UserList
                </a>
                <a href="logout.php"   class="list-group-item list-group-item-action text-dark fw-bold" id="btn_logout" style="background: linear-gradient(to right, white, aqua);;">
                    <i class="fa-solid  me-2"></i> Log Out
                </a>
            </div>
        </div>
        <!--sidebar ends here-->
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
            <th>Full Name</th>
            <th>Username</th>
            <th>Email</th>
            <th>Address</th>
            <th>Status</th>
            <th>Role</th>
            <th>Date Created</th>
            <th align="center">Actions</th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="user in users">
            <td>{{ user.firstname + " " + user.lastname }}</td>
            <td>{{ user.username }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.address }}</td>
            <td>{{ user.counterlock >= 3 ? 'Account Locked' : 'Active' }}</td>
            <td>{{ user.user_role == 1 ? 'User' : 'Admin' }}</td>
            <td>{{ user.datecreated }} </td>
            <td>
            <a style="font-size:25px;" class="fas fa-edit text-success float-end mt-1" @click="fnGetUsers(user.userid)"  data-bs-toggle="modal" data-bs-target="#customers"></a>
                <a style="font-size:25px;" class="fa fa-trash text-danger float-end mt-1 me-2" @click="DeleteUser(user.userid)" id="delete"></a> 
                <button v-if="user.counterlock >= 3" class="btn btn-warning" href="#" @click="fnUnlockAccount(user.userid)">Unlock</button>
            </td>
        </tr>
    </tbody>
</table>
</div>
        <!--Update User -->
       <div class="modal fade" tabindex="-1" id="customers">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content p-4s">
                    <div class="modal-header">
                        <h5>Update Customer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4" id="register-app" >
                    <form @submit="fnUpdate($event)" >
                <input required type="text" name="firstname" placeholder="First Name" v-model="firstname"  class="form-control mb-2"/>
                <input required type="text" name="lastname" placeholder="Last Name" v-model="lastname"  class="form-control mb-2"/>
                <input required type="text" name="username" placeholder="Username" v-model="username"  class="form-control mb-2"/>
                <input required type="text" name="address" placeholder="Address" v-model="address" class="form-control mb-2"/>
                <input required type="email" name="email" placeholder="Email" v-model="email"  class="form-control mb-2"/>
                <input required type="text" name="user_role" placeholder="Address" v-model="user_role" class="form-control mb-2"/>
                <input required type="text" name="counterlock" placeholder="Counterlock" v-model="counterlock" class="form-control mb-2"/>
                <input type="password" name="password" placeholder="Password" v-model="password" class="form-control mb-2" hidden/>
                      <button  type="submit" class="btn btn-outline-success float-end mt-3" id="update"  >Update</button>
                      <button type="button" class="btn btn-outline-info float-end mt-3 me-2" data-bs-dismiss="modal">Cancel</button>
            </form>
                    </div>
                    
                  </div>
                </div>
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

       