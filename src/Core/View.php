<?php
namespace App\Core;

use Latte\Engine;

class View implements ViewInterface
{
    private Engine $latte;
    private array $parameters = [];

    public function __construct()
    {
        $this->latte = new Engine();
    }

    public function addParameter(string $key, mixed $value): void
    {
        $this->parameters[$key] = $value;
    }

    public function display(string $template): void
    {
        $this->latte->render($template, $this->parameters);
    }
}
