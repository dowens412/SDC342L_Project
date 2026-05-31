<?php
class Complaint {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function getAllComplaints() {
        $query = "SELECT 
                    c.complaint_id,
                    c.complaint_description,
                    c.image_path,
                    c.complaint_status,
                    c.created_at,
                    c.resolution_date,
                    c.resolution_notes,
                    cust.first_name AS customer_first_name,
                    cust.last_name AS customer_last_name,
                    ps.product_service_name,
                    ct.complaint_type_name,
                    emp.first_name AS technician_first_name,
                    emp.last_name AS technician_last_name
                  FROM complaints c
                  INNER JOIN customers cust
                    ON c.customer_id = cust.customer_id
                  INNER JOIN products_services ps
                    ON c.product_service_id = ps.product_service_id
                  INNER JOIN complaint_types ct
                    ON c.complaint_type_id = ct.complaint_type_id
                  LEFT JOIN employees emp
                    ON c.assigned_employee_id = emp.employee_id
                  ORDER BY c.created_at DESC";

        $statement = $this->db->prepare($query);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getComplaintById($complaint_id) {
        $query = "SELECT 
                    c.*,
                    cust.first_name AS customer_first_name,
                    cust.last_name AS customer_last_name,
                    ps.product_service_name,
                    ct.complaint_type_name,
                    emp.first_name AS technician_first_name,
                    emp.last_name AS technician_last_name
                  FROM complaints c
                  INNER JOIN customers cust
                    ON c.customer_id = cust.customer_id
                  INNER JOIN products_services ps
                    ON c.product_service_id = ps.product_service_id
                  INNER JOIN complaint_types ct
                    ON c.complaint_type_id = ct.complaint_type_id
                  LEFT JOIN employees emp
                    ON c.assigned_employee_id = emp.employee_id
                  WHERE c.complaint_id = :complaint_id";

        $statement = $this->db->prepare($query);
        $statement->bindValue(':complaint_id', $complaint_id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getComplaintsByCustomerId($customer_id) {
        $query = "SELECT 
                    c.complaint_id,
                    c.complaint_description,
                    c.image_path,
                    c.complaint_status,
                    c.created_at,
                    c.resolution_date,
                    c.resolution_notes,
                    ps.product_service_name,
                    ct.complaint_type_name,
                    emp.first_name AS technician_first_name,
                    emp.last_name AS technician_last_name
                  FROM complaints c
                  INNER JOIN products_services ps
                    ON c.product_service_id = ps.product_service_id
                  INNER JOIN complaint_types ct
                    ON c.complaint_type_id = ct.complaint_type_id
                  LEFT JOIN employees emp
                    ON c.assigned_employee_id = emp.employee_id
                  WHERE c.customer_id = :customer_id
                  ORDER BY c.created_at DESC";

        $statement = $this->db->prepare($query);
        $statement->bindValue(':customer_id', $customer_id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getComplaintsByTechnicianId($employee_id) {
        $query = "SELECT 
                    c.complaint_id,
                    c.complaint_description,
                    c.image_path,
                    c.complaint_status,
                    c.created_at,
                    c.resolution_date,
                    c.resolution_notes,
                    cust.first_name AS customer_first_name,
                    cust.last_name AS customer_last_name,
                    ps.product_service_name,
                    ct.complaint_type_name
                  FROM complaints c
                  INNER JOIN customers cust
                    ON c.customer_id = cust.customer_id
                  INNER JOIN products_services ps
                    ON c.product_service_id = ps.product_service_id
                  INNER JOIN complaint_types ct
                    ON c.complaint_type_id = ct.complaint_type_id
                  WHERE c.assigned_employee_id = :employee_id
                  ORDER BY c.created_at DESC";

        $statement = $this->db->prepare($query);
        $statement->bindValue(':employee_id', $employee_id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOpenComplaints() {
        $query = "SELECT 
                    c.complaint_id,
                    c.complaint_description,
                    c.complaint_status,
                    c.created_at,
                    cust.first_name AS customer_first_name,
                    cust.last_name AS customer_last_name,
                    ps.product_service_name,
                    ct.complaint_type_name,
                    emp.first_name AS technician_first_name,
                    emp.last_name AS technician_last_name
                  FROM complaints c
                  INNER JOIN customers cust
                    ON c.customer_id = cust.customer_id
                  INNER JOIN products_services ps
                    ON c.product_service_id = ps.product_service_id
                  INNER JOIN complaint_types ct
                    ON c.complaint_type_id = ct.complaint_type_id
                  LEFT JOIN employees emp
                    ON c.assigned_employee_id = emp.employee_id
                  WHERE c.complaint_status = 'Open'
                  ORDER BY c.created_at DESC";

        $statement = $this->db->prepare($query);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUnassignedOpenComplaints() {
        $query = "SELECT 
                    c.complaint_id,
                    c.complaint_description,
                    c.complaint_status,
                    c.created_at,
                    cust.first_name AS customer_first_name,
                    cust.last_name AS customer_last_name,
                    ps.product_service_name,
                    ct.complaint_type_name
                  FROM complaints c
                  INNER JOIN customers cust
                    ON c.customer_id = cust.customer_id
                  INNER JOIN products_services ps
                    ON c.product_service_id = ps.product_service_id
                  INNER JOIN complaint_types ct
                    ON c.complaint_type_id = ct.complaint_type_id
                  WHERE c.complaint_status = 'Open'
                    AND c.assigned_employee_id IS NULL
                  ORDER BY c.created_at DESC";

        $statement = $this->db->prepare($query);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTechnicianOpenComplaintCounts() {
        $query = "SELECT 
                    e.employee_id,
                    e.first_name,
                    e.last_name,
                    e.user_id,
                    COUNT(c.complaint_id) AS open_complaint_count
                  FROM employees e
                  LEFT JOIN complaints c
                    ON e.employee_id = c.assigned_employee_id
                    AND c.complaint_status = 'Open'
                  WHERE e.employee_level = 'Technician'
                  GROUP BY e.employee_id, e.first_name, e.last_name, e.user_id
                  ORDER BY open_complaint_count ASC, e.last_name ASC";

        $statement = $this->db->prepare($query);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createComplaint($customer_id, $product_service_id, $complaint_type_id, $complaint_description, $image_path = null) {
        $query = "INSERT INTO complaints
                  (customer_id, product_service_id, complaint_type_id, complaint_description, image_path)
                  VALUES
                  (:customer_id, :product_service_id, :complaint_type_id, :complaint_description, :image_path)";

        $statement = $this->db->prepare($query);

        $statement->bindValue(':customer_id', $customer_id, PDO::PARAM_INT);
        $statement->bindValue(':product_service_id', $product_service_id, PDO::PARAM_INT);
        $statement->bindValue(':complaint_type_id', $complaint_type_id, PDO::PARAM_INT);
        $statement->bindValue(':complaint_description', $complaint_description);
        $statement->bindValue(':image_path', $image_path);

        return $statement->execute();
    }

    public function assignComplaint($complaint_id, $employee_id) {
        $query = "UPDATE complaints
                  SET assigned_employee_id = :employee_id
                  WHERE complaint_id = :complaint_id";

        $statement = $this->db->prepare($query);

        $statement->bindValue(':complaint_id', $complaint_id, PDO::PARAM_INT);
        $statement->bindValue(':employee_id', $employee_id, PDO::PARAM_INT);

        return $statement->execute();
    }

    public function updateComplaintStatus($complaint_id, $complaint_status) {
        $query = "UPDATE complaints
                  SET complaint_status = :complaint_status
                  WHERE complaint_id = :complaint_id";

        $statement = $this->db->prepare($query);

        $statement->bindValue(':complaint_id', $complaint_id, PDO::PARAM_INT);
        $statement->bindValue(':complaint_status', $complaint_status);

        return $statement->execute();
    }

    public function resolveComplaint($complaint_id, $resolution_date, $resolution_notes) {
        $query = "UPDATE complaints
                  SET complaint_status = 'Resolved',
                      resolution_date = :resolution_date,
                      resolution_notes = :resolution_notes
                  WHERE complaint_id = :complaint_id";

        $statement = $this->db->prepare($query);

        $statement->bindValue(':complaint_id', $complaint_id, PDO::PARAM_INT);
        $statement->bindValue(':resolution_date', $resolution_date);
        $statement->bindValue(':resolution_notes', $resolution_notes);

        return $statement->execute();
    }

    public function deleteComplaint($complaint_id) {
        $query = "DELETE FROM complaints
                  WHERE complaint_id = :complaint_id";

        $statement = $this->db->prepare($query);
        $statement->bindValue(':complaint_id', $complaint_id, PDO::PARAM_INT);

        return $statement->execute();
    }
}
?>