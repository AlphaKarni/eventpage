<?php declare(strict_types=1);

namespace App\Model;

use App\Database\Database;
use App\Model\DTOs\UserDTO;

class UserRepository
{
    public function findByEmail(string $checkmail, string $userFilePath): UserDTO|array
    {
        $users = json_decode(file_get_contents($userFilePath), true);

        foreach ($users as $luser) {
            if ($luser['email'] === $checkmail) {
                $userDTO = new UserDTO($luser['username'],$luser['email'], $luser['password']);
                return $userDTO;
            }
        }
        return [];
    }
    public function findByUsername(string $checkusername, string $userFilePath): UserDTO|array
    {
        $users = json_decode(file_get_contents($userFilePath), true);
        foreach ($users as $luser) {
            if ($luser['username'] === $checkusername) {
                $userDTO = new UserDTO($luser['username'],$luser['email'], $luser['password']);
                return $userDTO;
            }
        }
        return [];
    }
    public function fetchEventUsers($eventID): array
    {
        $db = new Database();
        $query = "SELECT * FROM Event.Events WHERE ID = $eventID ";
        return $db->select($query,[]);
    }
}