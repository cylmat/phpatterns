<?php

namespace Phpatterns\Creational;

interface Sql { function init(); function id(int $id): string; }

class PostgreSql implements Sql { 
    private $init=false;
    function __construct($dns) {  }
    function init() { if(!$this->init) echo 'Connexion PostgreSql...'.PHP_EOL; $this->init =  true; } 
    function id(int $id):string { if(!$this->init) $this->init(); return "PostGreId {$id}"; }
}; 

class OracleSql implements Sql { 
    private $init=false;
    function __construct($dns) {  }
    function init() { if(!$this->init) echo 'Connexion OracleSql...'.PHP_EOL; $this->init = true; } 
    function id(int $id):string { if(!$this->init) $this->init(); return "OracleId {$id}"; }
}; 

$pgsql = new PostgreSql("pgsql:host=localhost;dbname=essai");
$orsql = new OracleSql("orsql:host=localhost;dbname=essai");

class NewsManager
{
    private $db;
    function __construct(Sql $db) { $this->db = $db; }

    function get($id) {
        $news = $this->db->id($id);
        return "Get news {$news} ...";
    }
}

$news = new NewsManager( );
$news->setDb( $mysql );
echo $news->get(1);
$news->setDb( $pgsql );
echo $news->get(3);
