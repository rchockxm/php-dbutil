<?php
require("db.class.php");
require("db.util.class.php");
require("db.interface.php");

$database = getcwd() . "/database";
$db = new \DBCls\DB("mysql", $database);

$config = array(
    "hostname" => "mysql.888webhost.com",
    "username" => "u871097379_a",
    "userpwd" => "123456",
    "database" => "u871097379_a",
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
