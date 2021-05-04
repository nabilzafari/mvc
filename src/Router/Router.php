<?php

declare(strict_types=1);

namespace Mos\Router;

use Webprogramming\Dice\Game;

use function Mos\Functions\{
    destroySession,
    redirectTo,
    renderView,
    renderTwigView,
    sendResponse,
    url
};

/**
 * Class Router.
 */
class Router
{
    public static function dispatch(string $method, string $path): void
    {
        if ($method === "GET" && $path === "/") {
            $data = [
                "header" => "Nabil Zafari",
                "message" => "Wellcome to Nabil Zafari's webpage for course MVC.",
            ];
            $body = renderView("layout/page.php", $data);
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/session") {
            $body = renderView("layout/session.php");
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/session/destroy") {
            destroySession();
            redirectTo(url("/session"));
            return;
        } else if ($method === "GET" && $path === "/results/destroy") {
            destroySession();
            redirectTo(url("/results"));
            return;
        } else if ($method === "GET" && $path === "/debug") {
            $body = renderView("layout/debug.php");
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/twig") {
            $data = [
                "header" => "Twig page",
                "message" => "Hey, edit this to do it youreself!",
            ];
            $body = renderTwigView("index.html", $data);
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/some/where") {
            $data = [
                "header" => "Rainbow page",
                "message" => "Hey, edit this to do it youreself!",
            ];
            $body = renderView("layout/page.php", $data);
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/yatzy") {
            $data = [
                "header" => "Nabil Zafari",
                "message" => "Wellcome to Nabil Zafari's webpage for course MVC.",
            ];
            $body = renderView("layout/page.php", $data);
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/results") {
            $callable = new \Webbprogrammering\Dice\Game();
            $callable->results();
            return;
            $body = renderView("layout/results.php");
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/dice") {
            $callable = new \Webbprogrammering\Dice\Game();
            $callable->playGame();
            return;
        } else if ($method === "POST" && $path === "/dice") {
            $callable = new \Webbprogrammering\Dice\Game();
            if (!empty($_POST['computer_play']))
                $callable->computerGame();
            else $callable->playGame();
                return;
        } else if ($method === "GET" && $path === "/form/view") {
            unset($_SESSION['total_points']);
            unset($_SESSION['computer_points']);
            if (!isset($_SESSION['show_buttons']) || $_SESSION['show_buttons'] === false) {
                $_SESSION['show_buttons'] = true;
            }
            $data = [
                "header" => "Game 21",
                "message" => "How many dice you want to roll? ",
                "action" => url("/form/process"),
                "output" => $_SESSION["output"] ?? null,
                "total_points" => $_SESSION['total_points'] ?? 0
            ];
            $body = renderView("layout/form.php", $data);
            sendResponse($body);
            return;
        } else if ($method === "POST" && $path === "/form/process") {
            if (in_array($_POST["content"], [1,2])) {
                $_SESSION["output"] = (int) $_POST["content"];
                redirectTo(url("/dice"));
                return;
            }
            // Not 1 or 2
            $data = [
                "header" => "Game 21",
                "message" => "Please enter either 1 or 2 ",
                "action" => url("/form/process"),
                "output" => $_SESSION["output"] ?? null,
            ];
            $body = renderView("layout/form.php", $data);
            sendResponse($body);
            return;
        }
        $data = [
            "header" => "404",
            "message" => "The page you are requesting is not here. You may also checkout the HTTP response code, it should be 404.",
        ];
        $body = renderView("layout/page.php", $data);
        sendResponse($body, 404);
    }
}
