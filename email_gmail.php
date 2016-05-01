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

/* grab emails */
$emails = imap_search($inbox,'ALL');

/* if emails are returned, cycle through each... */
if($emails) {
    /* begin output var */
    echo "Emails found<br>";


    /* put the newest emails on top */
//    rsort($emails);

    /* for every email... */
    foreach($emails as $email_number) {
        $output = '';
        /* get information specific to this email */
        $overview = imap_fetch_overview($inbox,$email_number,0);
//        $message = imap_fetchbody($inbox,$email_number,2);

        /* output the email header information */
//        $output.= '<div class="toggler '.($overview[0]->seen ? 'read' : 'unread').'">';
        $output.= $overview[0]->subject;
//        $output.= '<span class="from">'.$overview[0]->from.'</span>';
//        $output.= '<span class="date">on '.$overview[0]->date.'</span>';
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