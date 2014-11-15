<?php
require("db.class.php");
require("db.util.class.php");
require("db.interface.php");

$database = getcwd() . "/database";
$db = new \DBCls\DB("mysql", $database);

$config = array(
    "hostname" => "",
    "username" => "",
    "userpwd" => "",
    "database" => "",
    "charset" => "utf8"
);

$connect = $db->connect($config);

// Method 1
$query = $db->query("SELECT * from `test`");

while ($row = $db->fetchAssoc($query)) {
    print_r( $row );
}

// Method 2
print_r( $db->util($connect)->table("test")->select() );

$db->close($connect);
?>
