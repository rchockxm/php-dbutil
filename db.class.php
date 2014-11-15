<?php
/**
 * DB-Util
 * Created by Silence Unlimited
 * Developer: Rchockxm (rchockxm.silver@gmail.com)
 * FileName: db.class.php
 */
namespace DBCls;

/**
 * DB
 */
class DB {
    
    private $dbExtname = ".class.php";
    private $driver = null;
    
    protected $util = null;
    protected $link = null;
    protected $instance = array();
    
    protected $querylock = false;
    protected $queryStr = "";
    protected $queryTime = 0;
    protected $error = "";
    
    /**
     * __construct()
     * @type public
     * @args $driver, [optional $dbpath]
     * @return Success - boolean(true)
     *         Fail - boolean(false)
     */
    public function __construct($driver, $dbpath = "") {
        $ret = false;
        $filePath = (string)$dbpath . "/" . (string)$driver . (string)$this->dbExtname;
        
        if (file_exists($filePath)) {
            $classUtil = "DBCls\DBUtil";
            $class = "\DBCls\Database\DB" . (string)$driver;
            
            if (class_exists($classUtil)) {
                $this->util = new $classUtil();
                
                @require_once($filePath);
                
                if (class_exists($class)) {
                    $this->driver = new $class();
                    $ret = ($this->driver) ? true : false;
                }
            }
           
            $class = null;
            $classUtil = null;
        }
        
        $filePath = null;
        
        return $ret;
    }
    
    /**
     * __destruct()
     * @type public
     * @args void
     * @return Success - boolean(true)
     *         Fail - boolean(false)
     */
    public function __destruct() {
        $ret = false;
        
        if (is_array($this->driver->instance)) {
            $instLen = count($this->driver->instance);
            $instII = 0;
            
            foreach ($this->driver->instance as $index => $inst) {
                $isClosed = $this->close($inst["link"]);
                
                unset($this->driver->instance[$index]);
                $instII += ($isClosed) ? 1 : 0;
                
                $isReleased = null;
                $isClosed = null;
            }
            
            $ret = ($instII == $instLen) ? true : false;
            
            $instII = null;
            $instLen = null;
        }
        
        return $ret;
    }
    
    /**
     * guid()
     * @type public
     * @args $config
     * @return Success - string
     *         Fail - string
     */
    public function guid($config) {
        $ret = (is_array($config) || is_object($config)) ? serialize($config) : (string)$config;
        
        return md5($ret);
    }
    
    /**
     * util()
     * @type public
     * @args [optional $link]
     * @return Success - object
     *         Fail - null
     */
    public function util($link = null) {
        if (is_object($this->util)) {
            $this->util->driver = $this->driver;
            $this->util->link = $link;
        }

        return $this->util;
    }
    
    /**
     * getInstance()
     * @type public
     * @args $config
     * @return Success - object
     *         Fail - null
     */
    public function getInstance($config) {
        $ret = null;
        $guid = $this->guid($config);
        
        if (is_object($this->driver)) {
            if (is_array($this->driver->instance) && array_key_exists($guid, $this->driver->instance)) {
                $ret = $this->driver->instance[$guid]["link"];
            }
        }

        $guid = null;
        
        return $ret;
    }
    
    /**
     * connect()
     * @type public
     * @args $config
     * @return Success - object
     *         Fail - null
     */
    public function connect($config) {
        $ret = null;
        $instance = $this->getInstance($config);
        
        if (is_resource($instance)) {
            $this->driver->link = $instance;
            $ret = $instance;
        }
        else {
            $instance = $this->driver->connect($config);
        
            if ($instance) {
                $ret = $instance;
            }
        }
         
        $instance = null;
        
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
        $ret = null;
        
        if (is_object($this->driver)) {
            $ret = $this->driver->close($link);
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
        
        if (is_object($this->driver)) {
            $ret = $this->driver->query($sql, $link);
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
        
        if (is_object($this->driver)) {
            $ret = $this->driver->freeResult($resource);
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
        
        if (is_object($this->driver)) {
            $ret = $this->driver->fetchAssoc($resource);
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
        
        if (is_object($this->driver)) {
            $ret = $this->driver->fetchArray($resource);
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
        
        if (is_object($this->driver)) {
            $ret = $this->driver->fetchRow($resource);
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
        
        if (is_object($this->driver)) {
            $ret = $this->driver->fetchField($resource);
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
        
        if (is_object($this->driver)) {
            $ret = $this->driver->fetchObject($resource);
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
        $ret = null;
        
        if (is_object($this->driver)) {
            $ret = $this->driver->escape($value, $link);
        }
    
        return $ret;
    }
    
    /**
     * countAffected()
     * @type public
     * @args [optional $link]
     * @return Success - integer
     *         Fail - integer
     */
    public function countAffected($link = null) {
        $ret = null;
        
        if (is_object($this->driver)) {
            $ret = $this->driver->countAffected($link);
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
        
        if (is_object($this->driver)) {
            $ret = $this->driver->getLastID($link);
        }
    
        return $ret;
    }
    
    /**
     * getError()
     * @type public
     * @args void
     * @return Success - string
     *         Fail - null
     */
    public function getError() {
        $ret = null;
        
        if (is_object($this->driver)) {
            $ret = $this->driver->error;
        }
    
        return $ret;
    }
}
?>
