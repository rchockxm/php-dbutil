php-dbutil
==========

PHP library for database (CRUD and more)

<h2><a name="about" class="anchor" href="#about"><span class="mini-icon mini-icon-link"></span></a>About</h2>

PHP database framework to accelerate development.

<h2><a name="require" class="anchor" href="#require"><span class="mini-icon mini-icon-link"></span></a>Require</h2>

-PHP 5.3+

<h2><a name="usage" class="anchor" href="#usage"><span class="mini-icon mini-icon-link"></span></a>Usage</h2>

```php
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

// Do something

$db->close($connect);
```

<h2><a name="demo" class="anchor" href="#demo"><span class="mini-icon mini-icon-link"></span></a>Demo</h2>

```php
// Insert
$query = $db->query("INSERT INTO `test` SET `name` = 'test1234'");

print_r( $query );

// Total
$query = $db->query("SELECT COUNT(*) as `total` FROM `test` WHERE `name` = 'test1234'");
$total = $db->fetchAssoc($query);

print_r( $total );

// Select
$query = $db->query("SELECT `name` FROM `test` WHERE `name` = 'test1234'");

while ($row = $db->fetchAssoc($query)) {
    print_r( $row );
}
```

```php
// Insert
$insert = $db->util($connect)->table("test")->insert(array(
    'name' => 'test' . rand(1, 1000)
));

print_r( $insert );

// Total
$total = $db->util($connect)->table("test")->total(array(
    'name' => 'test1234'
));

print_r( $total );

// Select
$select = $db->util($connect)->table("test")->select(array(
    'name' => 'test1234'
));

print_r( $select );
```

<h2><a name="function" class="anchor" href="#function"><span class="mini-icon mini-icon-link"></span></a>Function</h2>

```php
// Standard
$db->guid();
$db->util();
$db->getInstance();
$db->connect();
$db->close();
$db->query();
$db->freeResult();
$db->fetchAssoc();
$db->fetchArray();
$db->fetchRow();
$db->fetchField();
$db->fetchObject();
$db->escape();
$db->countAffected();
$db->getLastID();
$db->getError();

// Util
$db->util()->table();
$db->util()->fields();
$db->util()->where();
$db->util()->limit();
$db->util()->orderBy();
$db->util()->groupBy();
$db->util()->join();
$db->util()->data();
$db->util()->select();
$db->util()->delete();
$db->util()->update();
$db->util()->insert();
$db->util()->create();
$db->util()->total();
$db->util()->show();
$db->util()->parseFields();
$db->util()->parseTable();
$db->util()->parseWhere();
$db->util()->parseLimit();
$db->util()->parseOrderBy();
$db->util()->parseGroupBy();
$db->util()->parseJoin();
$db->util()->parseData();
$db->util()->parseShow();
$db->util()->parseSQL();
$db->util()->parseReset();
```

<h2><a name="changelog" class="anchor" href="#changelog"><span class="mini-icon mini-icon-link"></span></a>Changelog</h2>

<h4>1.0</h4/>
- Fixed some bugs.

<h2><a name="author" class="anchor" href="#author"><span class="mini-icon mini-icon-link"></span></a>Author</h2>
* 2014 rchockxm (rchockxm.silver@gmail.com)

<h2><a name="credits" class="anchor" href="#credits"><span class="mini-icon mini-icon-link"></span></a>Credits</h2>
