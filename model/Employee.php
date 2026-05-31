<?php
class Employee {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function getAllEmployees() {
        $query = "SELECT employee_id, user_id, first_name, last_name, email, phone_extension, employee_level, created_at
                  FROM employees
                  ORDER BY last_name, first_name";

        $statement = $this->db->prepare($query);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEmployeeById($employee_id) {
        $query = "SELECT employee_id, user_id, first_name, last_name, email, phone_extension, employee_level, created_at
                  FROM employees
                  WHERE employee_id = :employee_id";

        $statement = $this->db->prepare($query);
        $statement->bindValue(':employee_id', $employee_id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getTechnicians() {
        $query = "SELECT employee_id, user_id, first_name, last_name, email, phone_extension, employee_level
                  FROM employees
                  WHERE employee_level = 'Technician'
                  ORDER BY last_name, first_name";

        $statement = $this->db->prepare($query);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createEmployee($user_id, $first_name, $last_name, $email, $phone_extension, $employee_level, $password_hash) {
        $query = "INSERT INTO employees
                  (user_id, first_name, last_name, email, phone_extension, employee_level, password_hash)
                  VALUES
                  (:user_id, :first_name, :last_name, :email, :phone_extension, :employee_level, :password_hash)";

        $statement = $this->db->prepare($query);

        $statement->bindValue(':user_id', $user_id);
        $statement->bindValue(':first_name', $first_name);
        $statement->bindValue(':last_name', $last_name);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':phone_extension', $phone_extension);
        $statement->bindValue(':employee_level', $employee_level);
        $statement->bindValue(':password_hash', $password_hash);

        return $statement->execute();
    }

    public function updateEmployee($employee_id, $first_name, $last_name, $email, $phone_extension, $employee_level) {
        $query = "UPDATE employees
                  SET first_name = :first_name,
                      last_name = :last_name,
                      email = :email,
                      phone_extension = :phone_extension,
                      employee_level = :employee_level
                  WHERE employee_id = :employee_id";

        $statement = $this->db->prepare($query);

        $statement->bindValue(':employee_id', $employee_id, PDO::PARAM_INT);
        $statement->bindValue(':first_name', $first_name);
        $statement->bindValue(':last_name', $last_name);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':phone_extension', $phone_extension);
        $statement->bindValue(':employee_level', $employee_level);

        return $statement->execute();
    }

    public function updatePassword($employee_id, $password_hash) {
        $query = "UPDATE employees
                  SET password_hash = :password_hash
                  WHERE employee_id = :employee_id";

        $statement = $this->db->prepare($query);

        $statement->bindValue(':employee_id', $employee_id, PDO::PARAM_INT);
        $statement->bindValue(':password_hash', $password_hash);

        return $statement->execute();
    }

    public function deleteEmployee($employee_id) {
        $query = "DELETE FROM employees WHERE employee_id = :employee_id";

        $statement = $this->db->prepare($query);
        $statement->bindValue(':employee_id', $employee_id, PDO::PARAM_INT);

        return $statement->execute();
    }
}
?>