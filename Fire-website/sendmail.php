<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $mobile   = $_POST['mobile'];
    $address  = $_POST['address'];
    $type     = $_POST['type'];
    $quantity = $_POST['quantity'];
    $message  = isset($_POST['message']) ? $_POST['message'] : 'No additional message.';

    // Your email address
    $to = "Mrfsrinivas@gmail.com";

    // Email subject
    $subject = "🔥 New Fire Cylinder Order Request";

    // Email message
    $body  = "Name: $name\n";
    $body .= "Email: $email\n";
    $body .= "Mobile Number: $mobile\n";
    $body .= "Address: $address\n";
    $body .= "Cylinder Type: $type\n";
    $body .= "Quantity: $quantity\n";
    $body .= "Message: $message\n";

    // Email headers
    $headers = "From: $email";

    // Send the email
    if (mail($to, $subject, $body, $headers)) {
        echo "✅ Your order request has been sent successfully.";
    } else {
        echo "❌ Failed to send your order. Please try again later.";
    }
}
?>
