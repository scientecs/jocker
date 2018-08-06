<?php

namespace App\Core;

/**
 * Class of Mailer
 */
class Mailer {

    /**
     * Send message
     * 
     * @param type $emails
     * @param type $from
     * @param type $subject
     * @param type $message
     *
     * @return bool
     */
    public function send($emails, $from, $subject, $message) {
        $to = '';

        foreach ($emails as $email) {
            $to .= $email . ', ';
        }

        $to = rtrim($to, ', ');

        $headers = 'From: ' . $from . "\r\n" .
                'Reply-To: ' . $from . "\r\n" .
                'To:' . $to . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

        $result = mail($to, $subject, $message, $headers);

        return $result;
    }

}
