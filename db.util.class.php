<?php
/**
 * DB-Util
 * Created by Silence Unlimited
 * Developer: Rchockxm (rchockxm.silver@gmail.com)
 * FileName: db.util.class.php
 */
namespace DBCls;

/**
 * DBUtil
 */
class DBUtil extends DB {

    private $operPrevious = array();
    private $operNext = array();

    protected $table = "";
    protected $fields = "";
    protected $where = "";
    protected $limit = "";
    protected $orderBy = "";
    protected $groupBy = "";
    protected $join = "";
    protected $dataList = null;
    protected $show;

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
     * table()
     * @type public
     * @args $table
     * @return Success - object
     *         Fail - object
     */
    public function table($table) {
        $this->table = $this->parseTable($table);
        
        return $this;
    }
    
    /**
     * fields()
     * @type public
     * @args $fields
     * @return Success - object
     *         Fail - object
     */
    public function fields($fields) {
        $this->fields = $this->parseFields($fields);
        
        return $this;
    }

    /**
     * where()
     * @type public
     * @args $where
     * @return Success - object
     *         Fail - object
     */
    public function where($where) {
        $this->where = $this->parseWhere($where);
    
        return $this;
    }

    /**
     * limit()
     * @type public
     * @args $offsetStart, [optional $offsetEnd]
     * @return Success - object
     *         Fail - object
     */
    public function limit($offsetStart, $offsetEnd = "") {
        $this->limit = $this->parseLimit($offsetStart, $offsetEnd);
        
        return $this;
    }

    /**
     * orderBy()
     * @type public
     * @args $orderBy
     * @return Success - object
     *         Fail - object
     */
    public function orderBy($orderBy) {
        $this->orderBy = $this->parseOrderBy($orderBy);
    
        return $this;
    }

    /**
     * groupBy()
     * @type public
     * @args $groupBy
     * @return Success - object
     *         Fail - object
     */
    public function groupBy($groupBy) {
        $this->groupBy = $this->parseGroupBy($groupBy);
    
        return $this;
    }
    
    /**
     * join()
     * @type public
     * @args $join, [optional $on]
     * @return Success - object
     *         Fail - object
     */
    public function join($join, $on = "") {
        $this->join = $this->parseJoin($join, $on);
    
        return $this;
    }

    /**
     * data()
     * @type public
     * @args $data
     * @return Success - object
     *         Fail - object
     */
    public function data($data) {
        $this->dataList = $this->parseData($data);
    
        return $this;
    }
    
    /**
     * select()
     * @type public
     * @args [optional $selectFields]
     * @return Success - object array
     *         Fail - null
     */
    public function select($selectFields = "") {
        $ret = null;
        
        if (!empty($selectFields)) {
            $this->fields = $this->parseFields($selectFields);
        }
        
        $sql = $this->parseSQL("select");
        
        if (!empty($sql)) {
            $query = $this->query($sql);
        
            if (is_resource($query) || is_object($query)) {
                $ret = new \stdClass();
                $ret->rows = array();
                $ret->num = 0;
                
                while ($row = $this->fetchAssoc($query)) {
                    $ret->rows[] = $row;
                    $ret->num += 1;
                }
            }
            
            $query = null;
        }
        
        $sql = null;
        
        return $ret;
    }

    /**
     * delete()
     * @type public
     * @args [optional $deleteWhere]
     * @return Success - boolean(true)
     *         Fail - boolean(false)
     */
    public function delete($deleteWhere = "") {
        $ret = false;
        
        if (!empty($deleteWhere)) {
            $this->where = $this->parseWhere($deleteWhere);
        }
        
        $sql = $this->parseSQL("delete");
        
        if (!empty($sql)) {
            $query = $this->query($sql);
            $ret = ($query) ? true : false;
            
            $query = null;
        }
        
        $sql = null;
        
        return $ret;
    }

