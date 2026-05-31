<?php
class Customer {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function getAllCustomers() {
        $query = "SELECT customer_id, email, first_name, last_name, street_address, city, state, zip_code, phone_number, created_at
                  FROM customers
                  ORDER BY last_name, first_name";

        $statement = $this->db->prepare($query);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCustomerById($customer_id) {
        $query = "SELECT customer_id, email, first_name, last_name, street_address, city, state, zip_code, phone_number, created_at
                  FROM customers
                  WHERE customer_id = :customer_id";

        $statement = $this->db->prepare($query);
        $statement->bindValue(':customer_id', $customer_id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function createCustomer($email, $first_name, $last_name, $street_address, $city, $state, $zip_code, $phone_number, $password_hash) {
        $query = "INSERT INTO customers
                  (email, first_name, last_name, street_address, city, state, zip_code, phone_number, password_hash)
                  VALUES
                  (:email, :first_name, :last_name, :street_address, :city, :state, :zip_code, :phone_number, :password_hash)";

        $statement = $this->db->prepare($query);

        $statement->bindValue(':email', $email);
        $statement->bindValue(':first_name', $first_name);
        $statement->bindValue(':last_name', $last_name);
        $statement->bindValue(':street_address', $street_address);
        $statement->bindValue(':city', $city);
        $statement->bindValue(':state', $state);
        $statement->bindValue(':zip_code', $zip_code);
        $statement->bindValue(':phone_number', $phone_number);
        $statement->bindValue(':password_hash', $password_hash);

        return $statement->execute();
    }

    public function updateCustomer($customer_id, $email, $first_name, $last_name, $street_address, $city, $state, $zip_code, $phone_number) {
        $query = "UPDATE customers
                  SET email = :email,
                      first_name = :first_name,
                      last_name = :last_name,
                      street_address = :street_address,
                      city = :city,
                      state = :state,
                      zip_code = :zip_code,
                      phone_number = :phone_number
                  WHERE customer_id = :customer_id";

        $statement = $this->db->prepare($query);

        $statement->bindValue(':customer_id', $customer_id, PDO::PARAM_INT);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':first_name', $first_name);
        $statement->bindValue(':last_name', $last_name);
        $statement->bindValue(':street_address', $street_address);
        $statement->bindValue(':city', $city);
        $statement->bindValue(':state', $state);
        $statement->bindValue(':zip_code', $zip_code);
        $statement->bindValue(':phone_number', $phone_number);

        return $statement->execute();
    }

    public function deleteCustomer($customer_id) {
        $query = "DELETE FROM customers WHERE customer_id = :customer_id";

        $statement = $this->db->prepare($query);
        $statement->bindValue(':customer_id', $customer_id, PDO::PARAM_INT);

        return $statement->execute();
    }
}
?>