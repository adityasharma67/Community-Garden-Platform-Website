<?php
declare(strict_types=1);
?>
</main>

<!-- Chat widget -->
<section class="ph-chat-window" aria-label="Plant-Hub assistant">
    <div class="ph-chat-topbar">
        <div class="font-bold">Plant‑Hub Assistant</div>
        <button type="button" data-ph-chat-close aria-label="Close chat">Close</button>
    </div>
    <div class="ph-chat-messages" data-ph-chat-messages>
        <div class="ph-chat-bubble ph-chat-bubble--bot">Hi! How can I help you?</div>
    </div>
    <form class="ph-chat-input" data-ph-chat-form data-endpoint="chat.php">
        <input type="text" placeholder="Ask about the site..." data-ph-chat-input>
        <button type="submit" aria-label="Send">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M3 11.5L21 3l-8.5 18-2.6-7.1L3 11.5Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
            </svg>
        </button>
    </form>
</section>

<button type="button" class="ph-chat-button" data-ph-chat-open aria-label="Open chat">
    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
        <path d="M4 5.5A3.5 3.5 0 0 1 7.5 2h9A3.5 3.5 0 0 1 20 5.5v6A3.5 3.5 0 0 1 16.5 15H10l-4.5 4V15A3.5 3.5 0 0 1 4 11.5v-6Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
        <path d="M7.5 7.5h9M7.5 10.5H14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
    </svg>
</button>

<!-- Footer -->
<footer class="mt-14 bg-white/85 backdrop-blur border-t border-black/5">
    <div class="mx-auto max-w-7xl px-6 py-10 grid grid-cols-1 md:grid-cols-3 gap-10">
        <div>
            <a href="index.php" class="flex items-center space-x-3 mb-4">
                <img src="plant.png" alt="Plant-Hub" class="w-10 h-10 rounded-full ring-2 ring-emerald-600/30">
                <span class="text-2xl font-bold text-emerald-800">Plant-Hub</span>
            </a>
            <p class="text-gray-700 text-sm leading-relaxed">
                Your trusted companion in cultivating a green lifestyle. Join our plant-loving community and grow together.
            </p>
        </div>

        <div>
            <h3 class="text-lg font-extrabold text-gray-900 mb-3">Quick Links</h3>
            <ul class="space-y-2 text-sm">
                <li><a href="index.php#home" class="text-gray-700 hover:text-emerald-700">Home</a></li>
                <li><a href="index.php#services" class="text-gray-700 hover:text-emerald-700">Services</a></li>
                <li><a href="index.php#garden" class="text-gray-700 hover:text-emerald-700">Gardens</a></li>
                <li><a href="who_we_are.php" class="text-gray-700 hover:text-emerald-700">Who We Are</a></li>
                <li><a href="Developers.php" class="text-gray-700 hover:text-emerald-700">Developers</a></li>
                <li><a href="Contact.php" class="text-gray-700 hover:text-emerald-700">Contact</a></li>
            </ul>
        </div>

        <div>
            <h3 class="text-lg font-extrabold text-gray-900 mb-3">Connect</h3>
            <div class="flex items-center gap-3">
                <a href="https://www.instagram.com" target="_blank" rel="noreferrer" class="rounded-lg px-3 py-2 bg-white text-gray-700 ring-1 ring-black/5 hover:bg-gray-50">Instagram</a>
                <a href="https://www.facebook.com" target="_blank" rel="noreferrer" class="rounded-lg px-3 py-2 bg-white text-gray-700 ring-1 ring-black/5 hover:bg-gray-50">Facebook</a>
                <a href="https://github.com" target="_blank" rel="noreferrer" class="rounded-lg px-3 py-2 bg-white text-gray-700 ring-1 ring-black/5 hover:bg-gray-50">GitHub</a>
            </div>
        </div>
    </div>
    <div class="bg-white/70 text-center py-4 border-t border-black/5">
        <p class="text-xs text-gray-600">© <?php echo date('Y'); ?> Plant-Hub. All rights reserved.</p>
    </div>
</footer>

<script src="assets/site.js"></script>
</body>
</html>

