<?php
declare(strict_types=1);

// Import PHPMailer classes ..
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$success = false;
$user = false;
$formErrors = [];
$orgname = '';
$location = '';
$email = '';
$phone = '';
$message = '';

/**
 * Trim extra whitespace without stripping intended spaces.
 */
function normalise_text(?string $value): string
{
    $value = trim((string) $value);
    return (string) preg_replace('/\s+/', ' ', $value);
}

/**
 * Remove characters we do not want to store for phone numbers.
 */
function sanitize_phone(?string $value): string
{
    return trim(preg_replace('/[^\d\+\-\s\(\)]/', '', (string) $value));
}

/**
 * SMTP settings pulled from environment variables so we never commit secrets.
 */
function load_mail_settings(): array
{
    return [
        'host' => getenv('SMTP_HOST') ?: '',
        'username' => getenv('SMTP_USERNAME') ?: '',
        'password' => getenv('SMTP_PASSWORD') ?: '',
        'port' => (int) (getenv('SMTP_PORT') ?: 587),
        'encryption' => strtolower(getenv('SMTP_ENCRYPTION') ?: 'tls'),
        'from_email' => getenv('MAIL_FROM_ADDRESS') ?: 'no-reply@planthub.test',
        'from_name' => getenv('MAIL_FROM_NAME') ?: 'Plant-Hub',
    ];
}

/**
 * Attempt to load PHPMailer only when available to avoid runtime fatals on hosts
 * where the dependency has not been installed yet.
 */
function mailer_is_available(): bool
{
    if (class_exists(PHPMailer::class)) {
        return true;
    }

    $basePath = __DIR__ . '/PHPMailer';
    $required = [
        $basePath . '/Exception.php',
        $basePath . '/PHPMailer.php',
        $basePath . '/SMTP.php',
    ];

    foreach ($required as $file) {
        if (!file_exists($file)) {
            return false;
        }
        require_once $file;
    }

    return class_exists(PHPMailer::class);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        require __DIR__ . '/SignupDatabase.php';
    } catch (Throwable $throwable) {
        error_log('Failed to bootstrap database connection: ' . $throwable->getMessage());
        $formErrors[] = 'We could not process your request right now. Please try again later.';
    }

    $orgname = normalise_text($_POST['orgname'] ?? '');
    $location = normalise_text($_POST['location'] ?? '');
    $email = normalise_text($_POST['email'] ?? '');
    $phone = sanitize_phone($_POST['phone'] ?? '');
    $message = normalise_text($_POST['message'] ?? '');

    if ($orgname === '' || strlen($orgname) < 2) {
        $formErrors[] = 'Organization name is required.';
    }

    if ($location === '') {
        $formErrors[] = 'Location is required.';
    }

    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $formErrors[] = 'A valid email address is required.';
    }

    $digitsOnlyPhone = preg_replace('/\D/', '', $phone);
    if ($phone === '' || strlen($digitsOnlyPhone) < 7) {
        $formErrors[] = 'Please provide a valid phone number.';
    }

    if ($message === '') {
        $formErrors[] = 'Message cannot be empty.';
    }

    if (empty($formErrors) && isset($connect)) {
        try {
            $lookupSql = "SELECT 1 FROM `organization` WHERE orgname = ?";
            $stmt = $connect->prepare($lookupSql);
            $stmt->bind_param("s", $orgname);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                $user = true;
            } else {
                $insertSql = "INSERT INTO `organization` (orgname, location, email, phone, message) VALUES (?, ?, ?, ?, ?)";
                $stmt = $connect->prepare($insertSql);
                $stmt->bind_param("sssss", $orgname, $location, $email, $phone, $message);
                $stmt->execute();
                $success = true;

                if (mailer_is_available()) {
                    $mailSettings = load_mail_settings();
                    $hasCredentials = $mailSettings['host'] && $mailSettings['username'] && $mailSettings['password'];

                    if ($hasCredentials) {
                        try {
                            $mail = new PHPMailer(true);
                            $mail->isSMTP();
                            $mail->Host = $mailSettings['host'];
                            $mail->SMTPAuth = true;
                            $mail->Username = $mailSettings['username'];
                            $mail->Password = $mailSettings['password'];
                            $encryption = $mailSettings['encryption'] === 'ssl'
                                ? PHPMailer::ENCRYPTION_SMTPS
                                : PHPMailer::ENCRYPTION_STARTTLS;
                            $mail->SMTPSecure = $encryption;
                            $mail->Port = $mailSettings['port'];

                            $mail->setFrom($mailSettings['from_email'], $mailSettings['from_name']);
                            $mail->addAddress($email, $orgname);

                            $mail->isHTML(true);
                            $mail->Subject = 'Welcome to Plant-Hub Partnership';
                            $mail->Body = "
                                <h2>Dear " . htmlspecialchars($orgname) . ",</h2>
                                <p>Thank you for your interest in partnering with Plant-Hub, your trusted companion in cultivating a green lifestyle.</p>
                                <p>We have successfully received your application to join our community. Below are the details you submitted:</p>
                                <ul>
                                    <li><strong>Organization Name:</strong> " . htmlspecialchars($orgname) . "</li>
                                    <li><strong>Location:</strong> " . htmlspecialchars($location) . "</li>
                                    <li><strong>Email:</strong> " . htmlspecialchars($email) . "</li>
                                    <li><strong>Phone:</strong> " . htmlspecialchars($phone) . "</li>
                                    <li><strong>Message:</strong> " . nl2br(htmlspecialchars($message)) . "</li>
                                </ul>
                                <p>Our team will review your application and reach out to you soon to discuss the next steps in our partnership journey.</p>
                                <p>Should you have any questions in the meantime, please feel free to contact us at <a href='mailto:support@planthub.com'>support@planthub.com</a>.</p>
                                <p>Thank you for choosing to grow with us!</p>
                                <p>Best regards,<br>The Plant-Hub Team</p>
                            ";

                            $mail->AltBody = sprintf(
                                "Dear %s,\n\nThank you for your interest in Plant-Hub.\n\nOrganization Name: %s\nLocation: %s\nEmail: %s\nPhone: %s\nMessage: %s\n\nWe will be in touch shortly.\n\nPlant-Hub Team",
                                $orgname,
                                $orgname,
                                $location,
                                $email,
                                $phone,
                                $message
                            );

                            $mail->send();
                        } catch (Exception $e) {
                            error_log("Failed to send email: " . $e->getMessage());
                        }
                    } else {
                        error_log('Skipping confirmation email; SMTP credentials are not configured.');
                    }
                } else {
                    error_log('Skipping confirmation email; PHPMailer is not available.');
                }
            }

            if (isset($stmt)) {
                $stmt->close();
            }
        } catch (Throwable $throwable) {
            error_log('Failed to handle contact form submission: ' . $throwable->getMessage());
            $formErrors[] = 'We ran into an unexpected issue. Please try again later.';
            $success = false;
        }
    }
}
?>
<?php
$pageTitle = 'Contact · Plant-Hub';
$active = '';
require __DIR__ . '/partials/header.php';
?>
<style>
    .custom-alert { transition: opacity 0.5s ease-in-out; }
    .custom-alert.hidden { opacity: 0; display: none; }
