<?php namespace System;

/**
 * PeachyPhp
 *
 * Just another PHP Framework
 *
 * @package		peachy-php
 * @author		k. wilson
 * @link		http://peachy-php.co.uk
 */

class Email {

	private $headers = array();

	private $to = array();
	private $from = array();
	private $cc = array();
	private $bcc = array();

	private $subject = '';
	private $body_plain = '';
	private $body_html = '';

	private $attachments = array();
	private $hash = '';

	private function _alt_boundary() {
		return 'B_ALT-' . $this->hash;
	}

	private function _atc_boundary() {
		return 'B_ATC-' . $this->hash;
	}

	private function _build_headers() {
		$headers = array();

		if(count($this->from)) {
			$headers[] = 'X-Sender: ' . $this->from[0];
		}

		$headers[] = 'X-Mailer: PHP';
		$headers[] = 'X-Priority: 3 (Normal)';

		if(count($this->from)) {
			$headers[] = 'Message-ID: <' . uniqid() . strstr($this->from[0], '@') . '>';
		}
		$headers[] = 'Mime-Version: 1.0';

		if(count($this->attachments)) {
			$headers[] = 'Content-Type: multipart/mixed; boundary="' . $this->_atc_boundary() . '"';
		} else {
			$headers[] = 'Content-Type: multipart/alternative; boundary="' . $this->_alt_boundary() . '"';
		}

		// from
		if(count($this->from)) {
			$headers[] = 'From: ' . implode(", ", $this->from) . PHP_EOL;
		}

		// cc
		if(count($this->cc)) {
			$headers[] = 'Cc: ' . implode(", ", $this->cc) . PHP_EOL;
		}

		// bcc
		if(count($this->bcc)) {
			$headers[] = 'Bcc: ' . implode(", ", $this->bcc) . PHP_EOL;
		}

		return array_merge($headers, $this->headers);
	}

	public function prepare() {
		// message ID
		$this->hash = hash('md5', uniqid());

		// reset headers
		$this->headers = array();

		// reset addresses
		$this->to = array();
		$this->from = array();
		$this->cc = array();
		$this->bcc = array();

		// reset subject
		$this->subject = '';

		// reset message
		$this->body_plain = '';
		$this->body_html = '';

		// reset attachments
		$this->attachments = array();
	}

	public function set_header($name, $value) {
		$this->headers[] = $name . ': ' . $value;
	}

	public function to($address) {
		$this->to[] = $address;
	}

	public function from($address) {
		$this->from[] = $address;
	}

	public function cc($address) {
		$this->cc[] = $address;
	}

	public function bcc($address) {
		$this->bcc[] = $address;
	}

	public function subject($subject) {
		$this->subject = $subject;
	}

	public function valid_email($address) {
		return filter_var($address, FILTER_VALIDATE_EMAIL) !== false ? true : false;
	}

	public function attach($file, $type = 'application/octet-stream') {
		if(!file_exists($file)) {
			return false;
		}

		if(!($content = file_get_contents($file))) {
			return false;
		}

		$attachment = array(
			'file' => $file,
			'type' => $type,
			'encoded' => chunk_split(base64_encode($content))
		);

		$this->attachments[] = $attachment;

		return true;
	}

	public function html($body) {
		$this->body_html = $body;
	}

	public function plain($body) {
		$this->body_plain = $body;
	}

	public function send() {
		// check we have a address to send to
		if(empty($this->to)) {
			return false;
		}

		// get headers
		$header_str = implode("\r\n", $this->_build_headers());

		$to = implode(", ", $this->to);

		$subject = strlen($this->subject) ? $this->subject : '(no subject)';

		$body = 'This is a multi-part message in MIME format.' . PHP_EOL . PHP_EOL;

		if(count($this->attachments)) {
			$body .= '--' . $this->_atc_boundary() . PHP_EOL;
			$body .= 'Content-Type: multipart/alternative; boundary="' . $this->_alt_boundary() . '"' . PHP_EOL . PHP_EOL;
		}

		// plain text
		if(strlen($this->body_plain)) {
			$body .= '--' . $this->_alt_boundary() . PHP_EOL;

			$body .= 'Content-Type: text/plain; charset=utf-8' . PHP_EOL;
			$body .= 'Content-Transfer-Encoding: Quoted-printable' . PHP_EOL . PHP_EOL;

			$body .= str_replace("\r", '', $this->body_plain) . PHP_EOL . PHP_EOL;
		}

		// html
		if(strlen($this->body_html)) {
			$body .= '--' . $this->_alt_boundary() . PHP_EOL;

			$body .= 'Content-Type: text/html; charset=utf-8' . PHP_EOL;
			$body .= 'Content-Transfer-Encoding: Base64' . PHP_EOL . PHP_EOL;

			$body .= chunk_split(base64_encode($this->body_html)) . PHP_EOL;
		}

		$body .= '--' . $this->_alt_boundary() . '--' . PHP_EOL . PHP_EOL;

		// build attachments
		if(count($this->attachments)) {
			foreach($this->attachments as $attachment) {
				$filename = basename($attachment['file']);
				$filetype = $attachment['type'];

				$body .= '--' . $this->_atc_boundary() . PHP_EOL;

				$body .= 'Content-Type: ' . $filetype . '; name="' . $filename . '"' . PHP_EOL;
				$body .= 'Content-Transfer-Encoding: Base64' . PHP_EOL;
				$body .= 'Content-Disposition: attachment' . PHP_EOL . PHP_EOL;

				$body .= $attachment['encoded'] . PHP_EOL;
			}

			$body .= '--' . $this->_atc_boundary() . '--' . PHP_EOL . PHP_EOL;
		}

		return mail($to, $subject, $body, $header_str);
	}
}

/* End of file */