<?php
namespace App\Models;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email {
    private $conn;
    private $table = 'emails';

    public $id;
    public $customer_id;
    public $subject;
    public $body;
    public $direction;
    public $sent_at;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = 'SELECT * FROM ' . $this->table . ' ORDER BY created_at DESC';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' SET customer_id = :customer_id, subject = :subject, body = :body, direction = :direction, sent_at = :sent_at';
        $stmt = $this->conn->prepare($query);

        $this->customer_id = htmlspecialchars(strip_tags($this->customer_id));
        $this->subject = htmlspecialchars(strip_tags($this->subject));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->direction = htmlspecialchars(strip_tags($this->direction));
        $this->sent_at = htmlspecialchars(strip_tags($this->sent_at));

        $stmt->bindParam(':customer_id', $this->customer_id);
        $stmt->bindParam(':subject', $this->subject);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':direction', $this->direction);
        $stmt->bindParam(':sent_at', $this->sent_at);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function sendMail($to, $subject, $body) {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host       = SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = SMTP_USERNAME;
            $mail->Password   = SMTP_PASSWORD;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = SMTP_PORT;

            //Recipients
            $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
            $mail->addAddress($to);

            //Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
