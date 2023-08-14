<?php
include '../BoraLoader.php';

use \ILEBORA\BoraConstants;
use \ILEBORA\BoraMailer;

//Email Details
$to = ''; //Recipients email
$subject = ''; // Email Subject
$body = ''; //Email Body | Message


$mail = (new BoraMailer())
          ->to($to)
          ->from(BoraConstants::senderEmail) //Get default sender email
          ->subject($subject)
          ->body($body);

//Send email request to BORA API
$emailResp = $mail->sendRemote();

print_r($emailResp); //Print email response
