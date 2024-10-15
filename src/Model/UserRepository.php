<?php declare(strict_types=1);

namespace App\Model;
use App\Database\Database;
use App\Model\DTOs\UserDTO;
use App\Model\Mapper\UserMapper;

class UserRepository
{
    public function __construct
    (
        public UserMapper $mapper,
        public Database $db
    ) {}
    public function fetchByEmail(string $checkmail): UserDTO|false
    {
        $query = "SELECT * FROM Event.Users WHERE email = '$checkmail'";
        $luser = $this->db->select($query);
        return $this->mapper->getUserDTO($luser[0]);
    }
    public function findByUsername(string $checkusername, string $userFilePath): UserDTO|array
    {
        $users = json_decode(file_get_contents($userFilePath), true);
        foreach ($users as $luser) {
            if ($luser['username'] === $checkusername) {
                return new UserDTO($luser['username'],$luser['email'], $luser['password']);
            }
        }
        return [];
    }
    public function fetchEventUsers($eventID): array
    {
        $query = "SELECT * FROM Event.Events WHERE eventID = ?";
        return $this->db->select($query,[$eventID]);
    }
    public function fetchAllParticipants(): array
    {
        $query = "SELECT * FROM Event.Participants";
        return $this->db->select($query);
    }
    public function fetchEventParticipants($eventID): array
    {
        $query = "SELECT username FROM Event.Participants WHERE eventID = ?";
        return $this->db->select($query, [$eventID]);
    }
}