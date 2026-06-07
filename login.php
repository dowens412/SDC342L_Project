<?php
require_once "config/database.php";
require_once "auth/session.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $login_id = trim($_POST["login_id"]);
    $password = $_POST["password"];
    $user_type = $_POST["user_type"];

    if (empty($login_id) || empty($password) || empty($user_type)) {
        $error = "All fields are required.";
    } else {
        if ($user_type === "customer") {
            $query = "SELECT customer_id, email, first_name, last_name, password_hash
                      FROM customers
                      WHERE email = :login_id";

            $statement = $db->prepare($query);
            $statement->bindValue(":login_id", $login_id);
            $statement->execute();
            $user = $statement->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user["password_hash"])) {
                $_SESSION["user_id"] = $user["customer_id"];
                $_SESSION["user_type"] = "customer";
                $_SESSION["first_name"] = $user["first_name"];
                $_SESSION["last_name"] = $user["last_name"];

                header("Location: customer_dashboard.php");
                exit();
            } else {
                $error = "Invalid customer login.";
            }
        } else {
            $query = "SELECT employee_id, user_id, first_name, last_name, employee_level, password_hash
                      FROM employees
                      WHERE user_id = :login_id";

            $statement = $db->prepare($query);
            $statement->bindValue(":login_id", $login_id);
            $statement->execute();
            $user = $statement->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user["password_hash"])) {
                $_SESSION["user_id"] = $user["employee_id"];
                $_SESSION["user_type"] = $user["employee_level"];
                $_SESSION["first_name"] = $user["first_name"];
                $_SESSION["last_name"] = $user["last_name"];

                if ($user["employee_level"] === "Administrator") {
                    header("Location: admin_dashboard.php");
                } else {
                    header("Location: technician_dashboard.php");
                }
                exit();
            } else {
                $error = "Invalid employee login.";
            }
        }
    }
}

include "includes/header.php";
?>

<h2>Login</h2>

<?php if (!empty($error)) : ?>
    <p class="error"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<form method="POST" action="login.php">
    <label for="user_type">Account Type</label>
    <select name="user_type" id="user_type" required>
        <option value="">Select account type</option>
        <option value="customer">Customer</option>
        <option value="employee">Employee</option>
    </select>

    <label for="login_id">Email or User ID</label>
    <input type="text" name="login_id" id="login_id" required>

    <label for="password">Password</label>
    <input type="password" name="password" id="password" required>

    <button type="submit">Login</button>
</form>

<?php include "includes/footer.php"; ?>