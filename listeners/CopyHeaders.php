<?php

namespace App\Listeners;

use TightenCo\Jigsaw\Jigsaw;

class CopyHeaders
{
    public function handle(Jigsaw $jigsaw)
    {
        file_put_contents($jigsaw->getDestinationPath() . '/_headers', file_get_contents(__DIR__ . '/../source/_headers'));
    }
}
