<?php

interface Sql { function init(); function id(int $id):string; }

class Mysql implements Sql {
    private $init=false;
    function __construct($dns,$user,$pass) {  }
    function init() { if(!$this->init) echo 'Connexion Mysql...'.PHP_EOL; $this->init = true; } 
    function id(int $id):string { if(!$this->init) $this->init(); return "SqlId {$id}"; }
}; 
class PostgreSql implements Sql { 
    private $init=false;
    function __construct($dns,$user,$pass) {  }
    function init() { if(!$this->init) echo 'Connexion PostgreSql...'.PHP_EOL; $this->init =  true; } 
    function id(int $id):string { if(!$this->init) $this->init(); return "PostGreId {$id}"; }
}; 
class OracleSql implements Sql { 
    private $init=false;
    function __construct($dns,$user,$pass) {  }
    function init() { if(!$this->init) echo 'Connexion OracleSql...'.PHP_EOL; $this->init = true; } 
    function id(int $id):string { if(!$this->init) $this->init(); return "OracleId {$id}"; }
}; 

$mysql = new MySql("mysql:host=localhost;dbname=essai", 'root', 'root');
$pgsql = new PostgreSql("pgsql:host=localhost;dbname=essai", 'root', 'root');
$orsql = new OracleSql("orsql:host=localhost;dbname=essai", 'root', 'root');
$mysql = new MySql("mysql:host=localhost;dbname=essai", 'root', 'root');
$pgsql = new PostgreSql("pgsql:host=localhost;dbname=essai", 'root', 'root');
$orsql = new OracleSql("orsql:host=localhost;dbname=essai", 'root', 'root');
$mysql = new MySql("mysql:host=localhost;dbname=essai", 'root', 'root');
$pgsql = new PostgreSql("pgsql:host=localhost;dbname=essai", 'root', 'root');
$orsql = new OracleSql("orsql:host=localhost;dbname=essai", 'root', 'root');

class NewsManager
{
    private $db;
    function __construct()
    {
        
    }
    
    function setDb(Sql $db)
    {
        $this->db = $db;
    }
    
    function get($id)
    {
        $news = $this->db->id($id);
        return "Get news {$news} ...";
    }
}

$news = new NewsManager( );
$news->setDb( $mysql );
echo $news->get(1);
$news->setDb( $pgsql );
echo $news->get(3);
