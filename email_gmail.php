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

/* if emails are returned, cycle through each... */
if($emails) {
    /* begin output var */
    echo "Emails found<br>\n";


    /* put the newest emails on top */
//    rsort($emails);

    /* for every email... */
    foreach($emails as $email_number) {
        $output = '';
        /* get information specific to this email */
        $overview = imap_fetch_overview($inbox,$email_number,0);
        $message = imap_fetchbody($inbox,$email_number,2);

        //$re = "/.*Google tried to deliver your message, but it was rejected by the server for the recipient domain (.*) by (.*)\\. \\[(.*)\\].*/";
        //preg_match($re, $message, $matches);

        /* output the email header information */
        $output.= $overview[0]->subject;
        $output.= $overview[0]->date;
//        $output.= implode(",", $matches);
        $output.= $message;
//        $output.= '</div>';

        /* output the email body */
//        $output.= '<div class="body">'.$message.'</div>';
        $output.= "<br>\n";
        echo $output;
    }


} else {
    echo 'No emails';
}

/* close the connection */
imap_close($inbox);
?>