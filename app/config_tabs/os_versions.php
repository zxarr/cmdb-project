<?php
// require '../db.php';

// Handle Add OS Version
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    $os_family = $_POST['os_family'];
    $os_name = $_POST['os_name'];
    $version = $_POST['version'];
    $codename = $_POST['codename'] ?? null;
    $release_date = $_POST['release_date'] ?? null;

    // Determine the correct table based on OS Family
    $table = match ($os_family) {
        'Windows' => 'windows_os',
        'Windows Server' => 'windows_server_os',
        'Linux' => 'linux_os',
        'macOS' => 'macos_versions',
        default => null
    };

    if ($table) {
        if ($action === 'add') {
            $stmt = $pdo->prepare("INSERT INTO $table (os_name, version, codename, release_date) VALUES (?, ?, ?, ?)");
            $stmt->execute([$os_name, $version, $codename, $release_date]);
        } elseif ($action === 'edit' && isset($_POST['id'])) {
            $stmt = $pdo->prepare("UPDATE $table SET os_name=?, version=?, codename=?, release_date=? WHERE id=?");
            $stmt->execute([$os_name, $version, $codename, $release_date, $_POST['id']]);
        }
    }
    header("Location: ../config_page.php");
    exit;
}

// Handle Delete OS Version
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete'], $_GET['family'])) {
    $id = $_GET['delete'];
    $family = $_GET['family'];

    $table = match ($family) {
        'Windows' => 'windows_os',
        'Windows Server' => 'windows_server_os',
        'Linux' => 'linux_os',
        'macOS' => 'macos_versions',
        default => null
    };

    if ($table) {
        $stmt = $pdo->prepare("DELETE FROM $table WHERE id = ?");
        $stmt->execute([$id]);
    }
    header("Location: ../config_page.php");
    exit;
}

// Fetch OS Versions
$windows_os = $pdo->query("SELECT * FROM windows_os")->fetchAll(PDO::FETCH_ASSOC);
$windows_server_os = $pdo->query("SELECT * FROM windows_server_os")->fetchAll(PDO::FETCH_ASSOC);
$linux_os = $pdo->query("SELECT * FROM linux_os")->fetchAll(PDO::FETCH_ASSOC);
$macos_os = $pdo->query("SELECT * FROM macos_versions")->fetchAll(PDO::FETCH_ASSOC);

$all_os = [
    'Windows' => $windows_os,
    'Windows Server' => $windows_server_os,
    'Linux' => $linux_os,
    'macOS' => $macos_os
];
?>

<h3>Manage OS Versions</h3>

<!-- Add/Edit OS Version Form -->
<form method="POST" id="osVersionForm">
    <input type="hidden" name="action" id="action" value="add">
    <input type="hidden" name="id" id="os_id">
    
    <select name="os_family" id="os_family" required>
        <option value="Windows">Windows</option>
        <option value="Windows Server">Windows Server</option>
        <option value="Linux">Linux</option>
        <option value="macOS">macOS</option>
    </select>
    <input type="text" name="version_name" id="version_name" placeholder="OS Name" required>
    <input type="text" name="version" id="version" placeholder="Version" required>
    <input type="text" name="codename" id="codename" placeholder="Codename (optional)">
    <input type="date" name="release_date" id="release_date" placeholder="Release Date (optional)">
    <button type="submit">Save OS Version</button>
    <button type="button" onclick="cancelEdit()" id="cancelEdit" style="display:none;">Cancel</button>
</form>

<h3>Existing OS Versions</h3>

<table>
    <tr>
        <th>Family</th>
        <th>Name</th>
        <th>Version</th>
        <th>Codename</th>
        <th>Release Date</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($all_os as $family => $os_list): ?>
        <?php foreach ($os_list as $os): ?>
            <tr>
                <td><?= $family ?></td>
                <td><?= htmlspecialchars($os['version_name']) ?></td>
                <td><?= htmlspecialchars($os['version']) ?></td>
                <td><?= htmlspecialchars($os['codename'] ?? '') ?></td>
                <td><?= htmlspecialchars($os['release_date'] ?? '') ?></td>
                <td>
                    <button onclick="editOS(<?= $os['id'] ?>, '<?= $family ?>', '<?= htmlspecialchars($os['version_name']) ?>', '<?= htmlspecialchars($os['version']) ?>', '<?= htmlspecialchars($os['codename'] ?? '') ?>', '<?= htmlspecialchars($os['release_date'] ?? '') ?>')">✏️</button>
                    <button onclick="deleteOS(<?= $os['id'] ?>, '<?= $family ?>')">🗑️</button>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endforeach; ?>
</table>

<script>
function deleteOS(id, family) {
    if (confirm("Are you sure you want to delete this OS version?")) {
        window.location.href = '../config_tabs/os_versions.php?delete=' + id + '&family=' + family;
    }
}

function editOS(id, family, name, version, codename, releaseDate) {
    document.getElementById("os_id").value = id;
    document.getElementById("os_family").value = family;
    document.getElementById("version_name").value = name;
    document.getElementById("version").value = version;
    document.getElementById("codename").value = codename;
    document.getElementById("release_date").value = releaseDate;
    document.getElementById("action").value = "edit";
    
    document.getElementById("cancelEdit").style.display = "inline";
}

function cancelEdit() {
    document.getElementById("os_id").value = "";
    document.getElementById("os_family").value = "Windows";
    document.getElementById("version_name").value = "";
    document.getElementById("version").value = "";
    document.getElementById("codename").value = "";
    document.getElementById("release_date").value = "";
    document.getElementById("action").value = "add";

    document.getElementById("cancelEdit").style.display = "none";
}
</script>
