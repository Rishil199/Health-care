<?php

use Illuminate\Support\Facades\Mail;

    
    /**
 * Sends an email.
 *
 * @param  str  $email    The email
 * @param  str  $subject  The subject
 * @param  str  $message  The message
 *
 * @return bool True if mail is sent. False otherwise.
 */
function send_email($view, $data, $to_email, $from_email, $subject,$cc_user)
{
	$send = Mail::send($view, $data, function ($message) use ($to_email, $from_email,$subject,$cc_user)
	{
		$message->from($from_email, ' ');
		$message->to($to_email, ' ');
		$message->subject($subject);
		if($cc_user !== '')
		{
			$message->cc($cc_user);
		}
	});

	if(count(Mail::failures()) > 0)
	{
	    return false;
	}
	else
	{
		return true;
	}
}
?>