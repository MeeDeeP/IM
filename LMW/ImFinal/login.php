<?php 
    $app = "<script src='js/app.login.js'></script>";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="./class/css/style1.css">

</head>
<body>
<div class="registration-form text-center" ><br>
        <div class="right">
     <div class="login-box"  id="login-app">
        <form @submit="fnLogin($event)">
        <div class="form-icon">
                <span><i class="bi bi-person"></i></span>
            </div>
            <h2>Login</h2>
          <div class="form-group">
            <input type="text" name="username" class="form-control item" required="" v-model="username" placeholder="UserName">
            
          </div>
          <div class="form-group">
            <input type="password" name="password" class="form-control item" required="" v-model="password" placeholder="Password">
            
          </div>
         <button class="btn btn-block create-account" type="submit"> Login </button>
          <button class="btn btn-default"> <a href="register.php"> Register
        </a>
         </button>
        </form>
      </div>
      <?php include "includes/footer.php"; ?>