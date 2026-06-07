<?php
require_once "auth/session.php";
require_once "config/database.php";
require_once "model/Complaint.php";

requireRole("customer");

include "includes/header.php";

$complaintModel = new Complaint($db);
$complaints = $complaintModel->getComplaintsByCustomerId($_SESSION["user_id"]);
?>

<h2>Customer Dashboard</h2>

<p class="success">Welcome, <?php echo htmlspecialchars(getUserFullName()); ?>.</p>

<p>This page is protected. Only logged-in customers can view it.</p>

<h3>My Complaints</h3>

<table>
    <tr>
        <th>ID</th>
        <th>Product/Service</th>
        <th>Type</th>
        <th>Status</th>
        <th>Technician</th>
    </tr>

    <?php foreach ($complaints as $complaint) : ?>
        <tr>
            <td><?php echo htmlspecialchars($complaint["complaint_id"]); ?></td>
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

<p><a href="logout.php">Logout</a></p>

<?php include "includes/footer.php"; ?>