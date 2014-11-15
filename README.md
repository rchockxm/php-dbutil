php-dbutil
==========

PHP library for database (CRUD and more)

<h2><a name="about" class="anchor" href="#about"><span class="mini-icon mini-icon-link"></span></a>About</h2>

PHP database framework to accelerate development.

<h2><a name="usage" class="anchor" href="#about"><span class="mini-icon mini-icon-link"></span></a>Require</h2>

-PHP 5.3+

<h2><a name="usage" class="anchor" href="#about"><span class="mini-icon mini-icon-link"></span></a>Usage</h2>

```php
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
```

<h2><a name="about" class="anchor" href="#about"><span class="mini-icon mini-icon-link"></span></a>Changelog</h2>

<h4>1.0</h4/>
- Fixed some bugs.

<h2><a name="author" class="anchor" href="#author"><span class="mini-icon mini-icon-link"></span></a>Author</h2>
* 2014 rchockxm (rchockxm.silver@gmail.com)

<h2><a name="credits" class="anchor" href="#credits"><span class="mini-icon mini-icon-link"></span></a>Credits</h2>
