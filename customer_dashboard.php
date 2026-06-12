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

<p>
    <a href="create_complaint.php">Create New Complaint</a> |
    <a href="logout.php">Logout</a>
</p>

<h3>My Complaints</h3>

<table>
    <tr>
        <th>ID</th>
        <th>Product/Service</th>
        <th>Type</th>
        <th>Status</th>
        <th>Technician</th>
        <th>Resolution Notes</th>
        <th>Image</th>
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
            <td>
                <?php
                    echo !empty($complaint["resolution_notes"])
                        ? htmlspecialchars($complaint["resolution_notes"])
                        : "No resolution notes yet.";
                ?>
            </td>
            <td>
                <?php if (!empty($complaint["image_path"])) : ?>
                    <a href="<?php echo htmlspecialchars($complaint["image_path"]); ?>" target="_blank">View Image</a>
                <?php else : ?>
                    No image
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php include "includes/footer.php"; ?>