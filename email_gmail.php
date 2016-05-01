<?php
/**
 * Created by PhpStorm.
 * User: schandramouli
 * Date: 4/5/16
 * Time: 7:45 PM
 */
require('PD.php');
function getEMail($username, $password, $condition)
{
    /* connect to gmail */
    $hostname = '{imap.gmail.com:993/imap/ssl/novalidate-cert}EHI Emails';

    /* try to connect */
    $inbox = imap_open($hostname, $username, $password) or die('Cannot connect to Gmail: ' . imap_last_error());

    /* grab emails that satisfy condition */
    $emails = imap_search($inbox, $condition);
    $messages = Array();
    /* if emails are returned, cycle through each... */
    if ($emails) {
        /* begin output var */
        //echo "Emails found<br>\n";

        /* for every email... */
        foreach ($emails as $email_number) {
            $output = '';
            /* get information specific to this email */

            $message = imap_fetchbody($inbox, $email_number, 1.2);
            if (!strlen($message) > 0) {
                $message = imap_fetchbody($inbox, $email_number, 1);
            }
//            echo $message."\n";
            $messages[$email_number] = $message;
        }

    } else {
        echo 'No emails';
        return null;
    }
    /* close the connection */
    imap_close($inbox);
    return $messages;
}


//$messages = getEMail($username, $password, 'FROM "mailer-daemon@googlemail.com"');
////print_r($messages);
//
//$re = "/.*Google tried to deliver your message, but it was rejected by the server for the recipient domain (.*) by (.*)\\. \\[(.*)\\].*/";
//
//$hashmap = Array();
//foreach($messages as $message) {
//    preg_match($re, $message, $matches);
//    if (!empty($matches)) {
//        echo $matches[1] . " --- " . $matches[2] . " --- " . $matches[3] . "\n";
//        $hashmap[$matches[1]] = [$matches[2], $matches[3]];
//    }
//}
//print_r($hashmap);

$messages = getEMail($username, $password, 'TO '.$argv[1]);
// prints the first email alone
print_r(reset($messages));
?>