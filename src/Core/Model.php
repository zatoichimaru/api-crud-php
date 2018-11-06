<?php
namespace Core;

use \PDO;

class Model extends \PDO
{
    private static $pdoInstance = NULL;

    protected $connect = array
	(
		'user' => 'root',
		'pass' => '',
		'host' => 'localhost',
		'dbname' => 'test',
		'driver' => 'mysql',
	);

    public function __construct()
	{
		$this->connectDB();
    }
    
    private function connectDB()
	{
        if (self::$pdoInstance == NULL)
        {
			try {
			    $conn = $this->connect;
			    $dsn = "$conn[driver]:dbname=$conn[dbname];host=$conn[host]";
			    self::$pdoInstance = parent::__construct($dsn, $conn['user'], $conn['pass'],
				    array(
					    PDO::ATTR_ERRMODE,
					    PDO::ERRMODE_EXCEPTION,
					    PDO::ERRMODE_SILENT,
					    PDO::ERRMODE_WARNING,
					    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
					    PDO::MYSQL_ATTR_FOUND_ROWS => true,
					    PDO::ATTR_EMULATE_PREPARES => false,
				    )
			    );
			} catch (Exception $e) {
			    echo 'Exceção capturada: ',  $e->getMessage(), "\n";
			}
        }

		return self::$pdoInstance;
	}

	public function __destruct()
	{
	    self::$pdoInstance = NULL;
	}
}
