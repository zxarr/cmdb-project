<?php
require 'db.php';

// Fetch CI Data
if (isset($_GET['id'])) {
    $ci_id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM configuration_items WHERE id = ?");
    $stmt->execute([$ci_id]);
    $ci = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$ci) {
        die("Configuration Item not found.");
    }
} else {
    die("No CI ID provided.");
}

// Fetch Dropdown Data
$ci_types = $pdo->query("SELECT id, name FROM ci_types")->fetchAll(PDO::FETCH_ASSOC);
$locations = $pdo->query("SELECT id, name FROM locations")->fetchAll(PDO::FETCH_ASSOC);
$vendors = $pdo->query("SELECT id, name FROM vendors")->fetchAll(PDO::FETCH_ASSOC);

// Handle Save Changes
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $update_query = "
        UPDATE configuration_items SET 
        name = ?, description = ?, status = ?, owner = ?, location = ?, ip_address = ?, 
        os_version = ?, serial_number = ?, vendor = ?, purchase_date = ?, warranty_expiry = ?, 
        ci_category = ?, contract = ?, os_type = ?, service = ?, support_group = ?, 
        application_support_group = ?, vendor_support = ? 
        WHERE id = ?
    ";

    $stmt = $pdo->prepare($update_query);
    $stmt->execute([
        $_POST['name'], $_POST['description'], $_POST['status'], $_POST['owner'],
        $_POST['location_id'], $_POST['ip_address'], $_POST['os_version'], $_POST['serial_number'],
        $_POST['vendor_id'], $_POST['purchase_date'], $_POST['warranty_expiry'], $_POST['ci_category'],
        $_POST['contract'], $_POST['os_type'], $_POST['service'], $_POST['support_group'],
        $_POST['application_support_group'], $_POST['vendor_support'], $ci_id
    ]);

    header("Location: view_ci.php?id=$ci_id");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>CI Details - <?= htmlspecialchars($ci['name']) ?></title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script>
        function toggleEditMode() {
            const form = document.getElementById("ciForm");
            const inputs = form.querySelectorAll("input, select, textarea");
            const locked = document.getElementById("lockIcon").classList.toggle("unlocked");

            inputs.forEach(input => {
                input.disabled = !locked;
            });

            document.getElementById("saveButton").style.display = locked ? "inline" : "none";
        }
    </script>
</head>
<body>

<h2>Configuration Item Details</h2>

<div class="lock-icon" id="lockIcon" onclick="toggleEditMode()">🔒</div>

<form method="POST" id="ciForm">
    <label>Name:</label>
    <input type="text" name="name" value="<?= htmlspecialchars($ci['name']) ?>" disabled>

    <label>Description:</label>
    <textarea name="description" disabled><?= htmlspecialchars($ci['description']) ?></textarea>

    <label>CI Type:</label>
    <select name="ci_type_id" disabled>
        <?php foreach ($ci_types as $type): ?>
            <option value="<?= $type['id'] ?>" <?= $type['id'] == $ci['ci_type_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($type['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Category:</label>
    <select name="ci_category" disabled>
        <option value="Physical" <?= $ci['ci_category'] == 'Physical' ? 'selected' : '' ?>>Physical</option>
        <option value="Virtual" <?= $ci['ci_category'] == 'Virtual' ? 'selected' : '' ?>>Virtual</option>
    </select>

    <label>Location:</label>
    <select name="location_id" disabled>
        <?php foreach ($locations as $location): ?>
            <option value="<?= $location['id'] ?>" <?= $location['id'] == $ci['location'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($location['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Vendor:</label>
    <select name="vendor_id" disabled>
        <?php foreach ($vendors as $vendor): ?>
            <option value="<?= $vendor['id'] ?>" <?= $vendor['id'] == $ci['vendor'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($vendor['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Vendor Support:</label>
    <select name="vendor_support" disabled>
        <?php foreach ($vendors as $vendor): ?>
            <option value="<?= $vendor['id'] ?>" <?= $vendor['id'] == $ci['vendor_support'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($vendor['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>IP Address:</label>
    <input type="text" name="ip_address" value="<?= htmlspecialchars($ci['ip_address']) ?>" disabled>

    <label>OS Version:</label>
    <input type="text" name="os_version" value="<?= htmlspecialchars($ci['os_version']) ?>" disabled>

    <label>Serial Number:</label>
    <input type="text" name="serial_number" value="<?= htmlspecialchars($ci['serial_number']) ?>" disabled>

    <label>Contract:</label>
    <input type="text" name="contract" value="<?= htmlspecialchars($ci['contract']) ?>" disabled>

    <label>Purchase Date:</label>
    <input type="date" name="purchase_date" value="<?= htmlspecialchars($ci['purchase_date']) ?>" disabled>

    <label>Warranty Expiry:</label>
    <input type="date" name="warranty_expiry" value="<?= htmlspecialchars($ci['warranty_expiry']) ?>" disabled>

    <br>
    <button type="submit" id="saveButton" style="display:none;">Save Changes</button>
</form>

<br>
<a href="index.php">← Back to CI List</a>

</body>
</html>
