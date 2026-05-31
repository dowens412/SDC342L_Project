<?php
class ComplaintNote {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function getNotesByComplaintId($complaint_id) {
        $query = "SELECT 
                    cn.note_id,
                    cn.complaint_id,
                    cn.employee_id,
                    cn.note_text,
                    cn.created_at,
                    e.first_name,
                    e.last_name,
                    e.user_id
                  FROM complaint_notes cn
                  INNER JOIN employees e
                    ON cn.employee_id = e.employee_id
                  WHERE cn.complaint_id = :complaint_id
                  ORDER BY cn.created_at DESC";

        $statement = $this->db->prepare($query);
        $statement->bindValue(':complaint_id', $complaint_id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createNote($complaint_id, $employee_id, $note_text) {
        $query = "INSERT INTO complaint_notes
                  (complaint_id, employee_id, note_text)
                  VALUES
                  (:complaint_id, :employee_id, :note_text)";

        $statement = $this->db->prepare($query);

        $statement->bindValue(':complaint_id', $complaint_id, PDO::PARAM_INT);
        $statement->bindValue(':employee_id', $employee_id, PDO::PARAM_INT);
        $statement->bindValue(':note_text', $note_text);

        return $statement->execute();
    }

    public function updateNote($note_id, $note_text) {
        $query = "UPDATE complaint_notes
                  SET note_text = :note_text
                  WHERE note_id = :note_id";

        $statement = $this->db->prepare($query);

        $statement->bindValue(':note_id', $note_id, PDO::PARAM_INT);
        $statement->bindValue(':note_text', $note_text);

        return $statement->execute();
    }

    public function deleteNote($note_id) {
        $query = "DELETE FROM complaint_notes
                  WHERE note_id = :note_id";

        $statement = $this->db->prepare($query);
        $statement->bindValue(':note_id', $note_id, PDO::PARAM_INT);

        return $statement->execute();
    }
}
?>