<?php
class ComplaintType {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function getAllComplaintTypes() {
        $query = "SELECT complaint_type_id, complaint_type_name, description, active
                  FROM complaint_types
                  ORDER BY complaint_type_name";

        $statement = $this->db->prepare($query);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActiveComplaintTypes() {
        $query = "SELECT complaint_type_id, complaint_type_name, description, active
                  FROM complaint_types
                  WHERE active = 1
                  ORDER BY complaint_type_name";

        $statement = $this->db->prepare($query);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getComplaintTypeById($complaint_type_id) {
        $query = "SELECT complaint_type_id, complaint_type_name, description, active
                  FROM complaint_types
                  WHERE complaint_type_id = :complaint_type_id";

        $statement = $this->db->prepare($query);
        $statement->bindValue(':complaint_type_id', $complaint_type_id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function createComplaintType($complaint_type_name, $description, $active = 1) {
        $query = "INSERT INTO complaint_types
                  (complaint_type_name, description, active)
                  VALUES
                  (:complaint_type_name, :description, :active)";

        $statement = $this->db->prepare($query);

        $statement->bindValue(':complaint_type_name', $complaint_type_name);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':active', $active, PDO::PARAM_INT);

        return $statement->execute();
    }

    public function updateComplaintType($complaint_type_id, $complaint_type_name, $description, $active) {
        $query = "UPDATE complaint_types
                  SET complaint_type_name = :complaint_type_name,
                      description = :description,
                      active = :active
                  WHERE complaint_type_id = :complaint_type_id";

        $statement = $this->db->prepare($query);

        $statement->bindValue(':complaint_type_id', $complaint_type_id, PDO::PARAM_INT);
        $statement->bindValue(':complaint_type_name', $complaint_type_name);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':active', $active, PDO::PARAM_INT);

        return $statement->execute();
    }

    public function deleteComplaintType($complaint_type_id) {
        $query = "DELETE FROM complaint_types
                  WHERE complaint_type_id = :complaint_type_id";

        $statement = $this->db->prepare($query);
        $statement->bindValue(':complaint_type_id', $complaint_type_id, PDO::PARAM_INT);

        return $statement->execute();
    }
}
?>