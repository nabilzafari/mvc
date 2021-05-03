<?php

declare(strict_types=1);

namespace Webbprogrammering\Dice;

class GraphicalDice extends Dice
{
    public function graphic()
    {
        return "dice-" . $this->getLastRoll() . " ";
    }
}