    /**
     * update()
     * @type public
     * @args [optional updateData]
     * @return Success - boolean(true)
     *         Fail - boolean(false)
     */
    public function update($updateData = "") {
        $ret = false;
        
        if ($updateData) {
            $this->dataList = $this->parseData($updateData);
        }
        
        $sql = $this->parseSQL("update");
        
        if (!empty($sql)) {
            $query = $this->query($sql);
            $ret = ($query) ? true : false;
            
            $query = null;
        }
        
        $sql = null;
        
        return $ret;
    }
    
    /**
     * insert()
     * @type public
     * @args [optional insertData]
     * @return Success - boolean(true)
     *         Fail - boolean(false)
     */
    public function insert($insertData = "") {
        $ret = false;
        
        if ($insertData) {
            $this->dataList = $this->parseData($insertData);
        }
        
        $sql = $this->parseSQL("insert");
        
        if (!empty($sql)) {
            $query = $this->query($sql);
            $ret = ($query) ? true : false;
            
            $query = null;
        }
        
        $sql = null;
        
        return $ret;
    }
    
    /**
     * create()
     * @type public
     * @args create
     * @return Success - boolean(true)
     *         Fail - boolean(false)
     */
    public function create($create) {
        $ret = false;
        
        
        
        return $ret;
    }
    
    /**
     * total()
     * @type public
     * @args [optional totalWhere]
     * @return Success - long integer
     *         Fail - long integer
     */
    public function total($totalWhere = "") {
        $ret = 0;
        
        if ($totalWhere) {
            $this->where = $this->parseWhere($totalWhere);
        }
        
        $sql = $this->parseSQL("total");
        
        if (!empty($sql)) {
            $query = $this->query($sql);
            
            if (is_resource($query) || is_object($query)) {
                $row = $this->fetchAssoc($query);
                $ret = (is_array($row) && array_key_exists("count", $row)) ? (int)$row["count"] : 0;
            }
            
            $query = null;
        }
        
        $sql = null;
        
        return $ret;
    }
    
    /**
     * show()
     * @type public
     * @args $show
     * @return Success - object array
     *         Fail - null
     */
    public function show($show) {
        $ret = null;
        
        if ($show) {
            $this->show = $this->parseShow($show);
        }
        
        $sql = $this->parseSQL("show");
        
        if (!empty($sql)) {
            $query = $this->query($sql);
            
            if (is_resource($query) || is_object($query)) {
                $ret = new \stdClass();
                $ret->rows = array();
                $ret->num = 0;
                
                while ($row = $this->fetchAssoc($query)) {
                    $ret->rows[] = $row;
                    $ret->num += 1;
                }
            }
            
            $query = null;
        }
        
        $sql = null;
        
        return $ret;
    }
    
    /**
     * parseFields()
     * @type public
     * @args $fields
     * @return Success - string
     *         Fail - origional string
     */
    public function parseFields($fields) {
        $ret = $fields;
        
        if (is_array($fields)) {
            $ret = "";
            $arrFields = array();
        
            foreach ($fields as $keyA => $keyB) {
                if (!is_string($keyB) || empty($keyB)) {
                    continue;
                }
                
                $parseFieldName = $this->findFields($keyB);
                
                if (!empty($parseFieldName)) {
                    $arrFields[] = (string)$parseFieldName;
                }
                else {
                    if (is_string($keyA) && !empty($keyA)) {
                        $parseFieldName = $this->findFields($keyA, $keyB);
                    
                        if (!empty($parseFieldName)) {
                            $arrFields[] = (string)$parseFieldName;
                        }
                        else {
                            $arrFields[] = "`" . 
                                (string)$this->parsekey($keyB) . "`.`" .
                                (string)$this->parsekey($keyA) . "`";
                        }
                    }
                    else {
                        $arrFields[] = "`" . (string)$this->parsekey($keyB) . "`";
                    }
                }
                
                $parseFieldName = null;
            }
            
            $ret = (count($arrFields) > 0) ? implode(",", $arrFields) : "";
            
            $arrFields = null;
        }
        
        return $ret;
    }

