<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);

use function Mos\Functions\url;

$url = url("/results/destroy");
echo <<<EOD
<a href="$url">Reset Results</a>
EOD;



$header = $header ?? null;
$message = $message ?? null;

?><h1><?= $header ?></h1>

<p><?= $message ?></p>
