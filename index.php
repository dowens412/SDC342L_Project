<?php


require_once "config/database.php";
require_once "model/Customer.php";
require_once "model/Employee.php";
require_once "model/ProductService.php";
require_once "model/ComplaintType.php";
require_once "model/Complaint.php";
require_once "model/ComplaintNote.php";

include "includes/header.php";

$customerModel = new Customer($db);
$employeeModel = new Employee($db);
$productServiceModel = new ProductService($db);
$complaintTypeModel = new ComplaintType($db);
$complaintModel = new Complaint($db);

$customers = $customerModel->getAllCustomers();
$employees = $employeeModel->getAllEmployees();
$productServices = $productServiceModel->getAllProductServices();
$complaintTypes = $complaintTypeModel->getAllComplaintTypes();
$complaints = $complaintModel->getAllComplaints();
$openComplaints = $complaintModel->getOpenComplaints();
$unassignedComplaints = $complaintModel->getUnassignedOpenComplaints();
$technicianCounts = $complaintModel->getTechnicianOpenComplaintCounts();
?>

<h2>Week 3 Database Support</h2>

<p class="success">Database model classes loaded successfully.</p>

<p>
    This page now uses PHP model classes to retrieve data from the MySQL database.
    The models represent the main database tables and include CRUD-style methods for
    customers, employees, products/services, complaint types, complaints, and technician notes.
</p>

<section class="card-container">
    <div class="card">
        <h3>Customers</h3>
        <p>Total Customers: <?php echo count($customers); ?></p>
    </div>

    <div class="card">
        <h3>Employees</h3>
        <p>Total Employees: <?php echo count($employees); ?></p>
    </div>

    <div class="card">
        <h3>Products / Services</h3>
        <p>Total Products/Services: <?php echo count($productServices); ?></p>
    </div>

    <div class="card">
        <h3>Complaint Types</h3>
        <p>Total Complaint Types: <?php echo count($complaintTypes); ?></p>
    </div>

    <div class="card">
        <h3>Complaints</h3>
        <p>Total Complaints: <?php echo count($complaints); ?></p>
    </div>

    <div class="card">
        <h3>Open Complaints</h3>
        <p>Total Open Complaints: <?php echo count($openComplaints); ?></p>
    </div>

    <div class="card">
        <h3>Unassigned Complaints</h3>
        <p>Total Unassigned Open Complaints: <?php echo count($unassignedComplaints); ?></p>
    </div>
</section>

<h2>Open Complaints</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Customer</th>
        <th>Product/Service</th>
        <th>Type</th>
        <th>Status</th>
        <th>Assigned Technician</th>
    </tr>

    <?php foreach ($openComplaints as $complaint) : ?>
        <tr>
            <td><?php echo htmlspecialchars($complaint["complaint_id"]); ?></td>
            <td>
                <?php
                    echo htmlspecialchars(
                        $complaint["customer_first_name"] . " " . $complaint["customer_last_name"]
                    );
                ?>
            </td>
            <td><?php echo htmlspecialchars($complaint["product_service_name"]); ?></td>
            <td><?php echo htmlspecialchars($complaint["complaint_type_name"]); ?></td>
            <td><?php echo htmlspecialchars($complaint["complaint_status"]); ?></td>
            <td>
                <?php
                    if (!empty($complaint["technician_first_name"])) {
                        echo htmlspecialchars(
                            $complaint["technician_first_name"] . " " . $complaint["technician_last_name"]
                        );
                    } else {
                        echo "Unassigned";
                    }
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<h2>Technician Open Complaint Counts</h2>

<table>
    <tr>
        <th>Technician</th>
        <th>User ID</th>
        <th>Open Complaint Count</th>
    </tr>

    <?php foreach ($technicianCounts as $technician) : ?>
        <tr>
            <td>
                <?php
                    echo htmlspecialchars(
                        $technician["first_name"] . " " . $technician["last_name"]
                    );
                ?>
            </td>
            <td><?php echo htmlspecialchars($technician["user_id"]); ?></td>
            <td><?php echo htmlspecialchars($technician["open_complaint_count"]); ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<?php include "includes/footer.php"; ?>