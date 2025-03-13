<?php
// Database Connection
require 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>CMDB Configuration</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>
</head>
<body>

<!-- Back Arrow Button -->
<a href="index.php" class="back-button">← Back to CMDB</a>

<h2>CMDB Configuration</h2>

<div class="tab">
    <button class="tablinks" onclick="openTab(event, 'Locations')">Locations</button>
    <button class="tablinks" onclick="openTab(event, 'Vendors')">Vendors</button>
    <button class="tablinks" onclick="openTab(event, 'OSVersions')">OS Versions</button>
    <button class="tablinks" onclick="openTab(event, 'CITypes')">CI Types</button>
</div>

<div id="Locations" class="tabcontent">
    <?php include 'config_tabs/locations.php'; ?>
</div>

<div id="Vendors" class="tabcontent">
    <?php include 'config_tabs/vendors.php'; ?>
</div>

<div id="OSVersions" class="tabcontent">
    <?php include 'config_tabs/os_versions.php'; ?>
</div>

<div id="CITypes" class="tabcontent">
    <?php include 'config_tabs/ci_types.php'; ?>
</div>

<script>
    // Open the first tab by default
    document.getElementsByClassName("tablinks")[0].click();
</script>

</body>
</html>