    /**
     * parseTable()
     * @type public
     * @args $tables
     * @return Success - string
     *         Fail - empty string
     */
    public function parseTable($tables) {
        $ret = $tables;
        $tables = $this->parseFields($tables);
        
        if (!empty($tables)) {
            $ret = (string)$tables;
        }
        
        return $ret;
    }

    /**
     * parseWhere()
     * @type public
     * @args $where
     * @return Success - string
     *         Fail - empty string
     */
    public function parseWhere($where) {
        $ret = $where;
        
        if (is_array($where)) {
            $whereBy = array();
        
            foreach ($where as $keyA => $keyB) {
                $defOperation = "and";
            
                if (is_numeric($keyA) && is_string($keyB) && !empty($keyB)) {
                    $parseWhereItem = $this->parseWhereItem($keyB);
                    
                    if (!empty($parseWhereItem)) {
                        $whereBy[] = (string)$parseWhereItem . " " . 
                            (string)$defOperation;
                    }
                    
                    $parseWhereItem = null;
                }
                else {
                    if (!is_numeric($keyA) && !empty($keyA) && !is_numeric($keyB) && !empty($keyB)) {
                        $parseWhereItem = $this->parseWhereItem($keyA);
                        
                        if (!empty($parseWhereItem)) {
                            $whereBy[] = (string)$parseWhereItem . "" . 
                                (string)$this->findMathOpers($keyB, $defOperation);
                        }
                        
                        $parseWhereItem = null;
                    }
                    else {
                        if (is_string($keyA) && !empty($keyA)) {
                            $parseWhereItem = $this->parseWhereItem($keyA);
                            
                            if (!empty($parseWhereItem)) {
                                $whereBy[] = (string)$parseWhereItem . " " . 
                                    (string)$defOperation;
                            }
                            
                            $parseWhereItem = null;
                        }
                    }
                }
                
                $defOperation = null;
            }
            
            $ret = (count($whereBy) > 0) ? $this->stripRightOper(implode(" ", $whereBy)) : "";
            
            $whereBy = null;
        }
        
        return $ret;
    }
    
    /**
     * parseWhereItem()
     * @type public
     * @args $whereItem
     * @return Success - string
     *         Fail - empty string
     */
    private function parseWhereItem($whereItem) {
        $ret = "";
        
        if (!empty($whereItem)) {
            $strOperation = "!=";
            $matchs = explode($strOperation, $whereItem);
            
            if (count($matchs) == 1) {
                $strOperation = ">=";
                $matchs = explode($strOperation, $whereItem);
            }
            
            if (count($matchs) == 1) {
                $strOperation = "<=";
                $matchs = explode($strOperation, $whereItem);
            }
            
            if (count($matchs) == 1) {
                $strOperation = "=";
                $matchs = explode($strOperation, $whereItem);
            }
            
            if (count($matchs) == 1) {
                $strOperation = ">";
                $matchs = explode($strOperation, $whereItem);
            }
            
            if (count($matchs) == 1) {
                $strOperation = "<";
                $matchs = explode($strOperation, $whereItem);
            }
            
            if (count($matchs) == 1) {
                $strOperation = " ";
                $matchs = explode($strOperation, $whereItem);
            }
            
            switch (count($matchs)) {
                case 2:
                    $parseFieldNameA = $this->findFields($matchs[0]);
                    $parseFieldNameB = $this->findFields($matchs[1]);
                    
                    if (!empty($parseFieldNameA)) {
                        $parseFieldNameB = (!empty($parseFieldNameB)) ? $parseFieldNameB : $matchs[1];
                    
                        $ret = (string)$parseFieldNameA .
                            (string)$strOperation .
                            (string)$parseFieldNameB;
                    }
                    else {
                        if (empty($parseFieldNameA) && empty($parseFieldNameB)) {
                            $ret = (string)$matchs[0] .
                                (string)$strOperation .
                                (string)$matchs[1];
                        }
                    }
                    
                    $parseFieldNameB = null;
                    $parseFieldNameA = null;
                break;
                
                case 3:
                case 4:
                    $parseFieldName = $this->findFields($matchs[0]);
                
                    if (!empty($parseFieldName)) {
                        $ret = (string)$parseFieldName . " ";
                        $parseFinal = array_shift($matchs);
                    
                        foreach ($matchs as $index => $fragment) {
                            $ret .= (string)$this->parseValue($fragment) . " ";
                        }
                        
                        $parseFinal = null;
                    }
                    
                    $parseFieldName = null;
                break;
            }

            $matchs = null;
            $strOperation = null;
        }
        
        return $ret;
    }

