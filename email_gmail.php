<?php
/**
 * Created by PhpStorm.
 * User: schandramouli
 * Date: 4/5/16
 * Time: 7:45 PM
 */
require('PD.php');
/* connect to gmail */
$hostname = '{imap.gmail.com:993/imap/ssl/novalidate-cert}EHI Emails';
//$hostname = '{imap.gmail.com:993/imap/ssl/novalidate-cert}EHI Emails';

/* try to connect */
$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());

/* grab emails that failed */
$emails = imap_search($inbox,'FROM "mailer-daemon@googlemail.com"');
$hashmap = Array();
/* if emails are returned, cycle through each... */
if($emails) {
    /* begin output var */
    echo "Emails found<br>\n";

    /* for every email... */
    foreach($emails as $email_number) {
        $output = '';
        /* get information specific to this email */

        $message = imap_fetchbody($inbox, $email_number, 1.2);
        if(!strlen($message)>0){
            $message = imap_fetchbody($inbox, $email_number, 1);
        }

        $re = "/.*Google tried to deliver your message, but it was rejected by the server for the recipient domain (.*) by (.*)\\. \\[(.*)\\].*/";
        preg_match($re, $message, $matches);
        if (!empty($matches)) {
            echo $matches[1] . " --- " . $matches[2] . " --- " . $matches[3] . "\n";
            $hashmap[$matches[1]] = [$matches[2], $matches[3]];
        }
//        $output = implode(",", $matches);
//        $output.= "<br>\n";
//        echo $output;
    }


} else {
    echo 'No emails';
}

print_r($hashmap);
/* close the connection */
imap_close($inbox);
?>