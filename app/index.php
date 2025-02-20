<?php
// Database Connection
require 'db.php';

// Fetch configuration items
$items = $pdo->query("SELECT ci.id, ci.name, ct.name as type, ci.status FROM configuration_items ci JOIN ci_types ct ON ci.ci_type_id = ct.id ORDER BY ci.id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
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
    
    <button onclick="window.location.href='add_ci.php'">Add New CI</button>
    
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
