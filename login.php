<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Include Google reCAPTCHA API script -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Login</h2>

        <form action="" method="POST">
            <!-- Email Field -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                <input type="email" id="email" name="username" class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <!-- Password Field -->
            <div class="mb-6">
                <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <!-- reCAPTCHA -->
            <div class="mb-6">
                <div class="g-recaptcha" data-sitekey="6LdVok0qAAAAAOe5PTXCvw-V2OujF41XsgDK4qrl"></div>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="w-full bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Log In
                </button>
            </div>
        </form>
        
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // reCAPTCHA secret key
                $recaptchaSecret = '6LdVok0qAAAAAHPUuYjaZajGj0_6vNELBUYktKKs';
                $recaptchaResponse = $_POST['g-recaptcha-response'];

                // Log the response for debugging
                error_log("reCAPTCHA Response: " . $recaptchaResponse);

                // Making a request to Google's reCAPTCHA API to verify
                $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptchaSecret}&response={$recaptchaResponse}");
                $responseKeys = json_decode($response);

                // Check if the reCAPTCHA verification was successful 
                if ($responseKeys->success) {
                    // reCAPTCHA validation successful
                    // Process your form data here
                    echo "Form submitted successfully!";
                } else {
                    // reCAPTCHA validation failed
                    echo "reCAPTCHA verification failed. Please try again.";
                }
            
            }
        ?>

    </div>
</body>
</html>
