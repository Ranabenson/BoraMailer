<?php 
namespace ILEBORA;
/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2023 ILEBORA
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */
 
/**
 * ILEBORA BORA PHP Mailer
 * 
 * Bora remote mailer
 *
 * @package BoraMailer
 * @license http://opensource.org/licenses/MIT  MIT License
 * @author  ILEBORA <info@ilebora.com> <+254113703323>
 */

use ILEBORA\BoraConstants;

class BoraMailer{
    private $to;
    private $from;
    private $subject;
    private $body;
    private $attachments = [];
    private $BOUNDARY = "anystring";
    
    public $error;
    

    public function __construct(){
        return $this;
    }

    public function to($to){
        $this->to = $to;    
        return $this;
    }

    public function from($from){
        $this->from = $from;  
        return $this;  
    }
    
    public function subject($subject){
        $this->subject = $subject;    
        return $this;
    }

    public function body($body){
        $this->body = $body;    
        return $this;
    }

    public function attachment($file){
        
        if(file_exists($file)){
            $fileEnc = md5($file);
            
            $content = file_get_contents($file);
            $content = base64_encode( $content );
            $this->attachments[$fileEnc]['content'] = chunk_split( $content );
            $this->attachments[$fileEnc]['file'] = basename($file);
        }
        return $this;
    }

    public function attachments($atts = []){
        $this->attachments = $atts;
        return $this;
    }

    public function sendRemote(){

        if(count($this->attachments)){
            //add Attachment to body
            foreach($this->attachments as $attachment){
                $content = $attachment['content'];
                $file = $attachment['file'];
                $this->body .= PHP_EOL."
                                --$this->BOUNDARY
                                Content-Type: text/plain
                                
                                See attached file!
                                
                                --BOUNDARY
                                Content-Type: application/pdf
                                Content-Transfer-Encoding: base64
                                Content-Disposition: attachment; filename='$file'
                                
                                $content
                                --BOUNDARY--
                                ".PHP_EOL;
            }
        }

        $data = array(
            'to' => $this->to,
            'from' => $this->from,
            'subject' => $this->subject,
            'body' => $this->body,
            'attachments' => $this->attachments,
    
        );

        try{

            $ch = curl_init();
            $data = http_build_query($data);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_URL, BoraConstants::emailApi);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer '. base64_encode(BoraConstants::userID.":".BoraConstants::apiKey)]);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $output = curl_exec($ch);

            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); 

            return $output;

        }catch(\Exception $ex){
            $this->error = json_encode($ex); //TODO Logging
            return false;
        }
    }
}
