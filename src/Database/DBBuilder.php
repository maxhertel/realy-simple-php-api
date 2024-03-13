<?php
namespace MaxPHPApi\Database;

use Dotenv\Dotenv;
use PDO;

class DBBuilder {
    private PDO $pdo;

    function __construct( string $host = '', string $db = '', string $user = '',  string $pass = '') {

        //TODO fix - remove the trim()
        $dotenv = Dotenv::createMutable(trim(__DIR__,'.Database') . "/config");
        $dotenv->load();
        $host = $_ENV['DB_HOST'];
        $db = $_ENV['DB_NAME'];
        $user = $_ENV['DB_USER'];
        $pass = $_ENV['DB_PASS'];
        
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
        try {
            $this->query($sql);
        } catch (\PDOException $e) {
            echo "Erro ao executar a query de inserção " . $e->getMessage();
        }
    }

    public function update(string $table, array $data, string $where, array $params = []): void {
        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "$key = $value";
        }
        $setClause = implode(',', $set);
        $sql = "UPDATE $table SET $setClause WHERE $where";
    
        try {
            $this->query($sql);
        } catch (\PDOException $e) {
            echo "Erro ao executar a query de atualização: " . $e->getMessage();
        }
    }


    public function truncate(string $table): void {
        $sql = "DELETE FROM $table";
        $this->query($sql);
    }
}
