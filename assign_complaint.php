<?php
require_once "auth/session.php";
require_once "config/database.php";
require_once "model/Complaint.php";
require_once "model/Employee.php";
require_once "includes/activity_logger.php";

requireRole("Administrator");

$complaintModel = new Complaint($db);
$employeeModel = new Employee($db);

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $complaint_id = $_POST["complaint_id"] ?? "";
    $employee_id = $_POST["employee_id"] ?? "";

    if (empty($complaint_id) || empty($employee_id)) {
        $error = "Complaint and technician are required.";
    } else {
        $assigned = $complaintModel->assignComplaint($complaint_id, $employee_id);

        if ($assigned) {
            writeActivityLog("Administrator ID " . $_SESSION["user_id"] . " assigned complaint #" . $complaint_id . " to technician ID " . $employee_id . ".");
            $success = "Complaint assigned successfully.";
        } else {
            $error = "Complaint could not be assigned.";
        }
    }
}

$unassignedComplaints = $complaintModel->getUnassignedOpenComplaints();
$technicians = $employeeModel->getTechnicians();

include "includes/header.php";
?>

<h2>Assign Complaint</h2>

<?php if (!empty($error)) : ?>
    <p class="error"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<?php if (!empty($success)) : ?>
    <p class="success"><?php echo htmlspecialchars($success); ?></p>
<?php endif; ?>

<form method="POST" action="assign_complaint.php">
    <label for="complaint_id">Unassigned Complaint</label>
    <select name="complaint_id" id="complaint_id" required>
        <option value="">Select Complaint</option>
        <?php foreach ($unassignedComplaints as $complaint) : ?>
            <option value="<?php echo htmlspecialchars($complaint["complaint_id"]); ?>">
                Complaint #<?php echo htmlspecialchars($complaint["complaint_id"]); ?> -
                <?php echo htmlspecialchars($complaint["customer_first_name"] . " " . $complaint["customer_last_name"]); ?> -
                <?php echo htmlspecialchars($complaint["product_service_name"]); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="employee_id">Technician</label>
    <select name="employee_id" id="employee_id" required>
        <option value="">Select Technician</option>
        <?php foreach ($technicians as $technician) : ?>
            <option value="<?php echo htmlspecialchars($technician["employee_id"]); ?>">
                <?php echo htmlspecialchars($technician["first_name"] . " " . $technician["last_name"]); ?>
                (<?php echo htmlspecialchars($technician["user_id"]); ?>)
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Assign Complaint</button>
</form>

<h3>Unassigned Open Complaints</h3>

<table>
    <tr>
        <th>ID</th>
        <th>Customer</th>
        <th>Product/Service</th>
        <th>Type</th>
        <th>Status</th>
    </tr>

    <?php foreach ($unassignedComplaints as $complaint) : ?>
        <tr>
            <td><?php echo htmlspecialchars($complaint["complaint_id"]); ?></td>
            <td><?php echo htmlspecialchars($complaint["customer_first_name"] . " " . $complaint["customer_last_name"]); ?></td>
            <td><?php echo htmlspecialchars($complaint["product_service_name"]); ?></td>
            <td><?php echo htmlspecialchars($complaint["complaint_type_name"]); ?></td>
            <td><?php echo htmlspecialchars($complaint["complaint_status"]); ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<p><a href="admin_dashboard.php">Back to Admin Dashboard</a></p>

<?php include "includes/footer.php"; ?>