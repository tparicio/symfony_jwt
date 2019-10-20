<?php


namespace App\Util\Files;

/**
 * Class Finder
 * @package App\Util\Files
 */
class Finder
{
    public const FOLDER = '../var/data';

    /**
     * @return array
     */
    public function listFiles():array
    {
        $scan = scandir(self::FOLDER);
        $files = [];
        foreach ($scan as $item) {
            if (is_file(self::FOLDER . '/'.$item)) {
                $files[] = $item;
            }
        }
        return $files;
    }
}