    /**
     * parseLimit()
     * @type public
     * @args $limitA, [optional $limitB]
     * @return Success - string
     *         Fail - empty string
     */
    public function parseLimit($limitA, $limitB = "") {
        $ret = "";
    
        if (!empty($limitA)) {
            $ret = " limit " . (int)$limitA;
            
            if (!empty($limitB)) {
                $ret .= "," . (int)$limitB;
            }
            
            $ret .= " ";
        }
    
        return $ret;
    }

    /**
     * parseOrderBy()
     * @type public
     * @args $orderBy
     * @return Success - string
     *         Fail - origional string
     */
    public function parseOrderBy($orderBy) {
        $ret = $orderBy;
        $orderBy = $this->parseFields($orderBy);
        
        if (!empty($orderBy)) {
            $ret = " order by " . (string)$orderBy;
        }
        
        return $ret;
    }
    
    /**
     * parseGroupBy()
     * @type public
     * @args $groupBy
     * @return Success - string
     *         Fail - origional string
     */
    public function parseGroupBy($groupBy) {
        $ret = $groupBy;
        $groupBy = $this->parseFields($groupBy);
    
        if (!empty($groupBy)) {
            $ret = " group by " . (string)$groupBy;
        }
        
        return $ret;
    }

    /**
     * parseJoin()
     * @type public
     * @args $join, [optional $on]
     * @return Success - string
     *         Fail - origional string
     */
    public function parseJoin($join, $on = "") {
        $ret = $join;
        $join = $this->parseTable($join);
        
        if (!empty($join)) {
            $ret = " left join (" . (string)$join . ")";
            $on = $this->parseWhere($on);
            
            if (!empty($on)) {
                $ret .= " on (" . (string)$on . ")";
            }
        }
        
        return $ret;
    }
    
    /**
     * parseData()
     * @type public
     * @args $data
     * @return Success - string
     *         Fail - origional string
     */
    public function parseData($data) {
        $ret = $data;
        
        if (is_array($data)) {
            $ret = "";
            $arrData = array();
            
            foreach ($data as $index => $value) {
                if (!is_numeric($index) && !empty($index) && !is_numeric($value) && !empty($value)) {
                    $parseFieldName = $this->findFields($index);
                    
                    if (!empty($parseFieldName)) {
                        $arrData[] = (string)$parseFieldName . "='" . (string)$this->parseValue($value) . "'";
                    }
                    else {
                        $arrData[] = "`" . (string)$this->parsekey($index) . "`='" . (string)$this->parseValue($value) . "'";
                    }
                    
                    $parseFieldName = null;
                }
            }
            
            $ret = (count($arrData) > 0) ? implode(",", $arrData) : "";
            
            $arrData = null;
        }
        
        return $ret;
    }
    
    /**
     * parseShow()
     * @type public
     * @args $shows
     * @return Success - string
     *         Fail - origional string
     */
    public function parseShow($shows) {
        $ret = $shows;
        
        if (is_array($shows)) {
            $ret = "";
            $arrShow = array();
            
            foreach ($shows as $index => $show) {
                if (is_numeric($index) && !is_numeric($show) && !empty($show)) {
                    $parseShowName = $this->findCommand($show);
                    
                    if (!empty($parseShowName)) {
                        $arrShow[] = $parseShowName;
                    }
                    
                    $parseShowName = null;
                }
            }
            
            $ret = (count($arrShow) > 0) ? implode(" ", $arrShow) : "";
            
            $arrShow = null;
        }
        
        return $ret;
    }
    
