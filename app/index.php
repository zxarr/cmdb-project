<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" 
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>CMDB System</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h2>Configuration Management Database</h2>
    
    <h3>Add Configuration Item</h3>
    <form method="POST">
        <input type="text" name="name" placeholder="Item Name" required>
        <select name="ci_type_id" required>
            <option value="">Select Type</option>
            <?php foreach ($ci_types as $type) { ?>
                <option value="<?php echo $type['id']; ?>"><?php echo $type['name']; ?></option>
            <?php } ?>
        </select>
        <input type="text" name="owner" placeholder="Owner" required>
        <input type="text" name="location" placeholder="Location">
        <input type="text" name="ip_address" placeholder="IP Address">
        <input type="text" name="os_version" placeholder="OS Version">
        <input type="text" name="serial_number" placeholder="Serial Number">
        <input type="text" name="vendor" placeholder="Vendor">
        <input type="date" name="purchase_date">
        <input type="date" name="warranty_expiry">
        <button type="submit">Add Item</button>
    </form>

    <h3>Add Note to a CI</h3>
    <form method="POST">
        <select name="ci_id" required>
            <option value="">Select Configuration Item</option>
            <?php foreach ($items as $item) { ?>
                <option value="<?php echo $item['id']; ?>"><?php echo $item['name']; ?></option>
            <?php } ?>
        </select>
        <textarea name="note" placeholder="Enter your note here" required></textarea>
        <button type="submit" name="add_note">Add Note</button>
    </form>

    <h3>Configuration Items</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Type</th>
            <th>Status</th>
            <th>Notes</th>
        </tr>
        <?php foreach ($items as $item) { ?>
            <tr>
                <td><?php echo $item['id']; ?></td>
                <td><?php echo $item['name']; ?></td>
                <td><?php echo $item['type']; ?></td>
                <td><?php echo $item['status']; ?></td>
                <td>
                    <?php
                    $stmt = $pdo->prepare("SELECT note, created_at FROM ci_notes WHERE ci_id = ?");
                    $stmt->execute([$item['id']]);
                    $notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if ($notes) {
                        foreach ($notes as $note) {
                            echo "<p><b>{$note['created_at']}</b>: {$note['note']}</p>";
                        }
                    } else {
                        echo "No notes.";
                    }
                    ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>


<?php
// Database Connection
$host = getenv('DB_HOST') ?: 'localhost';
$dbname = getenv('DB_NAME') ?: 'cmdb';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Handle adding a new configuration item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['ci_type_id'], $_POST['owner'])) {
    $stmt = $pdo->prepare("INSERT INTO configuration_items 
        (name, ci_type_id, description, status, owner, location, ip_address, os_version, serial_number, vendor, purchase_date, warranty_expiry) 
        VALUES (?, ?, ?, 'Active', ?, ?, ?, ?, ?, ?, ?, ?)");
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
        $_POST['warranty_expiry']
    ]);
    header("Location: index.php");
    exit;
}

// Handle adding a new note
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_note'], $_POST['ci_id'], $_POST['note'])) {
    $stmt = $pdo->prepare("INSERT INTO ci_notes (ci_id, note) VALUES (?, ?)");
    $stmt->execute([$_POST['ci_id'], $_POST['note']]);
    header("Location: index.php");
    exit;
}

// Fetch configuration items
$items = $pdo->query("SELECT ci.id, ci.name, ct.name as type, ci.status FROM configuration_items ci JOIN ci_types ct ON ci.ci_type_id = ct.id ORDER BY ci.id DESC")->fetchAll(PDO::FETCH_ASSOC);

// Fetch CI types for dropdown
$ci_types = $pdo->query("SELECT * FROM ci_types")->fetchAll(PDO::FETCH_ASSOC);
?>

