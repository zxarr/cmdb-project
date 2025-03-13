<?php
//require '../db.php';

// Handle Add/Edit CI Types
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    $name = $_POST['name'];
    $description = $_POST['description'];

    if ($action === 'add') {
        $stmt = $pdo->prepare("INSERT INTO ci_types (name, description) VALUES (?, ?)");
        $stmt->execute([$name, $description]);
    } elseif ($action === 'edit' && isset($_POST['id'])) {
        $stmt = $pdo->prepare("UPDATE ci_types SET name=?, description=? WHERE id=?");
        $stmt->execute([$name, $description, $_POST['id']]);
    }
    header("Location: ../config_page.php");
    exit;
}

// Handle Delete CI Types
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM ci_types WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: ../config_page.php");
    exit;
}

// Fetch CI Types
$ci_types = $pdo->query("SELECT * FROM ci_types")->fetchAll(PDO::FETCH_ASSOC);
?>

<h3>Manage CI Types</h3>

<!-- Add/Edit CI Type Form -->
<form method="POST" id="ciTypeForm">
    <input type="hidden" name="action" id="action" value="add">
    <input type="hidden" name="id" id="ci_type_id">
    
    <input type="text" name="name" id="name" placeholder="CI Type Name" required>
    <input type="text" name="description" id="description" placeholder="Description" required>
    <button type="submit">Save CI Type</button>
    <button type="button" onclick="cancelEdit()" id="cancelEdit" style="display:none;">Cancel</button>
</form>

<h3>Existing CI Types</h3>

<table>
    <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($ci_types as $type): ?>
        <tr>
            <td><?= htmlspecialchars($type['name']) ?></td>
            <td><?= htmlspecialchars($type['description']) ?></td>
            <td>
                <button onclick="editCIType(<?= $type['id'] ?>, '<?= htmlspecialchars($type['name']) ?>', '<?= htmlspecialchars($type['description']) ?>')">✏️</button>
                <button onclick="deleteCIType(<?= $type['id'] ?>)">🗑️</button>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<script>
function deleteCIType(id) {
    if (confirm("Are you sure you want to delete this CI Type?")) {
        window.location.href = '../config_tabs/ci_types.php?delete=' + id;
    }
}

function editCIType(id, name, description) {
    document.getElementById("ci_type_id").value = id;
    document.getElementById("name").value = name;
    document.getElementById("description").value = description;
    document.getElementById("action").value = "edit";
    
    document.getElementById("cancelEdit").style.display = "inline";
}

function cancelEdit() {
    document.getElementById("ci_type_id").value = "";
    document.getElementById("name").value = "";
    document.getElementById("description").value = "";
    document.getElementById("action").value = "add";

    document.getElementById("cancelEdit").style.display = "none";
}
</script>
