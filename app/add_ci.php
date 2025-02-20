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
$ci_types = $pdo->query("SELECT * FROM ci_types")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Configuration Item</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h2>Add New Configuration Item</h2>
    
    <form method="POST">
        <select name="name" placeholder="Item Name" required>
            <option value="Server">Server</option>
            <option value="Appliance">Appliance</option>
            <?php foreach ($ci_types as $type) { ?>
                <option value="<?php echo $type['id']; ?>"><?php echo $type['name']; ?></option>
            <?php } ?>
        </select>
        <select name="ci_category" required>
            <option value="">Select Category</option>
            <option value="Physical">Physical</option>
            <option value="Virtual">Virtual</option>
        </select>
        <input type="text" name="owner" placeholder="Owner" required>
        <input type="text" name="location" placeholder="Location">
        <input type="text" name="ip_address" placeholder="IP Address">
        <input type="text" name="os_version" placeholder="OS Version">
        <input type="text" name="serial_number" placeholder="Serial Number">
        <input type="text" name="vendor" placeholder="Vendor">
        <input type="text" name="contract" placeholder="Contract">
        <input type="text" name="os_type" placeholder="OS Type">
        <input type="text" name="service" placeholder="Service">
        <input type="text" name="support_group" placeholder="Support Group">
        <input type="text" name="application_support_group" placeholder="Application Support Group">
        <input type="text" name="vendor_support" placeholder="Vendor Support">
        <input type="date" name="purchase_date">
        <input type="date" name="warranty_expiry">
        <button type="submit">Add Item</button>
    </form>

    <br>
    <button onclick="window.location.href='index.php'">Back to CMDB</button>
</body>
</html>
