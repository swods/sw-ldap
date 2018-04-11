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

`login` - For AD it can be `username@domain`, for OpenLDAP - `cn=admin,dc=example,dc=com`
`password` - Passoword
`domain` - Required, LDAP host  
`base_dn` - Required, the base DN for the directory  
`ldapConfig` - Must be an array of options (check example). Read this for more information - [ldap_set_option()](http://php.net/manual/en/function.ldap-set-option.php) !! be sure that you use constant as key!  
`ldapPort` - Default is `389`. The port to connect to  
`filter` - Default is `'samaccountname={value}'`. Filter for search, `{value}` will be replace with search value. For exp: `'filter' => 'samaccountname={value}*'` with value `Bill` will search as 'like' and can return Bill, Billy, Billi and etc

### Methods

`bind($login = null, $password = null)` - will connect by LDAP with given login and password as attributes or that was set on object creation.  

Will return `true` if bind was success and `false` if wasn't


`search($search_value, $login = null, $password = null)` - Pretty same as `bind()` with login & password, but first you need set search value

Will return `array` with finded data

### Example

```php
$ldap = new Ldap([
    'login' => 'user',
    'password' => 'password',
    'domain' => 'ldap_service.local',
    'base_dn' => 'DC=ldap_service,DC=local',
    'ldapConfig' => [
        LDAP_OPT_REFERRALS => 0,
        LDAP_OPT_PROTOCOL_VERSION => 3,
    ]
]);

$ldap->bind();
$ldap->bind('user2', 'password');

$ldap->search('user');
$ldap->search('user2', 'user2', 'password');
```

Change Log
==========================

1.1.0 11.04.2018
-----------------------

- Bug #3: Function `empty()` won't work with `__get()`, changet to `is_array()`
- Chg #2: Example in README was changed: keys in `ldapConfig` must be as constant. Plus some text updates
- Chg #1: `login` no more converts to login@domain, you have to do it by you self, it was changed because AD & OpenLDAP have difference in `login` constructions
