<?php
namespace MaxPHPApi\Database;

use PDO;

class DBBuilder {
    private PDO $pdo;

    public function __construct(private string $host = '', private string $db = '', private string $user = '', private string $pass = '') {
        if (!$this->host || !$this->db || !$this->user || !$this->pass) {
            $this->host = getenv('DB_HOST');
            $this->db = getenv('DB_NAME');
            $this->user = getenv('DB_USER');
            $this->pass = getenv('DB_PASS');
        }

        $dsn = "mysql:host=$this->host;dbname=$this->db;charset=utf8";
        $this->pdo = new PDO($dsn, $this->user, $this->pass);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function query(string $sql, array $params = []): array {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function select(string $table, ?string $where = null, array $params = []): array {
        $sql = "SELECT * FROM $table";
        if ($where) {
            $sql .= " WHERE $where";
        }
        return $this->query($sql, $params);
    }

    public function insert(string $table, array $data): void {
        $keys = implode(',', array_keys($data));
        $values = ':' . implode(',:', array_keys($data));
        $sql = "INSERT INTO $table ($keys) VALUES ($values)";
        $this->query($sql, $data);
    }
}
