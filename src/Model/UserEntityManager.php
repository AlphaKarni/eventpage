<?php declare(strict_types=1);

namespace App\Model;
use App\Database\Database;
class UserEntityManager

{
    public function __construct
    (public Database $db) {}
    public function saveUser(array $user): void
    {
        $query = "INSERT INTO Event.Users (username, email, password) VALUES (?, ?, ?)";
        $this->db->select($query, [$user["username"], $user["email"], $user["password"]]);
    }
}
