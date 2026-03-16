<?php
$pageTitle = 'Who We Are · Plant-Hub';
$active = '';
require __DIR__ . '/partials/header.php';
?>

<section class="px-4 sm:px-6 lg:px-8 py-10">
    <div class="mx-auto max-w-5xl">
        <div class="rounded-3xl bg-white/80 backdrop-blur border border-black/5 shadow-sm p-8">
            <h1 class="text-4xl sm:text-5xl font-extrabold text-emerald-900 tracking-tight">Who We Are</h1>
            <p class="mt-4 text-lg text-gray-800 leading-relaxed">
                Plant‑Hub is a community garden platform built to help people discover green spaces, learn practical gardening,
                and connect with local organizations.
            </p>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="rounded-2xl bg-white border border-black/5 p-5">
                    <h2 class="text-lg font-extrabold text-gray-900">Community first</h2>
                    <p class="mt-2 text-sm text-gray-700">We help neighbors collaborate, share tips, and grow together.</p>
                </div>
                <div class="rounded-2xl bg-white border border-black/5 p-5">
                    <h2 class="text-lg font-extrabold text-gray-900">Practical support</h2>
                    <p class="mt-2 text-sm text-gray-700">From beginners to experts — simple guidance and clear next steps.</p>
                </div>
                <div class="rounded-2xl bg-white border border-black/5 p-5">
                    <h2 class="text-lg font-extrabold text-gray-900">Sustainable mindset</h2>
                    <p class="mt-2 text-sm text-gray-700">We promote eco-friendly habits and responsible gardening.</p>
                </div>
            </div>

            <div class="mt-8 flex flex-col sm:flex-row gap-3">
                <a href="Contact.php" class="inline-flex justify-center rounded-xl bg-emerald-600 px-5 py-3 text-sm font-bold text-white hover:bg-emerald-700">
                    Join the community
                </a>
                <a href="Developers.php" class="inline-flex justify-center rounded-xl bg-white px-5 py-3 text-sm font-bold text-emerald-900 ring-1 ring-emerald-300 hover:bg-emerald-50">
                    Meet the developers
                </a>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>

