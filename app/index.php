<?php
// Database Connection
require 'db.php';

// Fetch configuration items
$items = $pdo->query("SELECT * FROM configuration_items ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

// Define all available fields
$available_fields = ['name', 'description', 'service', 'os_type', 'os_version', 'owner', 'contract', 'location', 'ip_address', 'serial_number', 'vendor', 'purchase_date', 'warranty_expiry', 'ci_category', 'support_group', 'application_support_group', 'vendor_support'];
$selected_fields = isset($_GET['fields']) ? explode(',', $_GET['fields']) : ['name', 'description', 'service', 'os_type', 'os_version', 'owner', 'contract'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>CMDB System</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script>
        function togglePopup(show) {
            let popup = document.getElementById("columnPopup");
            if (show) {
                popup.style.display = "block";
            } else {
                popup.style.display = "none";
                applyColumnSelection();
            }
        }

        function toggleField(field) {
            let urlParams = new URLSearchParams(window.location.search);
            let fields = urlParams.get('fields') ? urlParams.get('fields').split(',') : [];
            
            if (fields.includes(field)) {
                fields = fields.filter(f => f !== field);
            } else {
                fields.push(field);
            }
            
            urlParams.set('fields', fields.join(','));
            history.replaceState(null, "", "?" + urlParams.toString());
        }

        function applyColumnSelection() {
            location.reload();
        }
    </script>
</head>
<body>
    <h2>Configuration Management Database</h2>
    
    <div class="top-bar">
        <button onclick="window.location.href='add_ci.php'">Add New CI</button>
        <button onclick="togglePopup(true)">Select Columns</button>
        <button class="config-button" onclick="window.location.href='config_page.php'">Manage Configuration</button>
    </div>

    <div id="columnPopup" class="popup">
        <h3>Select Columns</h3>
        <?php foreach ($available_fields as $field) { ?>
            <input type="checkbox" onchange="toggleField('<?php echo $field; ?>')" <?php echo in_array($field, $selected_fields) ? 'checked' : ''; ?>> <?php echo ucfirst(str_replace('_', ' ', $field)); ?><br>
        <?php } ?>
        <button onclick="togglePopup(false)">Done</button>
    </div>
    
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
                    <td>
                        <?php if ($field === 'name'): ?>
                            <a href="manage_ci.php?id=<?= $item['id'] ?>">
                                <?= htmlspecialchars($item['name']) ?>
                            </a>
                        <?php else: ?>
                            <?= htmlspecialchars($item[$field] ?? '') ?>
                        <?php endif; ?>
                    </td>
                <?php } ?>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
