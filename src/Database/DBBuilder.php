<?php
namespace MaxPHPApi\Database;

use Dotenv\Dotenv;
use PDO;

class DBBuilder {
    private PDO $pdo;

    public function __construct(private string $host = '', private string $db = '', private string $user = '', private string $pass = '') {

        //TODO fix
        //$dotenv = Dotenv::createImmutable(__DIR__ . '/../config');
        //$dotenv->load();
            $host = 'localhost';
            $db = 'php-test';
            $user = 'root';
            $pass = 'root';

        $dsn = "mysql:host=$host;dbname=$db;charset=utf8";
        $this->pdo = new PDO($dsn, $user, $pass);
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
