<?php
require 'db.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_location'])) {
        $stmt = $pdo->prepare("INSERT INTO locations (name, street_address, city, state, zip_code, country, contact_number, contact_email) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['name'],
            $_POST['street_address'],
            $_POST['city'],
            $_POST['state'],
            $_POST['zip_code'],
            $_POST['country'],
            $_POST['contact_number'],
            $_POST['contact_email']
        ]);
    } elseif (isset($_POST['add_vendor'])) {
        $stmt = $pdo->prepare("INSERT INTO vendors (name, contact_person, contact_phone, contact_email, support_website, support_phone, support_email, sales_email) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['name'],
            $_POST['contact_person'],
            $_POST['contact_phone'],
            $_POST['contact_email'],
            $_POST['support_website'],
            $_POST['support_phone'],
            $_POST['support_email'],
            $_POST['sales_email']
        ]);
    }
}

// Fetch locations and vendors
$locations = $pdo->query("SELECT * FROM locations")->fetchAll(PDO::FETCH_ASSOC);
$vendors = $pdo->query("SELECT * FROM vendors")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Configurable Fields</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script>
        function openTab(evt, tabName) {
            let i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].classList.remove("active");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.classList.add("active");
        }
    </script>
</head>
<body>

    <h2>Manage Configurable Fields</h2>

    <!-- Tab Navigation -->
    <div class="tab">
        <button class="tablinks active" onclick="openTab(event, 'Locations')">Locations</button>
        <button class="tablinks" onclick="openTab(event, 'Vendors')">Vendors</button>
    </div>

    <!-- Locations Tab -->
    <div id="Locations" class="tabcontent" style="display:block;">
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
                <th>Contact</th>
            </tr>
            <?php foreach ($locations as $location) { ?>
                <tr>
                    <td><?php echo $location['name']; ?></td>
                    <td><?php echo $location['city']; ?></td>
                    <td><?php echo $location['state']; ?></td>
                    <td><?php echo $location['postal_code']; ?></td>
                    <td><?php echo $location['contact_email']; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>


    <!-- Vendors Tab -->
    <div id="Vendors" class="tabcontent">
        <h3>Manage Vendors</h3>
        <form method="POST">
            <input type="text" name="name" placeholder="Vendor Name" required>
            <input type="text" name="contact_person" placeholder="Contact Person">
            <input type="text" name="contact_phone" placeholder="Contact Phone">
            <input type="email" name="contact_email" placeholder="Contact Email">
            <input type="text" name="support_website" placeholder="Support Website">
            <input type="text" name="support_phone" placeholder="Support Phone">
            <input type="email" name="support_email" placeholder="Support Email">
            <input type="email" name="sales_email" placeholder="Sales Email">
            <button type="submit" name="add_vendor">Add Vendor</button>
        </form>

        <h3>Existing Vendors</h3>
        <table>
            <tr>
                <th>Name</th>
                <th>Contact Person</th>
                <th>Support Email</th>
                <th>Support Phone</th>
            </tr>
            <?php foreach ($vendors as $vendor) { ?>
                <tr>
                    <td><?php echo $vendor['name']; ?></td>
                    <td><?php echo $vendor['contact_person']; ?></td>
                    <td><?php echo $vendor['support_email']; ?></td>
                    <td><?php echo $vendor['support_phone']; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <button onclick="window.location.href='index.php'">Back to CMDB</button>
</body>
</html>
