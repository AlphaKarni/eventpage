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
    public function fetchByEmail(string $checkMail): false|UserDTO
    {
        $query = "SELECT * FROM Event.Users WHERE email = '$checkMail'";
        $luser = $this->db->select($query);
        if (empty($luser[0]))
        {
            return false;
        }
        return $this->mapper->getUserDTO($luser[0]);
    }
    public function fetchByUsername(string $checkUsername){
        $query = "SELECT * FROM Event.Users WHERE username = '$checkUsername'";
        $luser = $this->db->select($query);
        if (empty($luser[0]))
        {
            return false;
        }
        return $this->mapper->getUserDTO($luser[0]);
    }
    public function emailExists(string $checkMail): bool
    {
        $query = "SELECT * FROM Event.Users WHERE email = '$checkMail'";
        $emailFound = $this->db->select($query);
        return !empty($emailFound);
    }
    public function usernameExists(string $checkUsername): bool
    {
        $query = "SELECT * FROM Event.Users WHERE username = '$checkUsername'";
        $usernameFound = $this->db->select($query);
        return !empty($usernameFound);
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