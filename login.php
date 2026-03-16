<?php
<<<<<<< HEAD
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (isset($_SESSION['name'])) {
    header('Location: index.php');
    exit;
}
=======
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
>>>>>>> eb56b2034936a46b215a3447d80d9b7f319ad018

$errors = [];
$name = '';

<<<<<<< HEAD
function normalise_text(?string $value): string
{
    $value = trim((string) $value);
    return (string) preg_replace('/\s+/', ' ', $value);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = normalise_text($_POST['name'] ?? '');
    $password = (string) ($_POST['password'] ?? '');

    if ($name === '' || $password === '') {
        $errors[] = 'Name and password are required.';
    } else {
        try {
            require __DIR__ . '/SignupDatabase.php';

            $stmt = $connect->prepare('SELECT name, password_hash FROM signup WHERE name = ?');
            $stmt->bind_param('s', $name);
            $stmt->execute();
            $res = $stmt->get_result();
            $row = $res ? $res->fetch_assoc() : null;

            if (!$row || !isset($row['password_hash']) || !password_verify($password, (string) $row['password_hash'])) {
                $errors[] = 'Invalid credentials.';
            } else {
                $_SESSION['name'] = $name;
                header('Location: index.php');
                exit;
            }
        } catch (Throwable $t) {
            error_log('Login failed: ' . $t->getMessage());
            $errors[] = 'We could not log you in right now. Please try again later.';
        }
    }
}

$pageTitle = 'Login · Plant-Hub';
$active = '';
require __DIR__ . '/partials/header.php';
?>
=======
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
>>>>>>> eb56b2034936a46b215a3447d80d9b7f319ad018

<section class="px-4 sm:px-6 lg:px-8 py-10">
    <div class="mx-auto max-w-md">
        <div class="rounded-3xl bg-white/85 backdrop-blur border border-black/5 shadow-sm p-7">
            <h1 class="text-3xl font-extrabold text-emerald-900">Welcome back</h1>
            <p class="mt-2 text-sm text-gray-700">Log in to your account.</p>

            <?php if ($errors): ?>
                <div class="mt-5 rounded-xl bg-red-50 border border-red-200 p-4 text-sm text-red-900">
                    <div class="font-bold">Login failed</div>
                    <ul class="list-disc list-inside mt-2 space-y-1">
                        <?php foreach ($errors as $e): ?>
                            <li><?php echo htmlspecialchars($e); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form class="mt-6 space-y-4" method="post" action="login.php" autocomplete="on">
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-1" for="name">Name</label>
                    <input id="name" name="name" required value="<?php echo htmlspecialchars($name); ?>"
                           class="w-full rounded-xl border border-black/10 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-400"
                           placeholder="Your name" autocomplete="username">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-1" for="password">Password</label>
                    <input id="password" name="password" type="password" required
                           class="w-full rounded-xl border border-black/10 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-400"
                           placeholder="Your password" autocomplete="current-password">
                </div>

                <button type="submit"
                        class="w-full rounded-xl bg-emerald-600 px-4 py-3 text-sm font-extrabold text-white hover:bg-emerald-700">
                    Login
                </button>
            </form>

            <div class="mt-5 text-sm text-gray-700">
                Don’t have an account?
                <a class="font-bold text-emerald-800 hover:underline" href="signup.php">Sign up</a>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>
