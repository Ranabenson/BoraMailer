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
//Attachments
$attachments = [];
$file = "generated/".($_POST['file']??'filename.pdf'); //Name of attached file
$fileEnc = md5($file); //Generate a Unique name

$attachments = [];
$content = $_POST['data']; //Get sent file
$attachments[$fileEnc]['content'] = chunk_split( $content ); 
$attachments[$fileEnc]['file'] = basename($file); //Get filenam of attached file
$mail->attachments($attachments); //Add Attachment to email

//Save attachment to folder
//file_put_contents($file, base64_decode($_POST['data'])); //Uncomment to save to localfolder

//Send email request to BORA API
$emailResp = $mail->sendRemote();

print_r($emailResp); //Print email response
