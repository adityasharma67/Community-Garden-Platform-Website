<?php

$login = 0;
$invalid = 0;

// to get the detils of user from form using post method..
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    include 'SignupDatabase.php';

    $name = $_POST['name'];
    $password = $_POST['password'];

    $sql = "Select * from `signup` where
    name = '$name' and password = '$password'";

    $result = mysqli_query($connect, $sql);
    if($result){

        $num = mysqli_num_rows($result);

        if($num > 0){
            // echo 'Welcome Back again. $username ';
            $login = 1;
            //using session to save the details of the user for a specific time in it's browser..
            session_start();
            $_SESSION['name'] = $name;
            header('location:index.php');
        } else{
            // echo 'Invalid! Please sign up first.';
            $invalid = 1;
        }
    }

}

?>    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="plant.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Log-in Form</title>
    <style>

  body{
    background-color: whitesmoke;
  }    
        /* From Uiverse.io by mi-series */ 
  .container {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    text-align: center;
    margin: 100px;
  }
  
  .form_area {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    background-color: #EDDCD9;
    height: auto;
    width: auto;
    border: 2px solid #264143;
    border-radius: 20px;
    box-shadow: 3px 4px 0px 1px #E99F4C;
  }
  
  .title {
    color: #264143;
    font-weight: 900;
    font-size: 1.5em;
    margin-top: 20px;
  }
  
  .sub_title {
    font-weight: 600;
    margin: 5px 0;
  }
  
  .form_group {
    display: flex;
    flex-direction: column;
    align-items: baseline;
    margin: 10px;
  }
  
  .form_style {
    outline: none;
    border: 2px solid #264143;
    box-shadow: 3px 4px 0px 1px #E99F4C;
    width: 290px;
    padding: 12px 10px;
    border-radius: 4px;
    font-size: 15px;
  }
  
  .form_style:focus, .btn:focus {
    transform: translateY(4px);
    box-shadow: 1px 2px 0px 0px #E99F4C;
  }
  
  .btn {
    padding: 15px;
    margin: 25px 0px;
    width: 290px;
    font-size: 15px;
    background: #DE5499;
    border-radius: 10px;
    font-weight: 800;
    box-shadow: 3px 3px 0px 0px #E99F4C;
  }
  
  .btn:hover {
    opacity: .9;
  }
  
  .link {
    font-weight: 800;
    color: #264143;
    padding: 5px;
  }
  .alert,
  .success{
    width: 400px;
    text-align: center;
    position: absolute;
    top: 30px;
    left: 50%;
    transform: translateX(-50%);
    color: whitesmoke;
    padding: 8px 0;
  }

  .alert{background-color: rgb(252, 59, 59);}
  .success{background-color: rgb(44, 158, 24);}
  </style>
</head>
<body>
  <?php 

  if($invalid){
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Invalid!</strong> Seems like You did not have Account.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';

      // redirect after 3 seconds using JS
      echo "<script>
      setTimeout(function(){
          window.location.href = 'index.php';
      }, 3000);
      </script>";
  }

  ?>

  <?php 

  if($login){
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong> You have Logged-In.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
  }
  
  //Import PHPMailer classes into the global namespace

