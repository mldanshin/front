<?php 

namespace Danshin\Front\Helpers;

use Illuminate\Support\Arr;

final class Config
{
    /**
     * @var string[]|string $app
     */
    private static array $app;

    /**
     * @var string[]|string $mail
     */
    private static array $mail;
    
    /**
     * @return string[]|string
     */
    public static function app(string $item)
    {
        if (empty(self::$app)) { 
            self::$app  = require __DIR__.'/../../config/app.php';
        }

        return Arr::get(self::$app, $item);
    }
}
