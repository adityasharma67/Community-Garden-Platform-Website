<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="plant.png" type="image/png">
    <title>Plant-Hub</title>
    <style>
      html {
        scroll-behavior: smooth;
      }
        /* Body background in regular CSS */
        body {
            background: transparent;
            width: 100%;
            height: 100%;
            --color: rgba(114, 114, 114, 0.3);
            background-color: #a9d37c;
            /*background-color: var(--color-gray-500);*/
            background-image: linear-gradient(0deg, transparent 24%, var(--color) 25%, var(--color) 26%, transparent 27%, transparent 74%, var(--color) 75%, var(--color) 76%, transparent 77%, transparent),
                linear-gradient(90deg, transparent 24%, var(--color) 25%, var(--color) 26%, transparent 27%, transparent 74%, var(--color) 75%, var(--color) 76%, transparent 77%, transparent);
            background-size: 55px 55px;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <nav class="fixed w-full bg-gray-100 shadow-md z-50 mb-36">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="index.php">
                        <img class="h-10 w-auto rounded-full" src="https://media.istockphoto.com/id/1045368942/vector/abstract-green-leaf-logo-icon-vector-design-ecology-icon-set-eco-icon.jpg?s=612x612&w=0&k=20&c=XIfHMI8r1G73blCpCBFmLIxCtOLx8qX0O3mZC9csRLs=" alt="Plant Logo" loading="lazy">
                    </a>
                </div>
    
                <!-- Menu Toggle for Mobile -->
                <button id="menu-toggle" class="md:hidden text-2xl focus:outline-none">
                    ☰
                </button>
    
                <!-- Navigation Menu -->
                <ul id="nav-menu" class="hidden md:flex items-center space-x-8">
                    <li><a href="index.php#home" class="text-gray-700 font-medium hover:text-green-500 transition-colors duration-300 px-3 py-2">Home</a></li>
                    <li><a href="index.php#services" class="text-gray-700 font-medium hover:text-green-500 transition-colors duration-300 px-3 py-2">Services</a></li>
                    <li><a href="index.php#garden" class="text-gray-700 font-medium hover:text-green-500 transition-colors duration-300 px-3 py-2">Gardens</a></li>
                    <!-- Dropdown -->
                    <li class="relative group">
                        <a href="" class="text-gray-700 font-medium hover:text-green-500 transition-colors duration-300 px-3 py-2">About Us</a>
                        <div class="absolute hidden group-hover:block bg-white shadow-lg rounded-md mt-2 min-w-[160px]">
                            <a href="who_we_are.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Who We Are</a>
                            <a href="Developers.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">About Developers</a>
                            <a href="Contact.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Contact us</a>
                        </div>
                    </li>
                    <li class="relative group">
                    <?php if (isset($_SESSION['name'])): ?>
                        <a href="#" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition-colors duration-300">
                            <?php echo htmlspecialchars($_SESSION['name']); ?>
                        </a>
                        <div class="absolute hidden group-hover:block bg-white shadow-lg rounded-md mt-2 min-w-[160px]">
                            <!-- <a href="profile.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a> -->
                            <a href="logout.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</a>
                        </div>
                    <?php else: ?>
                        <a href="login.php" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition-colors duration-300">Login</a>
                    <?php endif; ?>
                    </li>
                </ul>
            </div>
    
            <!-- Mobile Menu (hidden by default) -->
            <div id="mobile-menu" class="hidden md:hidden bg-gray-100 shadow-md">
                <ul class="px-2 pt-2 pb-3 space-y-1">
                    <li><a href="index.php#home" class="block text-gray-700 font-medium hover:text-green-500 px-3 py-2">Home</a></li>
                    <li><a href="index.php#services" class="block text-gray-700 font-medium hover:text-green-500 px-3 py-2">Services</a></li>
                    <li><a href="index.php#garden" class="block text-gray-700 font-medium hover:text-green-500 px-3 py-2">Gardens</a></li>
                    <li>
                        <a href="" class="block text-gray-700 font-medium hover:text-green-500 px-3 py-2">About Us</a>
                        <div class="pl-4">
                            <a href="who_we_are.php" class="block text-gray-700 hover:bg-gray-100 px-3 py-2">Who We Are</a>
                            <a href="Developers.php" class="block text-gray-700 hover:bg-gray-100 px-3 py-2">About Developers</a>
                            <a href="Contact.php" class="block text-gray-700 hover:bg-gray-100 px-3 py-2">Contact Us</a>
                        </div>
                    </li>
                    <li class="relative group">
                    <?php if (isset($_SESSION['name'])): ?>
                        <a href="#" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition-colors duration-300">
                            <?php echo htmlspecialchars($_SESSION['name']); ?>
                        </a>
                        <div class="absolute hidden group-hover:block bg-white shadow-lg rounded-md mt-2 min-w-[160px]">
                            <!-- <a href="profile.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a> -->
                            <a href="logout.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</a>
                        </div>
                    <?php else: ?>
                        <a href="login.php" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition-colors duration-300">Login</a>
                    <?php endif; ?>
                </li>
                </ul>
            </div>
    </div>
</nav>
    
    <!-- JavaScript for mobile menu toggle -->
<script>
        document.getElementById('menu-toggle').addEventListener('click', function () {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
</script>

<div class="h-20"></div><!-- To remove the space above the navBar -->

<section class="py-12 px-6">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
      
      <!-- Left side: Developer boxes -->
      <div class="space-y-6">
        <!-- Title Box -->
        <div class="border-8 border-green-700 rounded-3xl p-4 text-center">
          <h1 class="text-4xl font-bold text-green-800">About Developers</h1>
        </div>
  
        <!-- Name + Roles Box -->
        <div class="border-2 border-green-700 rounded-3xl p-6 flex flex-col md:flex-row justify-between">
          <!-- Developer List -->
          <div>
              <h2 class="text-green-900 font-bold text-center">DEVELOPERS</h2>
            <ol class="list-decimal pl-5 space-y-1 text-green-800">
            <!-- Github Url pasting -->
              <li class="text-xl font-medium"><a href="#" class="hover:underline">Harsh</a></li>
              <li class="text-xl font-medium"><a href="#" class="hover:underline">Ankit</a></li>
              <li class="text-xl font-medium"><a href="#" class="hover:underline">Aditya</a></li>
              <li class="text-xl font-medium"><a href="#" class="hover:underline">Areeb Ali</a></li>
            </ol>
          </div>
  
          <!-- Roles -->
          <div class="mt-10 md:mt-0 md:ml-10 space-y-1 text-green-800 p-4">
            <p class="text-xl font-bold">1. PHP, SQL, RestAPI's.</p>
            <p class="text-xl font-bold">2. Designing Using Bootstrap and CSS.</p>
            <p class="text-xl font-bold">3. Logical implementation using JS.</p>
            <p class="text-xl font-bold">4. Chatbot, Deployment and Testing</p>
          </div>
        </div>
      </div>
  
      <!-- Right side: Illustration -->
      <div class="flex justify-center">
        <!-- Replace the below with your actual SVG or image -->
        <img src="png6.png" alt="Developer Illustration" class="w-auto h-auto">
      </div>
  
    </div>

</section>
  

<!-- footer of the WebPage. -->
<footer class="bg-gray-100 mt-12">
    <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-3 gap-10">
      
      <div><!-- logo and description of our website.. -->
        <a href="index.php" class="flex items-center space-x-3 mb-4">
          <img src="https://media.istockphoto.com/id/1045368942/vector/abstract-green-leaf-logo-icon-vector-design-ecology-icon-set-eco-icon.jpg?s=612x612&w=0&k=20&c=XIfHMI8r1G73blCpCBFmLIxCtOLx8qX0O3mZC9csRLs=" alt="Plant-Hub" class="w-10 h-10 rounded-full">
          <span class="text-2xl font-bold text-emerald-700">Plant-Hub</span>
        </a>
        <p class="text-gray-600 text-sm leading-relaxed">
          Your trusted companion in cultivating a green lifestyle 🌱. Join our plant-loving community and grow together.
        </p>
      </div>
  
      <div>
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Quick Links</h3>
        <ul class="space-y-2">
          <li><a href="index.php#home" class="text-gray-600 hover:text-emerald-600 transition">Home</a></li>
          <li><a href="index.php#services" class="text-gray-600 hover:text-emerald-600 transition">Services</a></li>
          <li><a href="index.php#garden" class="text-gray-600 hover:text-emerald-600 transition">Gardens</a></li>
          <li><a href="who_we_are.php" class="text-gray-600 hover:text-emerald-600 transition">Who We Are</a></li>
          <li><a href="Developers.php" class="text-gray-600 hover:text-emerald-600 transition">About Developers</a></li>
          <li><a href="Contact.php" class="text-gray-600 hover:text-emerald-600 transition">Contact Us</a></li>
          <li><a href="login.php" class="text-gray-600 hover:text-emerald-600 transition">Login</a></li>
        </ul>
      </div>
  
      <div>
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Connect With Us</h3>
        <div class="flex space-x-4">
          <a href="https://www.instagram.com" target="_blank" class="text-gray-500 hover:text-pink-500 transition">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
              <path d="M7.75 2C4.022 2 2 4.021 2 7.75v8.5C2 19.979 4.021 22 7.75 22h8.5C19.979 22 22 19.979 22 16.25v-8.5C22 4.021 19.979 2 16.25 2h-8.5zm0 1.5h8.5C18.216 3.5 20.5 5.784 20.5 8.25v7.5c0 2.466-2.284 4.75-4.75 4.75h-8.5C5.784 20.5 3.5 18.216 3.5 15.75v-7.5C3.5 5.784 5.784 3.5 7.75 3.5zm8.25 2a1 1 0 100 2 1 1 0 000-2zM12 7.25a4.75 4.75 0 110 9.5 4.75 4.75 0 010-9.5zm0 1.5a3.25 3.25 0 100 6.5 3.25 3.25 0 000-6.5z"/>
            </svg>
          </a>
          <a href="https://www.facebook.com" target="_blank" class="text-gray-500 hover:text-blue-600 transition">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
              <path d="M13 2.05v3.45h2.4l-.35 2.7H13V12h2.65l-.4 2.7H13v7.25h-3.1V14.7H8.5v-2.7h1.4v-2.2c0-2.1 1.05-3.5 3.6-3.5h2.5z"/>
            </svg>
          </a>
          <a href="https://github.com" target="_blank" class="text-gray-500 hover:text-gray-900 transition">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12 .297a12 12 0 00-3.793 23.4c.6.113.82-.26.82-.577v-2.234c-3.338.726-4.042-1.615-4.042-1.615-.547-1.386-1.336-1.756-1.336-1.756-1.093-.748.083-.733.083-.733 1.21.085 1.847 1.243 1.847 1.243 1.07 1.834 2.807 1.304 3.492.996.108-.775.42-1.304.764-1.604-2.665-.304-5.467-1.333-5.467-5.93 0-1.31.467-2.38 1.235-3.22-.124-.303-.535-1.523.117-3.176 0 0 1.008-.322 3.3 1.23a11.52 11.52 0 016 0c2.29-1.552 3.296-1.23 3.296-1.23.653 1.653.242 2.873.12 3.176.77.84 1.233 1.91 1.233 3.22 0 4.61-2.807 5.624-5.48 5.92.43.37.823 1.102.823 2.222v3.293c0 .32.218.694.825.576A12.003 12.003 0 0012 .297z"/>
            </svg>
          </a>
        </div>
      </div>
    </div>
    <!-- Bottom Bar -->
    <div class="bg-gray-200 text-center py-4">
      <p class="text-sm text-gray-600">&copy; 2025 Plant-Hub. All rights reserved.</p>
    </div>
</footer>
</body>
</html>