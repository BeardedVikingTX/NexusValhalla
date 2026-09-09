<?php
/**
 * db.php – Database Connection & Query Helper
 * 
 * Provides a secure PDO wrapper for all database operations.
 * Usage:
 *   $db = Database::getInstance();
 *   $result = $db->query('SELECT * FROM votes WHERE email = ?', [$email]);
 */

class Database {
    private static $instance = null;
    private $pdo;
    private $stmt;

    // Private constructor – use getInstance()
    private function __construct() {
        // Load DB credentials from config (defined in config.php)
        $host = defined('DB_HOST') ? DB_HOST : 'localhost';
        $dbname = defined('DB_NAME') ? DB_NAME : 'nexusvalhalla';
        $user = defined('DB_USER') ? DB_USER : 'root';
        $pass = defined('DB_PASS') ? DB_PASS : '';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            // Log error and throw a user-friendly message
            error_log('Database connection failed: ' . $e->getMessage());
            throw new RuntimeException('Database connection error. Please try again later.');
        }
    }

    // Singleton pattern – only one connection
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Execute a prepared statement with parameters.
     * @param string $sql  SQL query with placeholders
     * @param array  $params  Values to bind
     * @return PDOStatement  The executed statement (for fetching)
     */
    public function query($sql, $params = []) {
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute($params);
        return $this->stmt;
    }

    /**
     * Fetch a single row
     */
    public function fetchOne($sql, $params = []) {
        return $this->query($sql, $params)->fetch();
    }

    /**
     * Fetch all rows
     */
    public function fetchAll($sql, $params = []) {
        return $this->query($sql, $params)->fetchAll();
    }

    /**
     * Insert a new row and return the last insert ID
     */
    public function insert($sql, $params = []) {
        $this->query($sql, $params);
        return $this->pdo->lastInsertId();
    }

    /**
     * Get the total number of rows affected by the last query
     */
    public function rowCount() {
        return $this->stmt ? $this->stmt->rowCount() : 0;
    }

    // Prevent cloning and unserialization
    private function __clone() {}
    public function __wakeup() {}
}