<?php
session_start();

// Import PHPMailer classes .. 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$success = 0;
$user = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'SignupDatabase.php';

    $orgname = $_POST['orgname'];
    $location = $_POST['location'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    // Sanitize inputs to prevent SQL injection
    $orgname = mysqli_real_escape_string($connect, $orgname);
    $location = mysqli_real_escape_string($connect, $location);
    $email = mysqli_real_escape_string($connect, $email);
    $phone = mysqli_real_escape_string($connect, $phone);
    $message = mysqli_real_escape_string($connect, $message);

    // Check if organization already exists
    $sql = "SELECT * FROM `organization` WHERE orgname = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("s", $orgname);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $num = $result->num_rows;

        if ($num > 0) {
            $user = 1;
        } else {
            // Insert new organization
            $sql = "INSERT INTO `organization` (orgname, location, email, phone, message) VALUES (?, ?, ?, ?, ?)";
            $stmt = $connect->prepare($sql);
            $stmt->bind_param("sssss", $orgname, $location, $email, $phone, $message);
            $result = $stmt->execute();

            if ($result) {
                $success = 1;

                // Send confirmation email using PHPMailer
                require 'PHPMailer/Exception.php';
                require 'PHPMailer/PHPMailer.php';
                require 'PHPMailer/SMTP.php';

                $mail = new PHPMailer(true);

                try {
                    // Server settings
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'harv280905@gmail.com';
                    $mail->Password = 'qdaj lxah bmne wjpe';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port = 465;

                    // Recipients
                    $mail->setFrom('harv280905@gmail.com', 'Plant-Hub');
                    $mail->addAddress($email, $orgname);

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Welcome to Plant-Hub Partnership';
                    $mail->Body = "
                        <h2>Dear $orgname,</h2>
                        <p>Thank you for your interest in partnering with Plant-Hub, your trusted companion in cultivating a green lifestyle.</p>
                        <p>We have successfully received your application to join our community. Below are the details you submitted:</p>
                        <ul>
                            <li><strong>Organization Name:</strong> $orgname</li>
                            <li><strong>Location:</strong> $location</li>
                            <li><strong>Email:</strong> $email</li>
                            <li><strong>Phone:</strong> $phone</li>
                            <li><strong>Message:</strong> $message</li>
                        </ul>
                        <p>Our team will review your application and reach out to you soon to discuss the next steps in our partnership journey.</p>
                        <p>Should you have any questions in the meantime, please feel free to contact us at <a href='mailto:support@planthub.com'>support@planthub.com</a>.</p>
                        <p>Thank you for choosing to grow with us!</p>
                        <p>Best regards,<br>The Plant-Hub Team</p>
                    ";

                    $mail->send();
                } catch (Exception $e) {
                    // Log error instead of displaying to user
                    error_log("Failed to send email: " . $mail->ErrorInfo);
                }
            } else {
                die(mysqli_error($connect));
            }
        }
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="plant.png" type="image/png">
    <title>Contact - Plant-Hub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html {
            scroll-behavior: smooth;
        }
        body {
            background: transparent;
            width: 100%;
            height: 100%;
            --color: rgba(114, 114, 114, 0.3);
            background-color: #a9d37c;
            background-image: linear-gradient(0deg, transparent 24%, var(--color) 25%, var(--color) 26%, transparent 27%, transparent 74%, var(--color) 75%, var(--color) 76%, transparent 77%, transparent),
                linear-gradient(90deg, transparent 24%, var(--color) 25%, var(--color) 26%, transparent 27%, transparent 74%, var(--color) 75%, var(--color) 76%, transparent 77%, transparent);
            background-size: 55px 55px;
            margin: 0;
            padding: 0;
            font-family: "Raleway", sans-serif;
        }
        /* Custom Alert Box Styling */
        .custom-alert {
            transition: opacity 0.5s ease-in-out;
        }
        .custom-alert.hidden {
            opacity: 0;
            display: none;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="fixed w-full bg-gray-100 shadow-md z-50">
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
                        <a href="#" class="text-gray-700 font-medium hover:text-green-500 transition-colors duration-300 px-3 py-2">About Us</a>
                        <div class="absolute hidden group-hover:block bg-white shadow-lg rounded-md mt-2 min-w-[160px]">
                            <a href="who_we_are.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Who We Are</a>
                            <a href="Developers.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">About Developers</a>
                            <a href="Contact.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Contact Us</a>
                        </div>
                    </li>
                    <!-- User-specific Menu -->
                    <li class="relative group">
                        <?php if (isset($_SESSION['name'])): ?>
                            <a href="#" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition-colors duration-300">
                                <?php echo htmlspecialchars($_SESSION['name']); ?>
                            </a>
                            <div class="absolute hidden group-hover:block bg-white shadow-lg rounded-md mt-2 min-w-[160px]">
                                <a href="logout.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</a>
                            </div>
                        <?php else: ?>
                            <a href="login.php" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition-colors duration-300">Login</a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden bg-gray-100 shadow-md">
                <ul class="px-2 pt-2 pb-3 space-y-1">
                    <li><a href="index.php#home" class="block text-gray-700 font-medium hover:text-green-500 px-3 py-2">Home</a></li>
                    <li><a href="index.php#services" class="block text-gray-700 font-medium hover:text-green-500 px-3 py-2">Services</a></li>
                    <li><a href="index.php#garden" class="block text-gray-700 font-medium hover:text-green-500 px-3 py-2">Gardens</a></li>
                    <li>
                        <a href="#" class="block text-gray-700 font-medium hover:text-green-500 px-3 py-2">About Us</a>
                        <div class="pl-4">
                            <a href="who_we_are.php" class="block text-gray-700 hover:bg-gray-100 px-3 py-2">Who We Are</a>
                            <a href="Developers.php" class="block text-gray-700 hover:bg-gray-100 px-3 py-2">About Developers</a>
                            <a href="Contact.php" class="block text-gray-700 hover:bg-gray-100 px-3 py-2">Contact Us</a>
                        </div>
                    </li>
                    <li class="relative group">
                        <?php if (isset($_SESSION['name'])): ?>
                            <a href="#" class="block text-gray-700 font-medium hover:text-green-500 px-3 py-2">
                                <?php echo htmlspecialchars($_SESSION['name']); ?>
                            </a>
                            <div class="pl-4">
                                <a href="logout.php" class="block text-gray-700 hover:bg-gray-100 px-3 py-2">Logout</a>
                            </div>
                        <?php else: ?>
                            <a href="login.php" class="block bg-green-500 text-white px-4 py-2 rounded-md text-center hover:bg-green-600 transition-colors duration-300">Login</a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Spacer -->
    <div class="h-20"></div>

    <!-- Contact Section -->
    <section id="contact" class="px-4 py-8 sm:px-6 md:px-8 lg:px-12">
        <!-- User Exists Alert -->
        <?php if ($user): ?>
            <div id="user-alert" class="custom-alert max-w-2xl mx-auto bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-md flex justify-between items-center">
                <div>
                    <strong>Oops!</strong> Organization already exists.
                </div>
                <button onclick="closeAlert('user-alert')" class="text-red-700 hover:text-red-900 focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        <?php endif; ?>

        <!-- Success Alert -->
        <?php if ($success): ?>
            <div id="success-alert" class="custom-alert max-w-2xl mx-auto bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-md flex justify-between items-center">
                <div>
                    <strong>Success!</strong> Details sent successfully. We will contact you ASAP.
                </div>
                <button onclick="closeAlert('success-alert')" class="text-green-700 hover:text-green-900 focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        <?php endif; ?>

        <div class="max-w-7xl mx-auto flex flex-col md:flex-row gap-8 items-center justify-center">
            <!-- Image -->
            <div class="w-full md:w-1/3 flex justify-center">
                <img src="png7.png" alt="Contact" class="w-full max-w-xs h-auto rounded-3xl">
            </div>

            <!-- Form -->
            <div class="w-full md:w-2/3 flex justify-center">
                <form action="Contact.php" method="post" class="w-full max-w-md bg-gray-100 p-6 sm:p-8 rounded-xl shadow-lg space-y-6">
                    <h1 class="text-2xl sm:text-3xl font-semibold text-gray-800 mb-6 text-center">Join Our Community</h1>

                    <!-- Organization Name -->
                    <div>
                        <label class="block text-base sm:text-lg font-medium mb-2">Organization Name</label>
                        <input type="text" name="orgname" placeholder="Enter Organization Name" required autocomplete="off"
                               class="w-full border border-gray-300 px-3 py-2 sm:px-4 sm:py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>

                    <!-- Location -->
                    <div>
                        <label class="block text-base sm:text-lg font-medium mb-2">Location</label>
                        <input type="text" name="location" placeholder="Enter Location" required
                               class="w-full border border-gray-300 px-3 py-2 sm:px-4 sm:py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-base sm:text-lg font-medium mb-2">Email</label>
                        <input type="email" name="email" placeholder="Enter Email Address" required
                               class="w-full border border-gray-300 px-3 py-2 sm:px-4 sm:py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>

                    <!-- Phone Number -->
                    <div>
                        <label class="block text-base sm:text-lg font-medium mb-2">Phone Number</label>
                        <input type="tel" name="phone" placeholder="Enter Phone Number" required
                               class="w-full border border-gray-300 px-3 py-2 sm:px-4 sm:py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>

                    <!-- Message -->
                    <div>
                        <label class="block text-base sm:text-lg font-medium mb-2">Message</label>
                        <textarea name="message" placeholder="Enter your message" required rows="4"
                               class="w-full border border-gray-300 px-3 py-2 sm:px-4 sm:py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-green-400"></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit"
                                class="w-full bg-green-500 text-white text-base sm:text-lg font-semibold py-2 sm:py-3 rounded-md hover:bg-green-600 transition-all duration-300">
                            Join Community
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-100 mt-12">
        <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-3 gap-10">
            <!-- Logo & Description -->
            <div>
                <a href="index.php" class="flex items-center space-x-3 mb-4">
                    <img src="https://media.istockphoto.com/id/1045368942/vector/abstract-green-leaf-logo-icon-vector-design-ecology-icon-set-eco-icon.jpg?s=612x612&w=0&k=20&c=XIfHMI8r1G73blCpCBFmLIxCtOLx8qX0O3mZC9csRLs=" alt="Plant-Hub" class="w-10 h-10 rounded-full">
                    <span class="text-2xl font-bold text-emerald-700">Plant-Hub</span>
                </a>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Your trusted companion in cultivating a green lifestyle 🌱. Join our plant-loving community and grow together.
                </p>
            </div>

            <!-- Navigation Links -->
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

            <!-- Social Media -->
            <div>
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Connect With Us</h3>
                <div class="flex space-x-4">
                    <a href="https://www.instagram.com" target="_blank" class="text-gray-600 hover:text-pink-500 transition">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M7.75 2C4.022 2 2 4.021 2 7.75v8.5C2 19.979 4.021 22 7.75 22h8.5C19.979 22 22 19.979 22 16.25v-8.5C22 4.021 19.979 2 16.25 2h-8.5zm0 1.5h8.5C18.216 3.5 20.5 5.784 20.5 8.25v7.5c0 2.466-2.284 4.75-4.75 4.75h-8.5C5.784 20.5 3.5 18.216 3.5 15.75v-7.5C3.5 5.784 5.784 3.5 7.75 3.5zm8.25 2a1 1 0 100 2 1 1 0 000-2zM12 7.25a4.75 4.75 0 110 9.5 4.75 4.75 0 010-9.5zm0 1.5a3.25 3.25 0 100 6.5 3.25 3.25 0 000-6.5z"/>
                        </svg>
                    </a>
                    <a href="https://www.facebook.com" target="_blank" class="text-gray-600 hover:text-blue-600 transition">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M13 2.05v3.45h2.4l-.35 2.7H13V12h2.65l-.4 2.7H13v7.25h-3.1V14.7H8.5v-2.7h1.4v-2.2c0-2.1 1.05-3.5 3.6-3.5h2.5z"/>
                        </svg>
                    </a>
                    <a href="https://github.com" target="_blank" class="text-gray-600 hover:text-gray-900 transition">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 .297a12 12 0 00-3.793 23.4c.6.113.82-.26.82-.577v-2.234c-3.338.726-4.042-1.615-4.042-1.615-.547-1.386-1.336-1.756-1.336-1.756-1.093-.748.083-.733.083-.733 1.21.085 1.847 1.243 1.847 1.243 1.07 1.834 2.807 1.304 3.492.996.108-.775.42-1.304.764-1.604-2.665-.304-5.467-1.333-5.467-5.93 0-1.31.467-2.38 1.235-3.22-.124-.303-.535-1.523.117-3.176 0 0 1.008-.322 3.3 1.23a11.52 11.52 0 016 0c2.29-1.552 3.296-1.23 3.296-1.23.653 1.653.242 2.873.12 3.176.77.84 1.233 1.91 1.233 3.22 0 4.61-2.807 5.624-5.48 5.92.43.37.823 1.102.823 2.222v3.293c0 .32.218.694.825.576A12.003 12.003 0 0012 .297z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="bg-gray-200 text-center py-4">
            <p class="text-sm text-gray-600">© 2025 Plant-Hub. All rights reserved.</p>
        </div>
    </footer>

    <!-- JavaScript for Mobile Menu Toggle and Alert Close -->
    <script>
        // Mobile Menu Toggle
        document.getElementById('menu-toggle').addEventListener('click', function () {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });

        // Function to Close Alerts
        function closeAlert(alertId) {
            const alert = document.getElementById(alertId);
            alert.classList.add('hidden');
        }
    </script>
</body>
</html>