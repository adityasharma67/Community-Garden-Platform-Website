<?php
session_start();

$login = 0;
$invalid = 0;

// handle POST login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    include 'SignupDatabase.php';
  } catch (Throwable $t) {
    // if DB bootstrap fails we surface a generic error
    error_log('DB bootstrap failed: ' . $t->getMessage());
    $invalid = 1;
  }

  $name = trim((string)($_POST['name'] ?? ''));
  $password = (string)($_POST['password'] ?? '');

  if ($name === '' || $password === '') {
    $invalid = 1;
  } elseif (isset($connect)) {
    // use prepared statements for safety
    $stmt = $connect->prepare('SELECT id, name FROM `signup` WHERE name = ? AND password = ?');
    if ($stmt) {
      $stmt->bind_param('ss', $name, $password);
      $stmt->execute();
      // use store_result for compatibility when get_result() is unavailable
      $stmt->store_result();

      if ($stmt->num_rows > 0) {
        $login = 1;
        $_SESSION['name'] = $name;
        header('Location: index.php');
        exit();
      } else {
        $invalid = 1;
      }

      $stmt->close();
    } else {
      error_log('Failed to prepare login statement: ' . $connect->error);
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

  if ($invalid) {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Invalid!</strong> Username or password are incorrect.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
  }

  if ($login) {
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong> You have Logged-In.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
  }
  ?>

  <!-- Login form -->
  <div class="container">
    <div class="form_area p-6">
      <h2 class="title">Welcome back</h2>
      <p class="sub_title">Sign in to your account</p>
      <form action="login.php" method="post" class="d-flex flex-column align-items-center">
        <div class="form_group">
          <input type="text" name="name" placeholder="Username" required class="form_style" value="<?php echo htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES); ?>">
        </div>
        <div class="form_group">
          <input type="password" name="password" placeholder="Password" required class="form_style">
        </div>
        <button type="submit" class="btn">Log In</button>
        <div class="mb-4">Don't have an account? <a class="link" href="index.php">Sign up</a></div>
      </form>
    </div>
  </div>
  </body>
  </html>

