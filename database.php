<?php
/*$conexao = mysqli_connect("localhost", "root", "", "api_google");
//$conexao = mysqli_connect('sql111.byethost18.com', 'b18_17886048', 'pletff24', 'b18_17886048_api_google');                       

if (!$conexao) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

//echo "Conexão realizada com sucesso." . PHP_EOL;
//echo "Host information: " . mysqli_get_host_info($conexao) . PHP_EOL;

//mysqli_close($conexao);*/

class Database
{
    private static $dbName = 'api_google' ;
    private static $dbHost = 'localhost' ;
    private static $dbUsername = 'root';
    private static $dbUserPassword = '';
     
    private static $cont  = null;
     
    public function __construct() {
        die('Init function is not allowed');
    }
     
    public static function connect()
    {
       // One connection through whole application
       if ( null == self::$cont )
       {     
        try
        {
          self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword); 
        }
        catch(PDOException $e)
        {
          die($e->getMessage()); 
        }
       }
       return self::$cont;
    }
     
    public static function disconnect()
    {
        self::$cont = null;
    }
}

?>
