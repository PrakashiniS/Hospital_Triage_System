<?php
 require_once 'vendor/autoload.php' ; use Twilio\Rest\Client;
 $to = $_POST['to'];  // Receiver's phone number
 $message = $_POST['message'];  // Message to send
 $twilio = new Client($sid, $token);
 try {
    $twilio->messages->create(
        $to, // Receiver's phone number
        [
            'from' => $from, // Your Twilio phone number
            'body' => $message // The message content
        ]
    );
    echo "Message sent successfully!";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
 