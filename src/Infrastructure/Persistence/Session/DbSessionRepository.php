<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Session;

use App\Domain\Session\SessionRepository;
use App\Infrastructure\Db\DB;

class DbSessionRepository implements SessionRepository
{
    public function getSessions(): array
    {
        $query = 'SELECT * FROM sessions';
        try
            {
                $db = new Db();
                $conn = $db->connect();
                $stmt = $conn->prepare($query);
                
                $stmt->execute();
                $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            } catch (\PDOException $e) {
                echo $e->getMessage(); die();
            }   
        return $result;
    }
}