<?php

namespace App\Controllers\User;

class Mail {
	/** 
	 * Send email with PHP (custom function)
	 *
	 * by Vitali Lutz 2019
	 *
	 * @param string $subject
	 * @param string $message
	 * @param boolean $is_html
	 * @param mixed $recipient
	 * @param mixed $sender
	 * @return boolean
	 */
	public static function send_mail($subject = '', $message = '', $is_html = false, $recipient = CONTACT_MAIL, $sender = CONTACT_MAIL) {
		// Detect HTML markdown
		if (substr_count($message, '</') >= 1) {
			$is_html = true;
		}
		// Build recipient name <email> pair
		if (is_array($recipient)) {
			$recipient = '=?UTF-8?B?' . base64_encode($recipient[0]) . '?= <' . $recipient[1] . '>';
		}
		// Build sender name <email> pair
		if (is_array($sender)) {
			$sender = '=?UTF-8?B?' . base64_encode($sender[0]) . '?= <' . $sender[1] . '>';
		}
		// Determine content type
		$content_type = 'text/plain';
		if ($is_html) {
			$content_type = 'text/html';
		}
		// Subject
		$subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
		// Mail headers
		$header  = 'MIME-Version: 1.0' . "\r\n";
		$header .= 'Content-type: ' . $content_type . '; charset=utf-8' . "\r\n";
		$header .= 'Content-Transfer-Encoding: base64' . "\r\n";
		$header .= 'Date: ' . date('r (T)') . "\r\n";

		$header .= 'From: ' . $sender . "\r\n";
		$header .= 'Reply-To: ' . $sender . "\r\n";
		$header .= 'X-Mailer: PHP ' . phpversion();

		return mail($recipient, $subject, base64_encode($message), $header) ? true : false;
	}
}