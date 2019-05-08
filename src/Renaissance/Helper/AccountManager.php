<?php

namespace Renaissance\Helper;

// use Aya\Core\Folder;

class AccountManager {

    // const 'SRV_URL';

    static $operators;

    static $numbers;

    static public function createRiddle() {
        self::$operators = [
            'add'
        ];

        return ;
    }

    static public function sendEmail($to, $subject, $message) {
        // $to      = $email;
        $subject = 'the subject';
        $message = 'hello';
        $headers = 'From: webmaster@example.com' . "\r\n" .
            'Reply-To: webmaster@example.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        
        var_dump(imap_mail($to, $subject, $message, $headers));
    }




}