<?php
/**
 * DB-Util
 * Created by Silence Unlimited
 * Developer: Rchockxm (rchockxm.silver@gmail.com)
 * FileName: mssql.class.php
 */
namespace DBCls\Database;

/**
 * Database DBMsSql
 */
class DBMsSql extends \DBCls\DB implements \DBCls\IADatabase { 

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
            
            if ($this->link = mssql_connect($hostName, $userName, $userPassword, true)) {
                if (mssql_select_db($dbName, $this->link)) {
                    mssql_query("SET NAMES '" . $dbCharset . "'", $this->link);
                    mssql_query("SET CHARACTER SET " . $dbCharset, $this->link);
      
                    $this->instance[$this->guid($config)] = array("config" => $config, "link" => $this->link);
                    $ret = $this->link;
                }
                else {
                    
                }
            }
            else {
            
            }
            
            $dbCharset = null;
            $dbName = null;
            $userPassword = null;
            $userName = null;
            $hostName = null;
        }
        else {
        
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
        $link = is_resource($link) ? $link : $this->link;
    
        if ($link) {
            $ret = mssql_close($link);
        }
        
        return $ret;
    }
    
    /**
     * query()
     * @type public
     * @args $sql, [optional $link]
     * @return Success - resourceID
     *         Fail - null
     */
    public function query($sql, $link = null) {
        $ret = null;
        $link = is_resource($link) ? $link : $this->link;
        
        if ($link) {
            $this->queryStr = (string)$sql;
            $ret = mssql_query($sql, $link);
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
        
        if (iS_resource($resource)) {
            $ret = mssql_free_result($resource);
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
        
        if (iS_resource($resource)) {
            $ret = mssql_fetch_assoc($resource);
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
        
        if (iS_resource($resource)) {
            $ret = mssql_fetch_array($resource);
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
        
        if (iS_resource($resource)) {
            $ret = mssql_fetch_row($resource);
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
        
        if (iS_resource($resource)) {
            $ret = mssql_fetch_field($resource);
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
        
        if (iS_resource($resource)) {
            $ret = mssql_fetch_object($resource);
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
        $unpacked = unpack("H*hex", $value);
        
        return "0x" . (string)$unpacked["hex"];
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
        $link = is_resource($link) ? $link : $this->link;
    
        if ($link) {
            $ret = mssql_rows_affected($link);
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
        $link = is_resource($link) ? $link : $this->link;
        
        if ($link) {
            $query = $this->query("SELECT @@identity AS id", $link);
            
            if (is_resource($query)) {
                if ($row = $this->fetchRow($query)) {
                    $ret = (is_array($row)) ? trim($row[0]) : null;
                }
            }
            
            $query = null;
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
        $link = is_resource($link) ? $link : $this->link;
        $this->error = mssql_get_last_message();
        
        if ($this->queryStr != "") {
            $this->error .= "\n [ SQL Syntax ]" . $this->queryStr;
        }
        
        return $this->error;
    }
}
