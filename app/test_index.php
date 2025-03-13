<?php
// Database Connection
require 'db.php';

// Fetch Configuration Items
$items = $pdo->query("SELECT * FROM configuration_items ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

// Define available fields
$available_fields = [
    'name', 'description', 'service', 'os_type', 'os_version', 'owner',
    'contract', 'location', 'ip_address', 'serial_number', 'vendor',
    'purchase_date', 'warranty_expiry', 'ci_category', 'support_group',
    'application_support_group', 'vendor_support'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CMDB System - With Pagination</title>

    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css">
</head>
<body>

<div class="container my-4">
    <h2 class="text-center">Configuration Management Database</h2>

    <div class="table-responsive" >
        <table id="ciTable" class="display compact">
            <thead>
                <tr>
                    <?php foreach ($available_fields as $field) { ?>
                        <th><?php echo ucfirst(str_replace('_', ' ', $field)); ?></th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item) { ?>
                    <tr>
                        <?php foreach ($available_fields as $field) { ?>
                            <td>
                                <?php echo htmlspecialchars($item[$field] ?? ''); ?>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- jQuery (Required for DataTables) -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>

<!-- Bootstrap 5.3 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>


<script>
    new DataTable('#ciTable', {
        layout: {
            bottomEnd: {
                paging: {
                    firstLast: false // Disables first/last page buttons
                }
            }
        },
        pageLength: 25,
        lengthMenu: [25, 50, 100, 250, "All"],
        ordering: true,
        searching: true
    });
</script>

</body>
</html>
