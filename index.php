<?php
require_once "config/database.php";
include "includes/header.php";

// Get counts from database to confirm connection and framework are working
$customerCount = $db->query("SELECT COUNT(*) FROM customers")->fetchColumn();
$employeeCount = $db->query("SELECT COUNT(*) FROM employees")->fetchColumn();
$productCount = $db->query("SELECT COUNT(*) FROM products_services")->fetchColumn();
$typeCount = $db->query("SELECT COUNT(*) FROM complaint_types")->fetchColumn();
$complaintCount = $db->query("SELECT COUNT(*) FROM complaints")->fetchColumn();
?>

<h2>Week 2 Application Framework</h2>

<p class="success">Database connection successful.</p>

<p>
    This application will be used to manage customer complaints, assign complaints to technicians,
    and allow administrators to manage customers, employees, and complaint assignments.
</p>

<section class="card-container">
    <div class="card">
        <h3>Customers</h3>
        <p>Total Customers: <?php echo $customerCount; ?></p>
    </div>

    <div class="card">
        <h3>Employees</h3>
        <p>Total Employees: <?php echo $employeeCount; ?></p>
    </div>

    <div class="card">
        <h3>Products / Services</h3>
        <p>Total Products/Services: <?php echo $productCount; ?></p>
    </div>

    <div class="card">
        <h3>Complaint Types</h3>
        <p>Total Complaint Types: <?php echo $typeCount; ?></p>
    </div>

    <div class="card">
        <h3>Complaints</h3>
        <p>Total Complaints: <?php echo $complaintCount; ?></p>
    </div>
</section>

<?php include "includes/footer.php"; ?>