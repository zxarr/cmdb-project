<?php
//require '../db.php'; // Ensure the database connection is included

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_location'])) {
        $stmt = $pdo->prepare("INSERT INTO locations (name, street_address, city, state, postal_code, country, contact_number, contact_email) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['name'],
            $_POST['street_address'],
            $_POST['city'],
            $_POST['state'],
            $_POST['postal_code'],
            $_POST['country'],
            $_POST['contact_number'],
            $_POST['contact_email']
        ]);
    } elseif (isset($_POST['delete_location'])) {
        $stmt = $pdo->prepare("DELETE FROM locations WHERE id = ?");
        $stmt->execute([$_POST['delete_location']]);
    } elseif (isset($_POST['edit_location']) && !empty($_POST['name'])) {
        $stmt = $pdo->prepare("UPDATE locations SET name = ?, street_address = ?, city = ?, state = ?, postal_code = ?, country = ?, contact_number = ?, contact_email = ? WHERE id = ?");
        $stmt->execute([
            $_POST['name'],
            $_POST['street_address'],
            $_POST['city'],
            $_POST['state'],
            $_POST['postal_code'],
            $_POST['country'],
            $_POST['contact_number'],
            $_POST['contact_email'],
            $_POST['edit_location']
        ]);
    }
}

// Fetch all locations
$locations = $pdo->query("SELECT * FROM locations")->fetchAll(PDO::FETCH_ASSOC);
?>

<h3>Manage Locations</h3>
<form method="POST">
    <input type="text" name="name" placeholder="Location Name" required>
    <input type="text" name="street_address" placeholder="Street Address">
    <input type="text" name="city" placeholder="City">
    <input type="text" name="state" placeholder="Province">
    <input type="text" name="postal_code" placeholder="Postal Code">
    <input type="text" name="country" placeholder="Country">
    <input type="text" name="contact_number" placeholder="Contact Number">
    <input type="email" name="contact_email" placeholder="Contact Email">
    <button type="submit" name="add_location">Add Location</button>
</form>

<h3>Existing Locations</h3>
<table>
    <tr>
        <th>Name</th>
        <th>City</th>
        <th>Province</th>
        <th>Postal Code</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($locations as $location) { ?>
        <tr>
            <td><?php echo $location['name']; ?></td>
            <td><?php echo $location['city']; ?></td>
            <td><?php echo $location['state']; ?></td>
            <td><?php echo $location['postal_code']; ?></td>
            <td>
                <button type="button" class="icon-button" onclick="editLocation(
                    <?php echo $location['id']; ?>, 
                    '<?php echo htmlspecialchars($location['name'], ENT_QUOTES); ?>', 
                    '<?php echo htmlspecialchars($location['street_address'], ENT_QUOTES); ?>', 
                    '<?php echo htmlspecialchars($location['city'], ENT_QUOTES); ?>', 
                    '<?php echo htmlspecialchars($location['state'], ENT_QUOTES); ?>', 
                    '<?php echo htmlspecialchars($location['postal_code'], ENT_QUOTES); ?>', 
                    '<?php echo htmlspecialchars($location['country'], ENT_QUOTES); ?>', 
                    '<?php echo htmlspecialchars($location['contact_number'], ENT_QUOTES); ?>', 
                    '<?php echo htmlspecialchars($location['contact_email'], ENT_QUOTES); ?>'
                )">
                    <i class="fas fa-pencil-alt"></i>
                </button>
                <form method="POST" style="display:inline;">
                    <button type="submit" name="delete_location" value="<?php echo $location['id']; ?>" class="icon-button delete-button">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </td>
        </tr>
    <?php } ?>
</table>

<!-- Edit Location Form -->
<div id="editLocationForm" style="display:none;">
    <h3>Edit Location</h3>
    <form method="POST">
        <input type="hidden" id="edit_id" name="edit_location">
        <input type="text" id="edit_name" name="name" placeholder="Location Name" required>
        <input type="text" id="edit_street_address" name="street_address" placeholder="Street Address">
        <input type="text" id="edit_city" name="city" placeholder="City">
        <input type="text" id="edit_state" name="state" placeholder="Province">
        <input type="text" id="edit_postal_code" name="postal_code" placeholder="Postal Code">
        <input type="text" id="edit_country" name="country" placeholder="Country">
        <input type="text" id="edit_contact_number" name="contact_number" placeholder="Contact Number">
        <input type="email" id="edit_contact_email" name="contact_email" placeholder="Contact Email">
        <button type="submit">Save Changes</button>
        <button type="button" onclick="document.getElementById('editLocationForm').style.display='none'">Cancel</button>
    </form>
</div>

<script>
    function editLocation(id, name, street_address, city, state, postal_code, country, contact_number, contact_email) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_street_address').value = street_address;
        document.getElementById('edit_city').value = city;
        document.getElementById('edit_state').value = state;
        document.getElementById('edit_postal_code').value = postal_code;
        document.getElementById('edit_country').value = country;
        document.getElementById('edit_contact_number').value = contact_number;
        document.getElementById('edit_contact_email').value = contact_email;

        // Show edit form
        document.getElementById('editLocationForm').style.display = "block";
    }
</script>
