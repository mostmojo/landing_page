<?php
if(isset($_POST['email'])) {
    $email_to = "contact@xxxxxx.com";
    $email_subject = "Message from Cambridge Blockchain Forum";

    function died($error) {
        // your error code can go here
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error."<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }
    function clean_string($string) {
        $bad = array("content-type","bcc:","to:","cc:","href");
        return str_replace($bad,"",$string);
    }
    // validation expected data exists
    if(!isset($_POST['name']) ||
        !isset($_POST['email']) ||
        !isset($_POST['message'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');
    }
    $first_name = $_POST['name']; // required
    $email_from = $_POST['email']; // required
    $comments = $_POST['message']; // required

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

    if(!preg_match($email_exp,$email_from)) {
        $error_message .= 'Email Address you entered does not appear to be valid.<br />';
    }
    $string_exp = "/^[A-Za-z .'-]+$/";

    if(!preg_match($string_exp,$first_name)) {
        $error_message .= 'Name you entered does not appear to be valid.<br />';
    }
    if(strlen($comments) < 2) {
        $error_message .= 'Message you entered do not appear to be valid.<br />';
    }
    if(strlen($error_message) > 0) {
        died($error_message);
    }
    else{
        $email_message .= "Name: ".clean_string($first_name)."\n";
        $email_message .= "Email: ".clean_string($email_from)."\n";
        $email_message .= "Message: ".clean_string($comments)."\n";

        $headers = 'From: '.$email_from."\r\n".
            'Reply-To: '.$email_from."\r\n" .
            'X-Mailer: PHP/' . phpversion();
        mail($email_to, $email_subject, $email_message, $headers);
        echo "Thank you for contacting us. Your message has been sent.";
    }
}
