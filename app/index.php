<?php
// Database Connection
require 'db.php';

// Fetch configuration items
$items = $pdo->query("SELECT ci.id, ci.name, ci.description, ci.service, ci.os_type, ci.os_version, ci.owner, ci.contract FROM configuration_items ci ORDER BY ci.id DESC")->fetchAll(PDO::FETCH_ASSOC);

// Define available fields
$available_fields = ['name', 'description', 'service', 'os_type', 'os_version', 'owner', 'contract'];
$selected_fields = isset($_GET['fields']) ? explode(',', $_GET['fields']) : $available_fields;
?>

<!DOCTYPE html>
<html>
<head>
    <title>CMDB System</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
    </style>
    <script>
        function toggleField(field) {
            let urlParams = new URLSearchParams(window.location.search);
            let fields = urlParams.get('fields') ? urlParams.get('fields').split(',') : [<?php echo implode(',', array_map(fn($f) => "'" . $f . "'", $available_fields)); ?>];
            
            if (fields.includes(field)) {
                fields = fields.filter(f => f !== field);
            } else {
                fields.push(field);
            }
            
            urlParams.set('fields', fields.join(','));
            window.location.search = urlParams.toString();
        }
    </script>
</head>
<body>
    <h2>Configuration Management Database</h2>
    
    <button onclick="window.location.href='add_ci.php'">Add New CI</button>
    
    <h3>Toggle Fields</h3>
    <?php foreach ($available_fields as $field) { ?>
        <input type="checkbox" onchange="toggleField('<?php echo $field; ?>')" <?php echo in_array($field, $selected_fields) ? 'checked' : ''; ?>> <?php echo ucfirst(str_replace('_', ' ', $field)); ?>
    <?php } ?>
    
    <h3>Configuration Items</h3>
    <table>
        <tr>
            <?php foreach ($selected_fields as $field) { ?>
                <th><?php echo ucfirst(str_replace('_', ' ', $field)); ?></th>
            <?php } ?>
        </tr>
        <?php foreach ($items as $item) { ?>
            <tr>
                <?php foreach ($selected_fields as $field) { ?>
                    <td><?php echo $item[$field] ?? ''; ?></td>
                <?php } ?>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
