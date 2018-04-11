<?php

namespace swods\ldap;

/**
 * "How to use" can be found in README.md file
 * @author SSU (SwoDs) <etc@swods.ru>
 */
class Ldap
{
    private $ldap_connect;
    private $attributes;
    private $data_data;

    function __construct($config) 
    {
        $this->attributes = [
            'ldapPort' => 389,
            'filter' => 'samaccountname={value}',
        ];

        $this->attributes = array_merge($this->attributes, $config);
        if (empty($this->ldap_connect = ldap_connect($this->domain, $this->ldapPort))) {
            throw new \Exception('LDAP connection fail');
        }

        if (is_array($this->ldapConfig)) {
            foreach ($this->ldapConfig as $const => $value) {
                ldap_set_option($this->ldap_connect, $const, $value);
            }
        }
    }

    function __set($name, $value) 
    {
        $this->attributes[$name] = $value;
    }

    function __get($name) 
    {
        if (array_key_exists($name, $this->attributes)) {
            return $this->attributes[$name];
        }
        return NULL;
    }

    public function bind($login = null, $password = null)
    {
        $ldap_login = $login ?? $this->login;
        $ldap_password = $password ?? $this->password;

        if (empty($ldap_login) || empty($ldap_password)) {
            throw new \Exception('Login & password must be set');
        }

        return @ldap_bind($this->ldap_connect, $ldap_login, $ldap_password);
    }

    public function search($search_value, $login = null, $password = null) 
    {
        $this->bind($login, $password);

        $filter = str_replace('{value}', $search_value, $this->filter);
        
        $res = ldap_search($this->ldap_connect, $this->base_dn, $filter);
        $data = ldap_get_entries($this->ldap_connect, $res);

        ldap_unbind($this->ldap_connect);
        return $this->ldapArrayBeautifier($data);
    }

    public function ldapArrayBeautifier($data) 
    {
        unset($data['count']);
        
        $parsed_data = [];
        foreach ($data as $item) {
            
            $parsed_item = [];
            foreach ($item as $key => $value) {
                
                if (!is_int($key)) {
                    
                    if (!empty($item[$key]['count'])) {
                        unset($item[$key]['count']);
                    }
                    
                    if (is_array($item[$key])) {
                        
                        if (count($item[$key]) == 1) {
                            $parsed_item[$key] = $item[$key][0];
                        } else {
                            foreach ($item[$key] as $value) {
                                $parsed_item[$key][] = $value;
                            }
                        }
                    } else {
                        $parsed_item[$key] = $item[$key];
                    }
                }
            }
            $parsed_data[] = $parsed_item;
        }

        return $parsed_data;
    } 
}