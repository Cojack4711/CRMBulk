<?php
include_once '../../config/Database.php';
include_once '../../app/models/Email.php';

class EmailController {
    public function index() {
        $db = Database::getInstance()->getConnection();
        $email = new Email($db);
        $result = $email->read();
        $num = $result->rowCount();

        if($num > 0) {
            $emails_arr = array();
            $emails_arr['data'] = array();

            while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $email_item = array(
                    'id' => $id,
                    'customer_id' => $customer_id,
                    'subject' => $subject,
                    'body' => $body,
                    'direction' => $direction,
                    'sent_at' => $sent_at
                );
                array_push($emails_arr['data'], $email_item);
            }
            echo json_encode($emails_arr);
        } else {
            echo json_encode(array('message' => 'No Emails Found'));
        }
    }

    public function create($data) {
        $db = Database::getInstance()->getConnection();
        $email = new Email($db);

        $email->customer_id = $data->customer_id;
        $email->subject = $data->subject;
        $email->body = $data->body;
        $email->direction = 'outgoing';
        $email->sent_at = date('Y-m-d H:i:s');

        if($email->sendMail($data->to, $data->subject, $data->body) && $email->create()) {
            echo json_encode(array('message' => 'Email Sent'));
        } else {
            echo json_encode(array('message' => 'Email Not Sent'));
        }
    }
}