    /**
     * parseSQL()
     * @type public
     * @args $action
     * @return Success - string
     *         Fail - origional string
     */
    public function parseSQL($action) {
        $ret = "";
        
        $table = $this->table;
        $fields = $this->fields;
        $where = $this->where;
        $limit = $this->limit;
        $orderBy = $this->orderBy;
        $groupBy = $this->groupBy;
        $join = $this->join;
        $dataList = $this->dataList;
        $show = $this->show;
        
        switch (strtolower($action)) {
            case "select":
                if (!empty($table)) {
                    $ret = "select";
                    $ret .= (!empty($fields)) ? " " . (string)$fields : " *";
                    $ret .= " from " . (string)$table;
                    $ret .= (!empty($join)) ? (string)$join : "";
                    $ret .= (!empty($where)) ? " where " . (string)$where : "";
                    $ret .= (!empty($groupBy)) ? (string)$groupBy : "";
                    $ret .= (!empty($orderBy)) ? (string)$orderBy : "";
                    $ret .= (!empty($limit)) ? (string)$limit : "";
                }
                
            break;
            
            case "insert":
                if (!empty($table) && !empty($dataList)) {
                    $ret = "insert into";
                    $ret .= " " . (string)$table;
                    $ret .= " set " . (string)$dataList;
                }
                
            break;
            
            case "update":
                if (!empty($table) && !empty($dataList)) {
                    $ret = "update";
                    $ret .= " " . (string)$table;
                    $ret .= " set " . (string)$dataList;
                    $ret .= (!empty($where)) ? " where " . (string)$where : "";
                }
            
            break;
            
            case "delete":
                if (!empty($table)) {
                    $ret = "delete";
                    $ret .= " from " . (string)$table;
                    $ret .= (!empty($where)) ? " where " . (string)$where : "";
                }
                
            break;
            
            case "create":
                
            break;
            
            case "total":
                if (!empty($table)) {
                    $ret = "select count(*) as `count`";
                    $ret .= " from " . (string)$table;
                    $ret .= (!empty($where)) ? " where " . (string)$where : "";
                }
                
            break;
            
            case "show":
                if (!empty($show)) {
                    $ret = "show " . (string)$show;
                    $ret .= (!empty($table)) ? " from " . (string)$table : "";
                }
                
            break;
        }
        
        $show = null;
        $dataList = null;
        $join = null;
        $groupBy = null;
        $orderBy = null;
        $limit = null;
        $where = null;
        $fields = null;
        $table = null;
        
        return $ret;
    }
    
    /**
     * parseReset()
     * @type public
     * @args void
     * @return Success - void
     *         Fail - void
     */
    public function parseReset() {
        $this->table = "";
        $this->fields = "";
        $this->where = "";
        $this->limit = "";
        $this->orderBy = "";
        $this->groupBy = "";
        $this->join = "";
        $this->dataList = "";
        $this->show = "";
    }

    /**
     * parseKey()
     * @type private
     * @args $key
     * @return Success - string
     *         Fail - origional string
     */
    private function parseKey($key) {
        return $this->escape(trim($key), $this->link);
    }
    
    /**
     * parseValue()
     * @type private
     * @args $value
     * @return Success - string
     *         Fail - origional string
     */
    private function parseValue($value) {
        return $this->escape(trim($value), $this->link);
    }
    
    /**
     * stripRightOper()
     * @type private
     * @args $sql
     * @return Success - string
     *         Fail - origional string
     */
    private function stripRightOper($sql) {
        $ret = $sql;
        $sql = rtrim($sql);
        
        if (!empty($sql)) {
            $sql = rtrim($sql, "and");
            $sql = rtrim($sql, "or");
            $sql = rtrim($sql, "xor");
            $sql = rtrim($sql, "&&");
            $sql = rtrim($sql, "||");
            $ret = rtrim($sql);
            
            // $ret = rtrim($sql, implode(" ", array("and", "or", "xor", "&&", "||")));
        }
        
        return $ret;
    }
    
