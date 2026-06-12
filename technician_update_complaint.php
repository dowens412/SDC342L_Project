<?php
require_once "auth/session.php";
require_once "config/database.php";
require_once "model/Complaint.php";
require_once "model/ComplaintNote.php";
require_once "includes/activity_logger.php";

requireRole("Technician");

$complaintModel = new Complaint($db);
$noteModel = new ComplaintNote($db);

$complaint_id = $_GET["id"] ?? $_POST["complaint_id"] ?? null;

if (empty($complaint_id)) {
    header("Location: technician_dashboard.php");
    exit();
}

$complaint = $complaintModel->getComplaintById($complaint_id);

if (!$complaint || $complaint["assigned_employee_id"] != $_SESSION["user_id"]) {
    header("Location: unauthorized.php");
    exit();
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $note_text = trim($_POST["note_text"] ?? "");
    $resolution_notes = trim($_POST["resolution_notes"] ?? "");
    $mark_resolved = isset($_POST["mark_resolved"]);

    if (!empty($note_text)) {
        $noteModel->createNote($complaint_id, $_SESSION["user_id"], $note_text);
        writeActivityLog("Technician ID " . $_SESSION["user_id"] . " added a note to complaint #" . $complaint_id . ".");
        $success = "Technician note added.";
    }

    if ($mark_resolved) {
        if (empty($resolution_notes)) {
            $error = "Resolution notes are required to resolve the complaint.";
        } else {
            $complaintModel->resolveComplaint($complaint_id, date("Y-m-d"), $resolution_notes);
            writeActivityLog("Technician ID " . $_SESSION["user_id"] . " resolved complaint #" . $complaint_id . ".");
            $success = "Complaint marked as resolved.";
        }
    }

    $complaint = $complaintModel->getComplaintById($complaint_id);
}

$notes = $noteModel->getNotesByComplaintId($complaint_id);

include "includes/header.php";
?>

<h2>Update Complaint</h2>

<?php if (!empty($error)) : ?>
    <p class="error"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<?php if (!empty($success)) : ?>
    <p class="success"><?php echo htmlspecialchars($success); ?></p>
<?php endif; ?>

<h3>Complaint Details</h3>

<p><strong>Customer:</strong> <?php echo htmlspecialchars($complaint["customer_first_name"] . " " . $complaint["customer_last_name"]); ?></p>
<p><strong>Product/Service:</strong> <?php echo htmlspecialchars($complaint["product_service_name"]); ?></p>
<p><strong>Complaint Type:</strong> <?php echo htmlspecialchars($complaint["complaint_type_name"]); ?></p>
<p><strong>Status:</strong> <?php echo htmlspecialchars($complaint["complaint_status"]); ?></p>
<p><strong>Description:</strong> <?php echo htmlspecialchars($complaint["complaint_description"]); ?></p>

<?php if (!empty($complaint["image_path"])) : ?>
    <p><strong>Image:</strong> <a href="<?php echo htmlspecialchars($complaint["image_path"]); ?>" target="_blank">View Image</a></p>
<?php endif; ?>

<form method="POST" action="technician_update_complaint.php">
    <input type="hidden" name="complaint_id" value="<?php echo htmlspecialchars($complaint_id); ?>">

    <label for="note_text">Technician Note</label>
    <textarea name="note_text" id="note_text" rows="4"></textarea>

    <label for="resolution_notes">Resolution Notes</label>
    <textarea name="resolution_notes" id="resolution_notes" rows="4"></textarea>

    <label>
        <input type="checkbox" name="mark_resolved">
        Mark complaint resolved
    </label>

    <button type="submit">Update Complaint</button>
</form>

<h3>Technician Notes</h3>

<?php if (count($notes) === 0) : ?>
    <p>No notes have been added yet.</p>
<?php else : ?>
    <table>
        <tr>
            <th>Date</th>
            <th>Technician</th>
            <th>Note</th>
        </tr>

        <?php foreach ($notes as $note) : ?>
            <tr>
                <td><?php echo htmlspecialchars($note["created_at"]); ?></td>
                <td><?php echo htmlspecialchars($note["first_name"] . " " . $note["last_name"]); ?></td>
                <td><?php echo htmlspecialchars($note["note_text"]); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<p><a href="technician_dashboard.php">Back to Technician Dashboard</a></p>

<?php include "includes/footer.php"; ?>