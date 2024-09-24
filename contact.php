<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <!-- Include Google reCAPTCHA API script -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
    <div class="w-full max-w-lg bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-center">Contact Us</h2>

        <form action="" method="POST">
            <!-- Name Field -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
                <input type="text" id="name" name="name" class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <!-- Email Field -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <!-- Message Field -->
            <div class="mb-6">
                <label for="message" class="block text-gray-700 font-medium mb-2">Message</label>
                <textarea id="message" name="message" rows="5" class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
            </div>

            <!-- reCAPTCHA -->
            <div class="mb-6">
                <div class="g-recaptcha" data-sitekey="6LdVok0qAAAAAOe5PTXCvw-V2OujF41XsgDK4qrl"></div>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="w-full bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Send Message
                </button>
            </div>
        </form>

        <!-- PHP Section --><!-- PHP Section -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // reCAPTCHA secret key
    $recaptchaSecret = '6LdVok0qAAAAAHPUuYjaZajGj0_6vNELBUYktKKs';
    // Capturing the reCAPTCHA response
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    // Log the reCAPTCHA response for debugging
    error_log("reCAPTCHA Response: " . $recaptchaResponse); 

    // Making a request to Google's reCAPTCHA API to verify
    $response = @file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptchaSecret}&response={$recaptchaResponse}");

    // Handle network issues
    if ($response === FALSE) {
        echo '<p class="text-red-500 text-center mt-4">Error contacting reCAPTCHA service. Please try again later.</p>';
    } else {
        $responseKeys = json_decode($response, true); // Decode response from Google

        // Log the response from Google
        error_log("reCAPTCHA Verification Response: " . json_encode($responseKeys));

        // Check if the reCAPTCHA verification was successful 
        if (intval($responseKeys["success"]) !== 1) {
            echo '<p class="text-red-500 text-center mt-4">reCAPTCHA verification failed. Please try again.</p>';
        } else {
            // If successful, sanitize and validate inputs
            $name = htmlspecialchars(trim($_POST['name']));
            $email = htmlspecialchars(trim($_POST['email']));
            $message = htmlspecialchars(trim($_POST['message']));

            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo '<p class="text-red-500 text-center mt-4">Invalid email format. Please enter a valid email.</p>';
            } elseif (empty($name) || empty($message)) {
                // Check for empty fields
                echo '<p class="text-red-500 text-center mt-4">Name and message fields cannot be empty.</p>';
            } else {
                // Process the form (e.g., send an email)
                // Example: mail($to, $subject, $message);
                echo '<p class="text-green-500 text-center mt-4">Message sent successfully!</p>';
            }
        }
    }
}
?>

    </div>
</body>
</html>
