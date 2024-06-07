<?php
class PHP_Email_Form {
    public $to;
    public $from_name;
    public $from_email;
    public $subject;
    public $smtp = array();
    public $messages = array();
    public $ajax;

    public function add_message($content, $label, $length = 0) {
        $this->messages[] = array('content' => $content, 'label' => $label, 'length' => $length);
    }

    public function send() {
        // Check if SMTP settings are provided
        if (empty($this->smtp['host']) || empty($this->smtp['username']) || empty($this->smtp['password']) || empty($this->smtp['port'])) {
            return "Error: SMTP settings are not configured.";
        }

        // Construct the email headers
        $headers = "From: " . $this->from_name . " <" . $this->from_email . ">\r\n";
        $headers .= "Reply-To: " . $this->from_email . "\r\n";
        $headers .= "Content-type: text/html\r\n";

        // Construct the email body
        $email_body = "";
        foreach ($this->messages as $message) {
            $email_body .= $message['label'] . ": " . $message['content'] . "<br>\r\n";
        }

        // Set SMTP options
        ini_set("SMTP", $this->smtp['host']);
        ini_set("smtp_port", $this->smtp['port']);
        ini_set("sendmail_from", $this->from_email);

        // Send the email
        if (mail($this->to, $this->subject, $email_body, $headers)) {
            return "Email sent successfully.";
        } else {
            return "Error: Failed to send email.";
        }
    }
}
?>
