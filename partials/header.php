<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$pageTitle = isset($pageTitle) && is_string($pageTitle) ? $pageTitle : 'Plant-Hub';
$active = isset($active) && is_string($active) ? $active : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="plant.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/site.css">
    <style>
        body { font-family: "Raleway", sans-serif; }
    </style>
</head>
<body>
<nav class="fixed inset-x-0 top-0 z-50 bg-white/85 backdrop-blur border-b border-black/5">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <a href="index.php" class="flex items-center gap-3">
                <img class="h-10 w-10 rounded-full ring-2 ring-emerald-600/30" src="plant.png" alt="Plant-Hub" loading="lazy">
                <span class="text-lg font-extrabold tracking-tight text-emerald-900">Plant-Hub</span>
            </a>

            <button id="menu-toggle" class="md:hidden rounded-lg px-3 py-2 text-2xl text-emerald-900 hover:bg-emerald-50" aria-label="Toggle menu">
                ☰
            </button>

            <ul class="hidden md:flex items-center gap-2">
                <li>
                    <a href="index.php#home"
                       class="px-3 py-2 rounded-lg text-sm font-semibold <?php echo $active === 'home' ? 'bg-emerald-100 text-emerald-900' : 'text-gray-700 hover:bg-gray-100'; ?>">
                        Home
                    </a>
                </li>
                <li>
                    <a href="index.php#services"
                       class="px-3 py-2 rounded-lg text-sm font-semibold <?php echo $active === 'services' ? 'bg-emerald-100 text-emerald-900' : 'text-gray-700 hover:bg-gray-100'; ?>">
                        Services
                    </a>
                </li>
                <li>
                    <a href="index.php#garden"
                       class="px-3 py-2 rounded-lg text-sm font-semibold <?php echo $active === 'garden' ? 'bg-emerald-100 text-emerald-900' : 'text-gray-700 hover:bg-gray-100'; ?>">
                        Gardens
                    </a>
                </li>
                <li class="relative group">
                    <button type="button" class="px-3 py-2 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-100">
                        About
                    </button>
                    <div class="absolute hidden group-hover:block right-0 mt-2 min-w-[180px] rounded-xl bg-white shadow-lg border border-black/5 overflow-hidden">
                        <a href="who_we_are.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Who We Are</a>
                        <a href="Developers.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Developers</a>
                        <a href="Contact.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Contact</a>
                    </div>
                </li>

                <?php if (isset($_SESSION['name'])): ?>
                    <li class="relative group ml-2">
                        <button type="button" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2 text-sm font-bold text-white hover:bg-emerald-700">
                            <?php echo htmlspecialchars((string) $_SESSION['name']); ?>
                        </button>
                        <div class="absolute hidden group-hover:block right-0 mt-2 min-w-[180px] rounded-xl bg-white shadow-lg border border-black/5 overflow-hidden">
                            <a href="logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Logout</a>
                        </div>
                    </li>
                <?php else: ?>
                    <li class="ml-2">
                        <a href="login.php" class="rounded-xl bg-emerald-600 px-4 py-2 text-sm font-bold text-white hover:bg-emerald-700">
                            Login
                        </a>
                    </li>
                    <li>
                        <a href="signup.php" class="rounded-xl bg-white px-4 py-2 text-sm font-bold text-emerald-900 ring-1 ring-emerald-300 hover:bg-emerald-50">
                            Sign up
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>

        <div id="mobile-menu" class="hidden md:hidden pb-4">
            <div class="grid gap-2 rounded-xl bg-white/80 backdrop-blur border border-black/5 p-3">
                <a href="index.php#home" class="rounded-lg px-3 py-2 text-sm font-semibold text-gray-800 hover:bg-gray-100">Home</a>
                <a href="index.php#services" class="rounded-lg px-3 py-2 text-sm font-semibold text-gray-800 hover:bg-gray-100">Services</a>
                <a href="index.php#garden" class="rounded-lg px-3 py-2 text-sm font-semibold text-gray-800 hover:bg-gray-100">Gardens</a>
                <a href="who_we_are.php" class="rounded-lg px-3 py-2 text-sm font-semibold text-gray-800 hover:bg-gray-100">Who We Are</a>
                <a href="Developers.php" class="rounded-lg px-3 py-2 text-sm font-semibold text-gray-800 hover:bg-gray-100">Developers</a>
                <a href="Contact.php" class="rounded-lg px-3 py-2 text-sm font-semibold text-gray-800 hover:bg-gray-100">Contact</a>

                <?php if (isset($_SESSION['name'])): ?>
                    <div class="pt-2 border-t border-black/5">
                        <div class="text-sm font-bold text-emerald-900 px-3 py-2"><?php echo htmlspecialchars((string) $_SESSION['name']); ?></div>
                        <a href="logout.php" class="rounded-lg px-3 py-2 text-sm font-semibold text-gray-800 hover:bg-gray-100 block">Logout</a>
                    </div>
                <?php else: ?>
                    <div class="pt-2 border-t border-black/5 grid gap-2">
                        <a href="login.php" class="rounded-lg bg-emerald-600 px-3 py-2 text-sm font-bold text-white text-center hover:bg-emerald-700">Login</a>
                        <a href="signup.php" class="rounded-lg bg-white px-3 py-2 text-sm font-bold text-emerald-900 text-center ring-1 ring-emerald-300 hover:bg-emerald-50">Sign up</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<main class="pt-20">

