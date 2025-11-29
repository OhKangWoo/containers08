<?php

class Database {
    private $db;

    public function __construct($path = null) {
    $dbPath = __DIR__ . '/../data/mydatabase.db';

    $dir = dirname($dbPath);
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    $isNew = !file_exists($dbPath);

    $this->db = new PDO("sqlite:" . $dbPath);
    $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // dacă baza este proaspăt creată → inițializează tabelele
    if ($isNew) {
        $schema = file_get_contents(__DIR__ . '/../data/schema.sql');
        $this->db->exec($schema);
    }
}



    public function Execute($sql) {
        return $this->db->exec($sql);
    }

    public function Fetch($sql) {
        return $this->db->query($sql)->fetchAll();
    }

    public function Create($table, $data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_map(fn($k) => ":" . $k, array_keys($data)));
        $stmt = $this->db->prepare("INSERT INTO $table ($columns) VALUES ($placeholders)");
        $stmt->execute($data);
        return $this->db->lastInsertId();
    }

    public function Read($table, $id) {
        $stmt = $this->db->prepare("SELECT * FROM $table WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function Update($table, $id, $data) {
        $set = implode(", ", array_map(fn($k) => "$k = :$k", array_keys($data)));
        $data['id'] = $id;
        $stmt = $this->db->prepare("UPDATE $table SET $set WHERE id = :id");
        return $stmt->execute($data);
    }

    public function Delete($table, $id) {
        $stmt = $this->db->prepare("DELETE FROM $table WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function Count($table) {
        return $this->db->query("SELECT COUNT(*) FROM $table")->fetchColumn();
    }
}
