<?php declare(strict_types=1);

namespace App\View;

interface ViewInterface
{
    public function render(string $template, array $params = []): void;
}
