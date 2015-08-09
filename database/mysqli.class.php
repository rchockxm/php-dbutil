<?php
/**
 * DB-Util
 * Created by Silence Unlimited
 * Developer: Rchockxm (rchockxm.silver@gmail.com)
 * FileName: mysqli.class.php
 */
namespace DBCls\Database;

/**
 * Database DBMySqli
 */
class DBMySqli extends \DBCls\DB implements \DBCls\IADatabase { 

    /**
     * __construct()
     * @type public
     * @args void
     * @return Success - void
     *         Fail - void
     */
    public function __construct() { }
    
    /**
     * __desctuct()
     * @type public
     * @args void
     * @return Success - void
     *         Fail - void
     */
    public function __destruct() { }
    
    /**
     * connect()
     * @type public
     * @args $config
     * @return Success - object
     *         Fail - null
     */
    public function connect($config) {
        $ret = null;
        
        if (is_array($config)) {
            $hostName = (array_key_exists("hostname", $config)) ? $config["hostname"] : "";
            $userName = (array_key_exists("username", $config)) ? $config["username"] : "";
            $userPassword = (array_key_exists("userpwd", $config)) ? $config["userpwd"] : "";
            $dbName = (array_key_exists("database", $config)) ? $config["database"] : "";
            $dbCharset = (array_key_exists("charset", $config)) ? $config["charset"] : "utf8";
            
            if ($this->link = new mysqli($hostName, $userName, $userPassword, $dbName)) {
                $this->link->set_charset($dbCharset);
                
                $this->instance[$this->guid($config)] = array("config" => $config, "link" => $this->link);
                $ret = $this->link;
            }
            else {
                $this->error .= "\n [ SQL Connect ] Could not connect";
            }
            
            $dbCharset = null;
            $dbName = null;
            $userPassword = null;
            $userName = null;
            $hostName = null;
        }
        else {
            $this->error .= "\n [ SQL Connect ] Config not found";
        }
        
        return $ret;
    }
    
    /**
     * close()
     * @type public
     * @args [optional $link]
     * @return Success - boolean(true)
     *         Fail - boolean(false)
     */
    public function close($link = null) {
        $ret = false;
        $link = is_object($link) ? $link : $this->link;
    
        if ($link) {
            $ret = $link->close();
        }
        
        return $ret;
    }
    
    /**
     * query()
     * @type public
     * @args $sql, [optional $link]
     * @return Success - object
     *         Fail - null
     */
    public function query($sql, $link = null) {
        $ret = null;
        $link = is_object($link) ? $link : $this->link;
        
        if ($link) {
            $this->queryStr = (string)$sql;
            $ret = $link->query($sql);
        }
        
        return $ret;
    }
    
    /**
     * freeResult()
     * @type public
     * @args $resource
     * @return Success - boolean(true)
     *         Fail - boolean(false)
     */
    public function freeResult($resource) {
        $ret = false;
        
        if (is_object($resource)) {
            $ret = $resource->free_result();
        }
        
        return $ret;
    }
    
    /**
     * fetchAssoc()
     * @type public
     * @args $resource
     * @return Success - array
     *         Fail - null
     */
    public function fetchAssoc($resource) {
        $ret = null;
        
        if (is_object($resource)) {
            $ret = $resource->fetch_assoc();
        }
        
        return $ret;
    }
    
    /**
     * fetchArray()
     * @type public
     * @args $resource
     * @return Success - array
     *         Fail - null
     */
    public function fetchArray($resource) {
        $ret = null;
        
        if (is_object($resource)) {
            $ret = $resource->fetch_array();
        }
        
        return $ret;
    }
    
    /**
     * fetchRow()
     * @type public
     * @args $resource
     * @return Success - array
     *         Fail - null
     */
    public function fetchRow($resource) {
        $ret = null;
        
        if (is_object($resource)) {
            $ret = $resource->fetch_row();
        }
        
        return $ret;
    }
    
    /**
     * fetchField()
     * @type public
     * @args $resource
     * @return Success - object
     *         Fail - null
     */
    public function fetchField($resource) {
        $ret = null;
        
        if (is_object($resource)) {
            $ret = $resource->fetch_field();
        }
        
        return $ret;
    }
    
    /**
     * fetchObject()
     * @type public
     * @args $resource
     * @return Success - object
     *         Fail - null
     */
    public function fetchObject($resource) {
        $ret = null;
        
        if (is_object($resource)) {
            $ret = $resource->fetch_object();
        }
        
        return $ret;
    }
    
    /**
     * escape()
     * @type public
     * @args $value, [optional $link]
     * @return Success - string
     *         Fail - origional string
     */
    public function escape($value, $link = null) {
        $ret = "";
        $link = is_object($link) ? $link : $this->link;
        
        if ($link) {
            $ret = $link->real_escape_string($value);
        }
        else {
            $ret = mysqli_escape_string($value);
        }
        
        return $ret;
    }
    
    /**
     * countAffected()
     * @type public
     * @args [optional $link]
     * @return Success - integer
     *         Fail - null
     */
    public function countAffected($link = null) {
        $ret = null;
        $link = is_object($link) ? $link : $this->link;
    
        if ($link) {
            $ret = $link->affected_rows;
        }
        
        return $ret;
    }
    
    /**
     * getLastID()
     * @type public
     * @args [optional $link]
     * @return Success - long integer
     *         Fail - null
     */
    public function getLastID($link = null) {
        $ret = null;
        $link = is_object($link) ? $link : $this->link;
    
        if ($link) {
            $ret = $link->insert_id;
        }
        
        return $ret;
    }
    
    /**
     * error()
     * @type public
     * @args [optional $link]
     * @return Success - string
     *         Fail - null
     */
    public function error($link = null) {
        $link = is_object($link) ? $link : $this->link;
        $this->error = ($link) ? $link->errno . ":" . $link->error : "";
        
        if ($this->queryStr != "") {
            $this->error .= "\n [ SQL Syntax ]" . $this->queryStr;
        }
        
        return $this->error;
    }
}
