<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
declare(strict_types=1);

use Spiral\Debug\Dumper;

mb_internal_encoding('UTF-8');
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'stderr');

//Composer
require __DIR__ . '/vendor/autoload.php';

function dumprr($value)
{
    dump($value, Dumper::ERROR_LOG);
}

//Initiating shared container, bindings, directories and etc
$app = \App\App::init(['root' => __DIR__]);

if ($app != null) {
    $app->serve();
}