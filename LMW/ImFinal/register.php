<?php 
    $app = "<script src='js/app.register.js'></script>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
       <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
       <link rel="stylesheet" href="./class/css/style1.css">
</head>
<body>  
<div class="registration-form text-center pt-5" >
        <div class="right">
<div id="register-app" class="login-box"  >
    <div class="loginForm">
<form @submit="fnSave($event)" class="reg">
<div class="form-icon">
                <span><i class="bi bi-person"></i></span>
            </div>
            <h2 >Register</h2>
     <div class="form-group">
    <input required type="text" class="form-control item" name="firstname" v-model="firstname" placeholder="First Name"/>
</div>
     <div class="form-group">
    <input required type="text" class="form-control item" name="lastname" v-model="lastname"  placeholder="Last Name"/>
</div>
   <div class="form-group">
    <input required type="text" class="form-control item" name="username" v-model="username" placeholder="UserName" />
</div>
<div class="form-group"> 
    <input required type="password" class="form-control item" name="password"  v-model="password" placeholder="Password"/>
</div>
<div class="form-group">
    <input required type="text" class="form-control item" name="address" v-model="address"  placeholder="Address"/>
</div>
<div class="form-group">
    <input required type="email" class="form-control item" name="email" v-model="email"  placeholder="Email"/>
</div>
  <div class="user-box">
    <input  type="text" name="user_role" v-model="user_role" hidden/>
</div>
        <button type="submit" class="btn btn-block create-account"> Register</button>
        <p class="message">Already registered? <a href="login.php" class="text-primary">Sign In</a></p>
</form>
<div class="social-media">
            <h5>My Account</h5>
            <div class="social-icons">
                <a href="#"><i class="bi bi-facebook" title="Facebook"></i></a>
                <a href="#"><i class="bi bi-google" title="Google"></i></a>
                <a href="#"><i class="bi bi-github" title="Twitter"></i></a>
            </div>
        </div>
</div>
</div>
</div>
<?php include "includes/footer.php"; ?>
    
