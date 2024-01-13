<?php

class DB
{
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'db_kasir_adit';
    private $connection;

    public function __construct()
    {
        // Constructor
    }

    private function connect()
    {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    private function disconnect()
    {
        if ($this->connection) {
            $this->connection->close();
        }
    }

    private function query($sql)
    {
        $this->connect();
        $result = $this->connection->query($sql);
        $this->disconnect();

        return $result;
    }

    private function escapeString($value)
    {
        $this->connect();
        $escapedValue = $this->connection->real_escape_string($value);
        $this->disconnect();

        return $escapedValue;
    }

    private function setSessionUser($id)
    {
        $sql = "SELECT * FROM user WHERE id = '$id'";
        $result = $this->query($sql);

        $user = $result->fetch_assoc();

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['user'] = $user;

        return true;
    }

    private function swal($icon = "", $title = "", $text = "")
    {
        echo "<script> Swal.fire({icon: '$icon',title: '$title', text:'$text'})</script>";
    }

    // Example CRUD methods
    public function insert($table, $data)
    {
        $columns = implode(", ", array_keys($data));
        $values = implode("', '", array_map([$this, 'escapeString'], array_values($data)));

        $sql = "INSERT INTO $table ($columns) VALUES ('$values')";
        return $this->query($sql);
    }

    public function select($table, $columns = "*", $condition = "")
    {
        $sql = "SELECT $columns FROM $table";
        if ($condition !== "") {
            $sql .= " WHERE $condition";
        }

        $result = $this->query($sql);

        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        return $rows;
    }

    public function update($table, $data, $condition)
    {
        $setClause = implode(", ", array_map(function ($key, $value) {
            return "$key = '$value'";
        }, array_keys($data), array_values($data)));

        $sql = "UPDATE $table SET $setClause WHERE $condition";
        return $this->query($sql);
    }

    public function delete($table, $condition)
    {
        $sql = "DELETE FROM $table WHERE $condition";
        return $this->query($sql);
    }

    public function login($email, $password, $remember)
    {
        $password = md5($password);
        $sql = "SELECT * FROM user WHERE email = '$email'";
        $result = $this->query($sql);

        $user = $result->fetch_assoc();

        if ($user['password'] === $password) {
            if ($user['status'] === 'nonaktif') {
                return $this->swal('error', 'Gagal!', 'Aktivasi akun terlebih dahulu! Silahkan lapor ke admin');
            }
            if ($remember) {
                $cookie_name = "_users";
                $cookie_value = json_encode($user);
                setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
            }
            $this->setSessionUser($user['id']);
            echo "<script> window.location.href = '../dashboard' </script>";
        }
        return $this->swal('error', 'Gagal!', 'Email atau Password salah!');
    }
}

// Example insert
// $dataToInsert = array("name" => "John Doe", "email" => "john@example.com");
// $database->insert("users", $dataToInsert);

// Example select
// $users = $database->select("users", "*", "id > 1");
// print_r($users);

// Example update
// $dataToUpdate = array("name" => "Jane Doe");
// $database->update("users", $dataToUpdate, "id = 1");

// Example delete
// $database->delete("users", "id = 2");
