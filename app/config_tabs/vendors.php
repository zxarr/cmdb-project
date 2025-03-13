<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_vendor'])) {
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
    } elseif (isset($_POST['delete_vendor'])) {
        $stmt = $pdo->prepare("DELETE FROM vendors WHERE id = ?");
        $stmt->execute([$_POST['delete_vendor']]);
    }
}

$vendors = $pdo->query("SELECT * FROM vendors")->fetchAll(PDO::FETCH_ASSOC);
?>

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
