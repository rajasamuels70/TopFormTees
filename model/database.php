<?php

class Database{
    
    private static $dsn = 'mysql:host=localhost;dbname=topformtees';
    private static $username = 'mgs_user';
    private static $passworddb = 'pa55word';
    private static $db;
    
    private function __construct() {}
    
    public static function getDB () {
        if (!isset(self::$db)) {
            try {
                self::$db = new PDO(self::$dsn,
                                     self::$username,
                                     self::$passworddb);
                
                    self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                $error_message = $e->getMessage();
                include('../view/database_error.php');
                exit();
            }
        }
        return self::$db;
    }
}

?>