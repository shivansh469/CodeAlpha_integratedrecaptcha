<?php



// Rest of the code...

$recaptcha_secret = '6Lf-9rsnAAAAAFBDBKJBRM9FNXFSLyRyOG0AfT7U';
$recaptcha_response = $_POST['g-recaptcha-response'];
$url = 'https://www.google.com/recaptcha/api/siteverify';

$data = array(
    'secret' => $recaptcha_secret,
    'response' => $recaptcha_response
);

$options = array(
    'http' => array(
        'header' => 'Content-type: application/x-www-form-urlencoded',
        'method' => 'POST',
        'content' => http_build_query($data)
    )
);

$context = stream_context_create($options);
$verify = file_get_contents($url, false, $context);
$captcha_success = json_decode($verify);

if ($captcha_success->success) {
    // CAPTCHA verification successful. Proceed with form processing.

    // Example: Save the form data to a file
    $name = $_POST['name'];
    $email = $_POST['email'];
    
    $data = "Name: $name\nEmail: $email\n\n";
    file_put_contents('form_data.txt', $data, FILE_APPEND);

    echo "Form submitted successfully!";
} else {
    // CAPTCHA verification failed. Handle the error appropriately.
    echo "CAPTCHA verification failed. Please try again.";
}
?>