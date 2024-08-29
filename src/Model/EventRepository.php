<?php

namespace App\Model;

class EventRepository
{
    private $filePath;
    public function __construct($filePath = null)
    {
        $this->filePath = $filePath ?? __DIR__ . '/../../events.json';
    }
    public function findAllEvents(): array
    {
        if ($this->fileExists($this->filePath)) {
            return $this->loadEvents();
        }
        return [];
    }

    public function fileExists($filePath): bool
    {
        return file_exists($filePath);
    }

    public function loadEvents(): array
    {
        return json_decode(file_get_contents($this->filePath), true);
    }
}