    /**
     * findMathOpers()
     * @type private
     * @args $opers, [optional $defaultOper]
     * @return Success - string
     *         Fail - default string
     */
    private function findMathOpers($opers, $defaultOper = "and") {
        $ret = $defaultOper;
        
        if (!empty($opers)) {
            $arrOperation = array("and", "or", "xor", "&&", "||");
            
            foreach ($arrOperation as $index => $oper) {
                if (strtolower($opers) == $oper) {
                    $ret = (string)$oper;
                    
                    break;
                }
            }
            
            $arrOperation = null;
        }
        
        return $ret;
    }
    
    /**
     * findFields()
     * @type private
     * @args $fields, [optional $table, $useAlias]
     * @return Success - string
     *         Fail - empty string
     */
    private function findFields($fields, $table = "", $useAlias = false) {
        $ret = "";
        
        if (!empty($fields)) {
            $fields = trim($fields);
            $arrSecs = explode(" ", $fields);
            $secLength = count($arrSecs);
            
            if ($secLength == 3) {
                $arrTables = explode(".", $arrSecs[0]);
                $tableLength = count($arrTables);
               
                if ($tableLength == 2) {
                    $ret = "`" . 
                        (string)$this->parsekey($arrTables[0]) . "`.`" . 
                        (string)$this->parsekey($arrTables[1]) . "` " . 
                        (string)$this->parsekey($arrSecs[1]) . " `" . 
                        (string)$this->parsekey($arrSecs[2]) . "`";
                }
                else {
                    $ret .= (!empty($table)) ? "`" . (string)$this->parsekey($table) . "`." : "";
                    $ret .= "`" . 
                        (string)$this->parsekey($arrTables[0]) . "` " . 
                        (string)$this->parsekey($arrSecs[1]) . " `" . 
                        (string)$this->parsekey($arrSecs[2]) . "`";
                }
                
                $tableLength = null;
                $arrTables = null;
            }
            else {
                $arrTables = explode(".", $arrSecs[0]);
                $tableLength = count($arrTables);
                
                if ($tableLength == 2) {
                    if (!$useAlias && $secLength == 2) {
                        $ret = "`" . 
                            (string)$this->parsekey($arrTables[0]) . "`.`" . 
                            (string)$this->parsekey($arrTables[1]) . "` " .
                            (string)$this->parsekey($arrSecs[1]);
                    }
                    else {
                        $ret = "`" . 
                            (string)$this->parsekey($arrTables[0]) . "`.`" . 
                            (string)$this->parsekey($arrTables[1]) . "`";
                    }
                }
                else {
                    if (!$useAlias && $secLength == 2) {
                        $ret .= (!empty($table)) ? "`" . (string)$this->parsekey($table) . "`." : "";
                        $ret .= "`" . 
                            (string)$this->parsekey($arrTables[0]) . "` " . 
                            (string)$this->parsekey($arrSecs[1]) . "";
                    }
                }
                
                $tableLength = null;
                $arrTables = null;
            }
            
            $secLength = null;
            $arrSecs = null;
        }
        
        return $ret;
    }
    
    /**
     * findCommand()
     * @type private
     * @args $commands
     * @return Success - string
     *         Fail - empty string
     */
    private function findCommand($commands) {
        $ret = "";
        
        if (!empty($commands)) {
            $commands = trim($commands);
            $arrSecs = explode(" ", $commands);
            $arrCmds = array();
            
            foreach ($arrSecs as $index => $cmd) {
                $arrCmds[] = (string)$this->parseKey($cmd);
            }
            
            $ret = (count($arrCmds) > 0) ? implode(" ", $arrCmds) : "";
            
            $arrCmds = null;
            $arrSecs = null;
        }
        
        return $ret;
    }
}
?>
