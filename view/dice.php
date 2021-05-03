<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);

$header = $header ?? null;
$message = $message ?? null;

?><h1><?= $header ?></h1>

<p><?= $message ?></p>

<meta charset="utf-8">
<link rel="stylesheet" href="style.css">

<p class="dice-utf8">
<?php foreach ($hand as $value) : ?>
    <i class="<?= $value ?>"></i>

<?php endforeach; ?>
</p>

<p>Your Points: <?= isset($_SESSION['total_points']) ? $_SESSION['total_points'] : 0 ?></p>

<?php if (isset($_SESSION['computer_points'])) : ?>
    <p>Computer Points: <?= $_SESSION['computer_points'] ?></p>
<?php endif; ?>

<?php if ($_SESSION['show_buttons'] === true) : ?>
<form method="POST" action="<?= $action; ?>">
    <input type="submit" name="roll_again" value="Roll Again" />
    <input type="submit" name="computer_play" value="Stop & Computer Play" />
</form>

<?php endif; ?>