<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_POST['honeypot'])) {
        echo "Spam detected.";
        exit;
    }

    $name     = htmlspecialchars($_POST['name'] ?? 'N/A');
    $email    = htmlspecialchars($_POST['email'] ?? 'N/A');
    $phone    = htmlspecialchars($_POST['phone'] ?? 'N/A');
    $address  = htmlspecialchars($_POST['address'] ?? 'N/A');
    $type     = htmlspecialchars($_POST['type'] ?? 'N/A');
    $quantity = htmlspecialchars($_POST['quantity'] ?? 'N/A');
    $message  = htmlspecialchars($_POST['message'] ?? 'N/A');

    $to       = 'Mrfsrinivas@gmail.com';
    $subject  = 'New Cart Order Submission with Payment Screenshot';

    // Handle file upload
    $file_uploaded = false;
    $file_path = '';
    if (isset($_FILES['screenshot']) && $_FILES['screenshot']['error'] == UPLOAD_ERR_OK) {
        $file_tmp  = $_FILES['screenshot']['tmp_name'];
        $file_name = basename($_FILES['screenshot']['name']);
        $file_type = mime_content_type($file_tmp);
        $file_data = file_get_contents($file_tmp);
        $file_base64 = chunk_split(base64_encode($file_data));
        $file_uploaded = true;
    }

    // Email headers for attachment
    $boundary = md5(time());
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

    // Email body
    $body = "--$boundary\r\n";
    $body .= "Content-Type: text/plain; charset=UTF-8\r\n\r\n";
    $body .= "New cart order details:\n\n";
    $body .= "Name: $name\nEmail: $email\nPhone: $phone\n";
    $body .= "Address: $address\nProduct Type: $type\nQuantity: $quantity\nMessage: $message\n\n";

    // Attach the file
    if ($file_uploaded) {
        $body .= "--$boundary\r\n";
        $body .= "Content-Type: $file_type; name=\"$file_name\"\r\n";
        $body .= "Content-Disposition: attachment; filename=\"$file_name\"\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $body .= $file_base64 . "\r\n";
    }

    $body .= "--$boundary--";

    // Send the email
    if (mail($to, $subject, $body, $headers)) {
        echo "Success";
    } else {
        echo "Failed to send email.";
    }
} else {
    echo "Invalid request.";
}
?>
