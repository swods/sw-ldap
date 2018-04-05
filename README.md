PHP LDAP Extension
============================

This package was made for me, but if you find this useful, you can use it.
Just small component that help me connect by LDAP

INSTALLATION
------------

### Install via Composer

Add this in composer.json

~~~
"swods/ldap": "*"
~~~

HOW TO USE
------------

### Attributes

`login` - Main login, you can use 'master' account for search without enter login & password of search person  
`password` - Main passoword, same as `login`  
`domain` - Required, LDAP host  
`base_dn` - Required, the base DN for the directory  
`ldapConfig` - Set the value of the given option. Read this for more information - [ldap_set_option()](http://php.net/manual/en/function.ldap-set-option.php)  
`ldapPort` - Default is `389`. The port to connect to  
`filter` - Default is `'samaccountname={value}'`. Filter for search, `{value}` will be replace with search value. For exp: `'filter' => 'samaccountname={value}*'` with value `Bill` will search as 'like' and can return Bill, Billy, Billi and etc

### Methods

`bind($login = null, $password = null)` - with try connect by LDAP.  
If attributes will be `null` and login & password was not set on object creation will be connect as anonymous.  
If login & password was set on object creation will be use them for connect.  
And if attributes set, will use them. Return `true` or `exception`


`search($search_value, $login = null, $password = null)` - Pretty same as `bind()` with login & password, but first you need set search value

### Example

```php
$ldap = new Ldap([
    'login' => 'user',
    'password' => 'password',
    'domain' => 'ldap_service.local',
    'base_dn' => 'DC=ldap_service,DC=local',
    'ldapConfig' => [
        'LDAP_OPT_REFERRALS' => 0,
        'LDAP_OPT_PROTOCOL_VERSION' => 3,
    ]
]);

$ldap->search('user');
```

### NOTICE

Be sure with correct `base_dn` if your account don't have right to search you will get error on ldap_serach()
