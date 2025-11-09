<?php
include_once '../../config/Database.php';
include_once '../../app/models/Customer.php';

class CustomerController {
    public function index() {
        $db = Database::getInstance()->getConnection();
        $customer = new Customer($db);
        $result = $customer->read();
        $num = $result->rowCount();

        if($num > 0) {
            $customers_arr = array();
            $customers_arr['data'] = array();

            while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $customer_item = array(
                    'id' => $id,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'phone' => $phone,
                    'address' => $address,
                    'company' => $company
                );
                array_push($customers_arr['data'], $customer_item);
            }
            echo json_encode($customers_arr);
        } else {
            echo json_encode(array('message' => 'No Customers Found'));
        }
    }

    public function create($data) {
        $db = Database::getInstance()->getConnection();
        $customer = new Customer($db);

        $customer->first_name = $data->first_name;
        $customer->last_name = $data->last_name;
        $customer->email = $data->email;
        $customer->phone = $data->phone;
        $customer->address = $data->address;
        $customer->company = $data->company;

        if($customer->create()) {
            echo json_encode(array('message' => 'Customer Created'));
        } else {
            echo json_encode(array('message' => 'Customer Not Created'));
        }
    }

    public function update($data) {
        $db = Database::getInstance()->getConnection();
        $customer = new Customer($db);

        $customer->id = $data->id;
        $customer->first_name = $data->first_name;
        $customer->last_name = $data->last_name;
        $customer->email = $data->email;
        $customer->phone = $data->phone;
        $customer->address = $data->address;
        $customer->company = $data->company;

        if($customer->update()) {
            echo json_encode(array('message' => 'Customer Updated'));
        } else {
            echo json_encode(array('message' => 'Customer Not Updated'));
        }
    }

    public function delete($data) {
        $db = Database::getInstance()->getConnection();
        $customer = new Customer($db);
        $customer->id = $data->id;

        if($customer->delete()) {
            echo json_encode(array('message' => 'Customer Deleted'));
        } else {
            echo json_encode(array('message' => 'Customer Not Deleted'));
        }
    }
}
