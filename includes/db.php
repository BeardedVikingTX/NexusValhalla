<?php
/**
 * db.php – Database Connection (MySQLi – PROVEN TO WORK!)
 */

class Database {
    private static $instance = null;
    private $mysqli;
    private $connected = false;
    private $error = null;
    
    private function __construct() {
        try {
            // Use MySQLi – this works on your server!
            $this->mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            
            if ($this->mysqli->connect_error) {
                throw new Exception($this->mysqli->connect_error);
            }
            
            $this->mysqli->set_charset("utf8mb4");
            $this->connected = true;
            
            error_log('[NEXUS] Database connection successful via MySQLi!');
            
        } catch (Exception $e) {
            $this->error = $e->getMessage();
            error_log('[NEXUS] MySQLi connection failed: ' . $e->getMessage());
            $this->mysqli = null;
            $this->connected = false;
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function isConnected() {
        return $this->connected && $this->mysqli !== null;
    }
    
    public function getError() {
        return $this->error;
    }
    
    public function getConnection() {
        return $this->mysqli;
    }
    
    /**
     * Execute a query with prepared statement
     */
    public function query($sql, $params = []) {
        if (!$this->isConnected()) {
            error_log('[NEXUS] Query attempted but database not connected');
            return false;
        }
        
        try {
            $stmt = $this->mysqli->prepare($sql);
            if (!$stmt) {
                error_log('[NEXUS] Prepare failed: ' . $this->mysqli->error);
                return false;
            }
            
            if (!empty($params)) {
                $types = '';
                $bindParams = [];
                foreach ($params as $param) {
                    if (is_int($param)) {
                        $types .= 'i';
                    } elseif (is_double($param)) {
                        $types .= 'd';
                    } else {
                        $types .= 's';
                    }
                    $bindParams[] = $param;
                }
                $stmt->bind_param($types, ...$bindParams);
            }
            
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            
            return $result;
            
        } catch (Exception $e) {
            error_log('[NEXUS] Query error: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Fetch a single row
     */
    public function fetchOne($sql, $params = []) {
        $result = $this->query($sql, $params);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return false;
    }
    
    /**
     * Fetch all rows
     */
    public function fetchAll($sql, $params = []) {
        $result = $this->query($sql, $params);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    
    /**
     * Insert and return last insert ID
     */
    public function insert($sql, $params = []) {
        if (!$this->isConnected()) {
            error_log('[NEXUS] Insert attempted but database not connected');
            return false;
        }
        
        try {
            $stmt = $this->mysqli->prepare($sql);
            if (!$stmt) {
                error_log('[NEXUS] Insert prepare failed: ' . $this->mysqli->error);
                return false;
            }
            
            if (!empty($params)) {
                $types = '';
                $bindParams = [];
                foreach ($params as $param) {
                    if (is_int($param)) {
                        $types .= 'i';
                    } elseif (is_double($param)) {
                        $types .= 'd';
                    } else {
                        $types .= 's';
                    }
                    $bindParams[] = $param;
                }
                $stmt->bind_param($types, ...$bindParams);
            }
            
            $stmt->execute();
            $id = $stmt->insert_id;
            $stmt->close();
            
            return $id;
            
        } catch (Exception $e) {
            error_log('[NEXUS] Insert error: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Execute a raw query
     */
    public function exec($sql) {
        if (!$this->isConnected()) return false;
        return $this->mysqli->query($sql);
    }
}