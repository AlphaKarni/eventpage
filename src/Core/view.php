<?php declare(strict_types=1);

namespace App\View;

use Latte\Engine;

class View implements ViewInterface
{
    private Engine $latte;

    public function __construct()
    {
        $this->latte = new Engine();

        $this->latte->setTempDirectory(__DIR__ . '/../../temp');
    }

    public function render(string $template, array $params = []): void
    {
        $this->latte->render($template, $params);
    }
}
