<?php
require_once "auth/session.php";
require_once "config/database.php";
require_once "model/Complaint.php";

requireRole("Technician");

include "includes/header.php";

$complaintModel = new Complaint($db);
$complaints = $complaintModel->getComplaintsByTechnicianId($_SESSION["user_id"]);
?>

<h2>Technician Dashboard</h2>

<p class="success">Welcome, <?php echo htmlspecialchars(getUserFullName()); ?>.</p>

<p>This page is protected. Only logged-in technicians can view it.</p>

<h3>Assigned Complaints</h3>

<table>
    <tr>
        <th>ID</th>
        <th>Customer</th>
        <th>Product/Service</th>
        <th>Type</th>
        <th>Status</th>
        <th>Date Created</th>
    </tr>

    <?php foreach ($complaints as $complaint) : ?>
        <tr>
            <td><?php echo htmlspecialchars($complaint["complaint_id"]); ?></td>
            <td><?php echo htmlspecialchars($complaint["customer_first_name"] . " " . $complaint["customer_last_name"]); ?></td>
            <td><?php echo htmlspecialchars($complaint["product_service_name"]); ?></td>
            <td><?php echo htmlspecialchars($complaint["complaint_type_name"]); ?></td>
            <td><?php echo htmlspecialchars($complaint["complaint_status"]); ?></td>
            <td><?php echo htmlspecialchars($complaint["created_at"]); ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<p><a href="logout.php">Logout</a></p>

<?php include "includes/footer.php"; ?>