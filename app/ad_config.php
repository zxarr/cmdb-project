<?php
// Active Directory Configuration using Environment Variables
return [
    'server' => getenv('AD_SERVER') ?: 'ldap://default-ad-server',
    'port' => getenv('AD_PORT') ?: 389,
    'base_dn' => getenv('AD_BASE_DN') ?: 'DC=example,DC=com',
    'user_dn' => getenv('AD_USER_DN') ?: 'CN=DefaultUser,OU=Users,DC=example,DC=com',
    'password' => getenv('AD_PASSWORD') ?: 'DefaultPassword',
    'group_filter' => getenv('AD_GROUP_FILTER') ?: '(objectClass=group)',
    'user_filter' => getenv('AD_USER_FILTER') ?: '(objectClass=user)',
];
?>
