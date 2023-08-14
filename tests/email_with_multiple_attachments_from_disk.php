<?php
include '../BoraLoader.php';

use \ILEBORA\BoraConstants;
use \ILEBORA\BoraMailer;

//Email Details
$to = $_POST['to'];
$subject = $_POST['subject']??'Email Subject';
$body = $_POST['body']??"Receipt Email Body";

$mail = (new BoraMailer())
          ->to($to)
          ->from(BoraConstants::senderEmail)
          ->subject($subject)
          ->body($body);

//Multiple Attachments
$mail->attachment('file'); //File file1
$mail->attachment('file2'); //File file2
$mail->attachment('file3'); //File file3

//Send email request to BORA API
$emailResp = $mail->sendRemote();

print_r($emailResp); //Print email response
