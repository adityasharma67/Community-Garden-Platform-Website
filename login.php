<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (isset($_SESSION['name'])) {
    header('Location: index.php');
    exit;
}

$errors = [];
$name = '';

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
