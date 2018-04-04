<?php

include '../Ldap.php';

use swods\ldap\Ldap;

echo "<h1>LDAP Connection</h1>";

$ldap = new Ldap([
    'login' => 'user',
    'password' => 'password',
    'domain' => 'domain.local',
    'base_dn' => 'DC=domain,DC=local',
    'ldapConfig' => [
        'LDAP_OPT_REFERRALS' => 0,
        'LDAP_OPT_PROTOCOL_VERSION' => 3,
    ]
]);

var_dump($ldap->bind());
var_dump($ldap->search('user'));