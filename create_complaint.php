<?php
require_once "auth/session.php";
require_once "config/database.php";
require_once "model/ProductService.php";
require_once "model/ComplaintType.php";
require_once "model/Complaint.php";
require_once "includes/activity_logger.php";

requireRole("customer");

$productServiceModel = new ProductService($db);
$complaintTypeModel = new ComplaintType($db);
$complaintModel = new Complaint($db);

$productServices = $productServiceModel->getActiveProductServices();
$complaintTypes = $complaintTypeModel->getActiveComplaintTypes();

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $product_service_id = $_POST["product_service_id"] ?? "";
    $complaint_type_id = $_POST["complaint_type_id"] ?? "";
    $complaint_description = trim($_POST["complaint_description"] ?? "");
    $image_path = null;

    if (empty($product_service_id) || empty($complaint_type_id) || empty($complaint_description)) {
        $error = "Product/service, complaint type, and description are required.";
    } elseif (strlen($complaint_description) < 10) {
        $error = "Complaint description must be at least 10 characters.";
    } else {
        if (isset($_FILES["complaint_image"]) && $_FILES["complaint_image"]["error"] !== UPLOAD_ERR_NO_FILE) {
            $allowedTypes = ["image/jpeg", "image/png", "image/gif"];
            $maxSize = 5 * 1024 * 1024;

            if ($_FILES["complaint_image"]["error"] !== UPLOAD_ERR_OK) {
                $error = "There was an error uploading the image.";
            } elseif (!in_array($_FILES["complaint_image"]["type"], $allowedTypes)) {
                $error = "Only JPG, PNG, and GIF images are allowed.";
            } elseif ($_FILES["complaint_image"]["size"] > $maxSize) {
                $error = "Image must be less than 5MB.";
            } else {
                $extension = pathinfo($_FILES["complaint_image"]["name"], PATHINFO_EXTENSION);
                $newFileName = "complaint_" . time() . "_" . uniqid() . "." . $extension;
                $uploadPath = "uploads/" . $newFileName;

                if (move_uploaded_file($_FILES["complaint_image"]["tmp_name"], $uploadPath)) {
                    $image_path = $uploadPath;
                } else {
                    $error = "Could not save uploaded image.";
                }
            }
        }

        if (empty($error)) {
            $created = $complaintModel->createComplaint(
                $_SESSION["user_id"],
                $product_service_id,
                $complaint_type_id,
                $complaint_description,
                $image_path
            );

            if ($created) {
                writeActivityLog("Customer ID " . $_SESSION["user_id"] . " created a new complaint.");
                $success = "Complaint submitted successfully.";
            } else {
                $error = "Complaint could not be submitted.";
            }
        }
    }
}

include "includes/header.php";
?>

<h2>Create Complaint</h2>

<?php if (!empty($error)) : ?>
    <p class="error"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<?php if (!empty($success)) : ?>
    <p class="success"><?php echo htmlspecialchars($success); ?></p>
<?php endif; ?>

<form method="POST" action="create_complaint.php" enctype="multipart/form-data">
    <label for="product_service_id">Product/Service</label>
    <select name="product_service_id" id="product_service_id" required>
        <option value="">Select Product/Service</option>
        <?php foreach ($productServices as $service) : ?>
            <option value="<?php echo htmlspecialchars($service["product_service_id"]); ?>">
                <?php echo htmlspecialchars($service["product_service_name"]); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="complaint_type_id">Complaint Type</label>
    <select name="complaint_type_id" id="complaint_type_id" required>
        <option value="">Select Complaint Type</option>
        <?php foreach ($complaintTypes as $type) : ?>
            <option value="<?php echo htmlspecialchars($type["complaint_type_id"]); ?>">
                <?php echo htmlspecialchars($type["complaint_type_name"]); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="complaint_description">Complaint Description</label>
    <textarea name="complaint_description" id="complaint_description" rows="5" required></textarea>

    <label for="complaint_image">Upload Image</label>
    <input type="file" name="complaint_image" id="complaint_image" accept="image/jpeg,image/png,image/gif">

    <button type="submit">Submit Complaint</button>
</form>

<p><a href="customer_dashboard.php">Back to Dashboard</a></p>

<?php include "includes/footer.php"; ?>