</style>

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

        <!-- Validation Errors -->
        <?php if (!empty($formErrors)): ?>
            <div id="error-alert" class="custom-alert max-w-2xl mx-auto bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-4 mb-6 rounded shadow-md">
                <strong>Please review the following:</strong>
                <ul class="list-disc list-inside mt-2 space-y-1">
                    <?php foreach ($formErrors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
                <button onclick="closeAlert('error-alert')" class="text-yellow-700 hover:text-yellow-900 focus:outline-none mt-3 flex items-center gap-2">
                    <span>Dismiss</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        <?php endif; ?>

        <div class="max-w-7xl mx-auto flex flex-col md:flex-row gap-8 items-center justify-center">
            <!-- Image -->
            <div class="w-full md:w-1/3 flex justify-center">
                <img src="png4.png" alt="Contact" class="w-full max-w-xs h-auto rounded-3xl">
            </div>

            <!-- Form -->
            <div class="w-full md:w-2/3 flex justify-center">
                <form action="Contact.php" method="post" class="w-full max-w-md bg-gray-100 p-6 sm:p-8 rounded-xl shadow-lg space-y-6">
                    <h1 class="text-2xl sm:text-3xl font-semibold text-gray-800 mb-6 text-center">Join Our Community</h1>

                    <!-- Organization Name -->
                    <div>
                        <label class="block text-base sm:text-lg font-medium mb-2">Organization Name</label>
                        <input type="text" name="orgname" placeholder="Enter Organization Name" required autocomplete="off"
                               value="<?php echo htmlspecialchars($orgname); ?>"
                               class="w-full border border-gray-300 px-3 py-2 sm:px-4 sm:py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>

                    <!-- Location -->
                    <div>
                        <label class="block text-base sm:text-lg font-medium mb-2">Location</label>
                        <input type="text" name="location" placeholder="Enter Location" required
                               value="<?php echo htmlspecialchars($location); ?>"
                               class="w-full border border-gray-300 px-3 py-2 sm:px-4 sm:py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-base sm:text-lg font-medium mb-2">Email</label>
                        <input type="email" name="email" placeholder="Enter Email Address" required
                               value="<?php echo htmlspecialchars($email); ?>"
                               class="w-full border border-gray-300 px-3 py-2 sm:px-4 sm:py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>

                    <!-- Phone Number -->
                    <div>
                        <label class="block text-base sm:text-lg font-medium mb-2">Phone Number</label>
                        <input type="tel" name="phone" placeholder="Enter Phone Number" required
                               value="<?php echo htmlspecialchars($phone); ?>"
                               class="w-full border border-gray-300 px-3 py-2 sm:px-4 sm:py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>

                    <!-- Message -->
                    <div>
                        <label class="block text-base sm:text-lg font-medium mb-2">Message</label>
                        <textarea name="message" placeholder="Enter your message" required rows="4"
                               class="w-full border border-gray-300 px-3 py-2 sm:px-4 sm:py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-green-400"><?php echo htmlspecialchars($message); ?></textarea>
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

<script>
    function closeAlert(alertId) {
        const alert = document.getElementById(alertId);
        if (alert) alert.classList.add('hidden');
    }
</script>
<?php require __DIR__ . '/partials/footer.php'; ?>