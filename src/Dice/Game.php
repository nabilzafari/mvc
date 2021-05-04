<?php

declare(strict_types=1);

namespace Webbprogrammering\Dice;

use Webbprogrammering\Dice\Dice;
use Webbprogrammering\Dice\DiceHand;
use Webbprogrammering\Dice\GraphicalDice;

use function Mos\Functions\{
    redirectTo,
    renderView,
    sendResponse,
    url
};



/**
 * Class Game.
 */
class Game
{

    public function playGame(): void
    {
        $data = [
                    "header" => "Dice",
                    "message" => "Hey! Lets play Dice Game",
                ];

        $dice = new GraphicalDice();

        if (!isset($_SESSION['show_buttons'])) {
            $_SESSION['show_buttons'] = true;
        }
        if (!isset($_SESSION['total_points'])) {
            $_SESSION['total_points'] = 0;
        }

        if (!isset($_SESSION['computer_points'])) {
            $_SESSION['computer_points'] = 0;
        }

        $data["hand"] = [];
        $data["action"] = "dice";
        for ($i = 0; $i < $_SESSION['output'] ?? 1; $i++) {
            $dice->roll();
            $diceValue = $dice->getLastRoll();
            $_SESSION['total_points'] += $diceValue;
            array_push($data["hand"], $dice->graphic());
        }

        if ($_SESSION['total_points'] >= 21) {
            $this->computerGame();
            return;
        }

        $body = renderView("layout/dice.php", $data);
        sendResponse($body);
    }

    public function computerGame(): void
    {
        $data = [
            "header" => "Dice",
            "message" => "Your Dice game has ended",
        ];

        $dice = new Dice();

        $data["hand"] = [];
        $data["action"] = "dice";
        $_SESSION['computer_points'] = 0;
        for ($i = 0; $i < $_SESSION['output'] ?? 1; $i++) {
            $dice->roll();
            $diceValue = $dice->getLastRoll();
            $_SESSION['computer_points'] += $diceValue;
        }
        //die(var_dump($_SESSION));
        while ($_SESSION['computer_points'] < 16) {
            $dice->roll();
            $diceValue = $dice->getLastRoll();
            $_SESSION['computer_points'] += $diceValue;
        }
        if (!isset($_SESSION['computer_won'])) {
            $_SESSION['computer_won'] = 0;
        }
        if (!isset($_SESSION['you_won'])) {
            $_SESSION['you_won'] = 0;
        }
        if ($_SESSION['total_points'] > 21) {
            $data["message"] = "You are Busted..!! ";
            $_SESSION["show_buttons"] = false;
        } else if ($_SESSION['computer_points'] <= 21 && $_SESSION['computer_points'] > $_SESSION['total_points']) {
            $data["message"] = "Computer Won";
            $_SESSION['computer_won'] += 1;
            $_SESSION["show_buttons"] = false;
        } else if ($_SESSION['total_points'] <= 21 && $_SESSION['total_points'] > $_SESSION['computer_points']) {
            $data["message"] = "Huraaaahhh You Won";
            $_SESSION['you_won'] += 1;
            $_SESSION["show_buttons"] = false;
        } else if ($_SESSION['total_points'] == $_SESSION['computer_points'] && $_SESSION['computer_points'] == $_SESSION['total_points']) {
            $data["message"] = "It's a Draw. Play Again!";
            $_SESSION['you_won'] += 0;
            $_SESSION['computer_won'] += 0;
            $_SESSION["show_buttons"] = false;
        }

        // var_dump($_SESSION);
        $body = renderView("layout/dice.php", $data);
        sendResponse($body);
    }

    public function results(): void
    {

        if (!isset($_SESSION['computer_won'])) {
            $_SESSION['computer_won'] = 0;
        }
        if (!isset($_SESSION['you_won'])) {
            $_SESSION['you_won'] = 0;
        }        $data = [
            "header" => "Results",
            "message" => "You Won: " . $_SESSION['you_won'] . "<br>  Computer Won: " . $_SESSION['computer_won'],
        ];

        $body = renderView("layout/results.php", $data);
        sendResponse($body);
    }
}
