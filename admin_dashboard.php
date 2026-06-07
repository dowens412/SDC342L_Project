<?php
require_once "auth/session.php";
require_once "config/database.php";
require_once "model/Customer.php";
require_once "model/Employee.php";
require_once "model/Complaint.php";

requireRole("Administrator");

include "includes/header.php";

$customerModel = new Customer($db);
$employeeModel = new Employee($db);
$complaintModel = new Complaint($db);

$customers = $customerModel->getAllCustomers();
$employees = $employeeModel->getAllEmployees();
$openComplaints = $complaintModel->getOpenComplaints();
$unassignedComplaints = $complaintModel->getUnassignedOpenComplaints();
$technicianCounts = $complaintModel->getTechnicianOpenComplaintCounts();
?>

<h2>Administrator Dashboard</h2>

<p class="success">Welcome, <?php echo htmlspecialchars(getUserFullName()); ?>.</p>

<p>This page is protected. Only logged-in administrators can view it.</p>

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
        <h3>Open Complaints</h3>
        <p>Total Open Complaints: <?php echo count($openComplaints); ?></p>
    </div>

    <div class="card">
        <h3>Unassigned Complaints</h3>
        <p>Total Unassigned Complaints: <?php echo count($unassignedComplaints); ?></p>
    </div>
</section>

<h3>Open Complaints</h3>

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
            <td><?php echo htmlspecialchars($complaint["customer_first_name"] . " " . $complaint["customer_last_name"]); ?></td>
            <td><?php echo htmlspecialchars($complaint["product_service_name"]); ?></td>
            <td><?php echo htmlspecialchars($complaint["complaint_type_name"]); ?></td>
            <td><?php echo htmlspecialchars($complaint["complaint_status"]); ?></td>
            <td>
                <?php
                    if (!empty($complaint["technician_first_name"])) {
                        echo htmlspecialchars($complaint["technician_first_name"] . " " . $complaint["technician_last_name"]);
                    } else {
                        echo "Unassigned";
                    }
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<h3>Technician Workload</h3>

<table>
    <tr>
        <th>Technician</th>
        <th>User ID</th>
        <th>Open Complaint Count</th>
    </tr>

    <?php foreach ($technicianCounts as $technician) : ?>
        <tr>
            <td><?php echo htmlspecialchars($technician["first_name"] . " " . $technician["last_name"]); ?></td>
            <td><?php echo htmlspecialchars($technician["user_id"]); ?></td>
            <td><?php echo htmlspecialchars($technician["open_complaint_count"]); ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<p><a href="logout.php">Logout</a></p>

<?php include "includes/footer.php"; ?>