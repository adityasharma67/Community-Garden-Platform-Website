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
$success = false;
$name = '';

function normalise_text(?string $value): string
{
    $value = trim((string) $value);
    return (string) preg_replace('/\s+/', ' ', $value);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = normalise_text($_POST['name'] ?? '');
    $password = (string) ($_POST['password'] ?? '');
    $confirm = (string) ($_POST['confirm_password'] ?? '');

    if ($name === '' || mb_strlen($name) < 2) {
        $errors[] = 'Name is required (min 2 characters).';
    }
    if (mb_strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters.';
    }
    if ($password !== $confirm) {
        $errors[] = 'Passwords do not match.';
    }

    if (!$errors) {
        try {
            require __DIR__ . '/SignupDatabase.php';

            $lookup = $connect->prepare('SELECT 1 FROM signup WHERE name = ?');
            $lookup->bind_param('s', $name);
            $lookup->execute();
            $res = $lookup->get_result();
            if ($res && $res->num_rows > 0) {
                $errors[] = 'That name is already registered. Please log in.';
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $insert = $connect->prepare('INSERT INTO signup (name, password_hash) VALUES (?, ?)');
                $insert->bind_param('ss', $name, $hash);
                $insert->execute();
                $success = true;

                $_SESSION['name'] = $name;
                header('Location: index.php');
                exit;
            }
        } catch (Throwable $t) {
            error_log('Signup failed: ' . $t->getMessage());
            $errors[] = 'We could not create your account right now. Please try again later.';
        }
    }
}

$pageTitle = 'Sign up · Plant-Hub';
$active = '';
require __DIR__ . '/partials/header.php';
?>

<section class="px-4 sm:px-6 lg:px-8 py-10">
    <div class="mx-auto max-w-md">
        <div class="rounded-3xl bg-white/85 backdrop-blur border border-black/5 shadow-sm p-7">
            <h1 class="text-3xl font-extrabold text-emerald-900">Create your account</h1>
            <p class="mt-2 text-sm text-gray-700">Sign up to access member features and personalize your experience.</p>

            <?php if ($errors): ?>
                <div class="mt-5 rounded-xl bg-yellow-50 border border-yellow-200 p-4 text-sm text-yellow-900">
                    <div class="font-bold">Please fix the following:</div>
                    <ul class="list-disc list-inside mt-2 space-y-1">
                        <?php foreach ($errors as $e): ?>
                            <li><?php echo htmlspecialchars($e); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form class="mt-6 space-y-4" method="post" action="signup.php" autocomplete="on">
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
                           placeholder="At least 8 characters" autocomplete="new-password">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-1" for="confirm_password">Confirm password</label>
                    <input id="confirm_password" name="confirm_password" type="password" required
                           class="w-full rounded-xl border border-black/10 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-400"
                           placeholder="Repeat password" autocomplete="new-password">
                </div>

                <button type="submit"
                        class="w-full rounded-xl bg-emerald-600 px-4 py-3 text-sm font-extrabold text-white hover:bg-emerald-700">
                    Sign up
                </button>
            </form>

            <div class="mt-5 text-sm text-gray-700">
                Already have an account?
                <a class="font-bold text-emerald-800 hover:underline" href="login.php">Log in</a>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>

