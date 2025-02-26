<?php
// Load AD settings from environment variables via ad_config.php
$adConfig = require 'ad_config.php';

function getADGroups() {
    global $adConfig;

    $ldapConn = ldap_connect($adConfig['server'], $adConfig['port']);
    if (!$ldapConn) {
        error_log("LDAP Connection Failed");
        return [];
    }

    ldap_set_option($ldapConn, LDAP_OPT_PROTOCOL_VERSION, 3);

    // Bind to LDAP with service account
    if (!ldap_bind($ldapConn, $adConfig['user_dn'], $adConfig['password'])) {
        error_log("LDAP Bind Failed");
        return [];
    }

    // Search for groups
    $result = ldap_search($ldapConn, $adConfig['base_dn'], $adConfig['group_filter'], ['cn']);
    if (!$result) {
        error_log("LDAP Search Failed");
        ldap_close($ldapConn);
        return [];
    }

    $entries = ldap_get_entries($ldapConn, $result);
    ldap_close($ldapConn);

    $groups = [];
    for ($i = 0; $i < $entries["count"]; $i++) {
        $groups[] = $entries[$i]["cn"][0];
    }

    return $groups;
}
?>
