<?php
// Database Connection
require 'db.php';

// Handle adding a new configuration item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['ci_type_id'], $_POST['owner'], $_POST['ci_category'])) {
    $stmt = $pdo->prepare("INSERT INTO configuration_items 
        (name, ci_type_id, description, status, owner, location, ip_address, os_version, serial_number, vendor, purchase_date, warranty_expiry, ci_category, contract, os_type, service, support_group, application_support_group, vendor_support) 
        VALUES (?, ?, ?, 'Active', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['name'], 
        $_POST['ci_type_id'], 
        $_POST['description'], 
        $_POST['owner'],
        $_POST['location'],
        $_POST['ip_address'],
        $_POST['os_version'],
        $_POST['serial_number'],
        $_POST['vendor'],
        $_POST['purchase_date'],
        $_POST['warranty_expiry'],
        $_POST['ci_category'],
        $_POST['contract'],
        $_POST['os_type'],
        $_POST['service'],
        $_POST['support_group'],
        $_POST['application_support_group'],
        $_POST['vendor_support']
    ]);
    header("Location: index.php");
    exit;
}



// Fetch CI types for dropdown
$ci_types = $pdo->query("SELECT id, name FROM ci_types")->fetchAll(PDO::FETCH_ASSOC);

// Fetch locations for dropdown
$locations = $pdo->query("SELECT id, name FROM locations")->fetchAll(PDO::FETCH_ASSOC);

// Fetch vendors for dropdown
$vendors = $pdo->query("SELECT id, name FROM vendors")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Configuration Item</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h2>Add New Configuration Item</h2>
    
    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" placeholder="Item Name" required>

        <label>CI Type:</label>
        <select name="ci_type_id" required>
            <option value="">Select Type</option>
            <?php foreach ($ci_types as $type) { ?>
                <option value="<?php echo $type['id']; ?>"><?php echo $type['name']; ?></option>
            <?php } ?>
        </select>

        <label>Description:</label>
        <input type="text" name="description" required>

        <label>Category:</label>
        <select name="ci_category" required>
            <option value="">Select Category</option>
            <option value="Physical">Physical</option>
            <option value="Virtual">Virtual</option>
        </select>

        <label>Owner:</label>
        <input type="text" name="owner" placeholder="Owner" required>

        <label>Location:</label>
        <select name="location_id">
            <?php foreach ($locations as $location) { ?>
                <option value="<?php echo $location['id']; ?>"><?php echo $location['name']; ?></option>
            <?php } ?>
        </select>

        <label>IP Address:</label>
        <input type="text" name="ip_address" placeholder="IP Address">

        <label>OS Version:</label>
        <input type="text" name="os_version" placeholder="OS Version">

        <label>Serial Number:</label>
        <input type="text" name="serial_number" placeholder="Serial Number">

        <label>Vendor:</label>
        <select name="vendor_id">
            <?php foreach ($vendors as $vendor) { ?>
                <option value="<?php echo $vendor['id']; ?>"><?php echo $vendor['name']; ?></option>
            <?php } ?>
        </select>

        <label>Contract:</label>
        <input type="text" name="contract" placeholder="Contract">

        <label>OS Type:</label>
        <input type="text" name="os_type" placeholder="OS Type">

        <label>Service:</label>
        <input type="text" name="service" placeholder="Service">

        <label>Support Group:</label>
        <input type="text" name="support_group" placeholder="Support Group">

        <label>Application Support Group:</label>
        <input type="text" name="application_support_group" placeholder="Application Support Group">

        <label>Vendor Support:</label>
        <select name="vendor_support">
            <option value="">Select Vendor</option>
            <?php foreach ($vendors as $vendor) { ?>
                <option value="<?php echo $vendor['id']; ?>"><?php echo $vendor['name']; ?></option>
            <?php } ?>
        </select>

        <label>Purchase Date:</label>
        <input type="date" name="purchase_date">

        <label>Warranty Expiry:</label>
        <input type="date" name="warranty_expiry">

        <button type="submit">Add Item</button>
    </form>

    <br>
    <button onclick="window.location.href='index.php'">Back to CMDB</button>
</body>
</html>
