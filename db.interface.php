<?php
/**
 * DB-Util
 * Created by Silence Unlimited
 * Developer: Rchockxm (rchockxm.silver@gmail.com)
 * FileName: db.interface.php
 */
namespace DBCls;

/**
 * IADatabase
 */
interface IADatabase {

    /**
     * connect()
     * @type public
     * @args $config
     * @return Success - object
     *         Fail - null
     */
    public function connect($config);
    
    /**
     * close()
     * @type public
     * @args [optional $link]
     * @return Success - boolean(true)
     *         Fail - boolean(true)
     */
    public function close($link = null);
}
?>
