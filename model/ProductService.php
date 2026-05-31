<?php
class ProductService {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function getAllProductServices() {
        $query = "SELECT product_service_id, product_service_name, description, active
                  FROM products_services
                  ORDER BY product_service_name";

        $statement = $this->db->prepare($query);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActiveProductServices() {
        $query = "SELECT product_service_id, product_service_name, description, active
                  FROM products_services
                  WHERE active = 1
                  ORDER BY product_service_name";

        $statement = $this->db->prepare($query);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductServiceById($product_service_id) {
        $query = "SELECT product_service_id, product_service_name, description, active
                  FROM products_services
                  WHERE product_service_id = :product_service_id";

        $statement = $this->db->prepare($query);
        $statement->bindValue(':product_service_id', $product_service_id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function createProductService($product_service_name, $description, $active = 1) {
        $query = "INSERT INTO products_services
                  (product_service_name, description, active)
                  VALUES
                  (:product_service_name, :description, :active)";

        $statement = $this->db->prepare($query);

        $statement->bindValue(':product_service_name', $product_service_name);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':active', $active, PDO::PARAM_INT);

        return $statement->execute();
    }

    public function updateProductService($product_service_id, $product_service_name, $description, $active) {
        $query = "UPDATE products_services
                  SET product_service_name = :product_service_name,
                      description = :description,
                      active = :active
                  WHERE product_service_id = :product_service_id";

        $statement = $this->db->prepare($query);

        $statement->bindValue(':product_service_id', $product_service_id, PDO::PARAM_INT);
        $statement->bindValue(':product_service_name', $product_service_name);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':active', $active, PDO::PARAM_INT);

        return $statement->execute();
    }

    public function deleteProductService($product_service_id) {
        $query = "DELETE FROM products_services
                  WHERE product_service_id = :product_service_id";

        $statement = $this->db->prepare($query);
        $statement->bindValue(':product_service_id', $product_service_id, PDO::PARAM_INT);

        return $statement->execute();
    }
}
?>