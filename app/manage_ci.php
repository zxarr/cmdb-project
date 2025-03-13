<?php
require 'db.php';

// Detect Mode: View or Edit
if (!isset($_GET['id'])) {
    die("No Configuration Item specified.");
}

$ci_id = $_GET['id'];
$ci = $pdo->prepare("SELECT * FROM configuration_items WHERE id = ?");
$ci->execute([$ci_id]);
$ci = $ci->fetch(PDO::FETCH_ASSOC);

if (!$ci) {
    die("Configuration Item not found.");
}

// Fetch Dropdown Data
$ci_types = $pdo->query("SELECT id, name FROM ci_types")->fetchAll(PDO::FETCH_ASSOC);
$locations = $pdo->query("SELECT id, name FROM locations")->fetchAll(PDO::FETCH_ASSOC);
$vendors = $pdo->query("SELECT id, name FROM vendors")->fetchAll(PDO::FETCH_ASSOC);

// Handle Edit Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = "UPDATE configuration_items SET 
    name = ?, ci_type_id = ?, description = ?, owner = ?, location = ?, ip_address = ?, 
    os_version = ?, serial_number = ?, vendor = ?, purchase_date = ?, warranty_expiry = ?, 
    ci_category = ?, contract = ?, os_type = ?, service = ?, support_group = ?, 
    application_support_group = ?, vendor_support = ?, os_support = ?
    WHERE id = ?";


    $stmt = $pdo->prepare($query);
    $stmt->execute([
        $_POST['name'], $_POST['ci_type_id'], $_POST['description'], $_POST['owner'],
        $_POST['location_id'], $_POST['ip_address'], $_POST['os_version'], $_POST['serial_number'],
        $_POST['vendor_id'], $_POST['purchase_date'], $_POST['warranty_expiry'], $_POST['ci_category'],
        $_POST['contract'], $_POST['os_type'], $_POST['os_support'], $_POST['service'], $_POST['support_group'],
        $_POST['application_support_group'], $_POST['vendor_support'], $ci_id
    ]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View/Edit CI - <?= htmlspecialchars($ci['name']) ?></title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script>
        function toggleEditMode() {
            const inputs = document.querySelectorAll(".editable");
            const locked = document.getElementById("lockIcon").classList.toggle("unlocked");

            inputs.forEach(input => {
                input.disabled = !locked;
            });

            document.getElementById("saveButton").style.display = locked ? "inline" : "none";
        }
    </script>
    <style>
        .form-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .lock-icon {
            cursor: pointer;
            font-size: 24px;
            float: right;
        }

        .unlocked {
            color: green;
        }

        input, select, textarea {
            width: 100%;
            box-sizing: border-box;
            padding: 5px;
        }
    </style>
</head>
<body>

<h2>Configuration Item Details</h2>

<div class="lock-icon" id="lockIcon" onclick="toggleEditMode()">🔒</div>

<form method="POST">
    <div class="form-container">
        <label>Name: <input type="text" name="name" value="<?= htmlspecialchars($ci['name']) ?>" class="editable" disabled></label>

        <label>CI Type:
            <select name="ci_type_id" class="editable" disabled>
                <?php foreach ($ci_types as $type): ?>
                    <option value="<?= $type['id'] ?>" <?= ($type['id'] == ($ci['ci_type_id'] ?? '')) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($type['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>

        <label>Description: <textarea name="description" class="editable" disabled><?= htmlspecialchars($ci['description']) ?></textarea></label>

        <label>Owner: <input type="text" name="owner" value="<?= htmlspecialchars($ci['owner']) ?>" class="editable" disabled></label>

        <label>Location:
            <select name="location_id" class="editable" disabled>
                <?php foreach ($locations as $location): ?>
                    <option value="<?= $location['id'] ?>" <?= ($location['id'] == ($ci['location'] ?? '')) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($location['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>

        <label>IP Address: <input type="text" name="ip_address" value="<?= htmlspecialchars($ci['ip_address']) ?>" class="editable" disabled></label>

        <label>OS Version: <input type="text" name="os_version" value="<?= htmlspecialchars($ci['os_version']) ?>" class="editable" disabled></label>

        <label>Serial Number: <input type="text" name="serial_number" value="<?= htmlspecialchars($ci['serial_number']) ?>" class="editable" disabled></label>

        <label>Vendor:
            <select name="vendor_id" class="editable" disabled>
                <?php foreach ($vendors as $vendor): ?>
                    <option value="<?= $vendor['id'] ?>" <?= ($vendor['id'] == ($ci['vendor'] ?? '')) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($vendor['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>

        <label>Purchase Date: <input type="date" name="purchase_date" value="<?= htmlspecialchars($ci['purchase_date']) ?>" class="editable" disabled></label>

        <label>Warranty Expiry: <input type="date" name="warranty_expiry" value="<?= htmlspecialchars($ci['warranty_expiry']) ?>" class="editable" disabled></label>

        <label>Service: <input type="text" name="service" value="<?= htmlspecialchars($ci['service']) ?>" class="editable" disabled></label>

        <label>Support Group: <input type="text" name="support_group" value="<?= htmlspecialchars($ci['support_group']) ?>" class="editable" disabled></label>

        <label>Application Support Group: <input type="text" name="application_support_group" value="<?= htmlspecialchars($ci['application_support_group']) ?>" class="editable" disabled></label>

        <label>Vendor Support: <input type="text" name="vendor_support" value="<?= htmlspecialchars($ci['vendor_support']) ?>" class="editable" disabled></label>
    </div>

    <br>
    <button type="submit" id="saveButton" style="display:none;">Save Changes</button>
</form>

<br>
<a href="index.php">← Back to CI List</a>

</body>
</html>
