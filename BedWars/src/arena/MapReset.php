<?php

declare(strict_types=1);

namespace BedWars\arena;

class MapReset
{
    //todo: ASYNC

    function copyDir($src, $dst)
    {
        if (file_exists($dst)) rmdir($dst);
        if (is_dir($src)) {
            mkdir($dst);
            $files = scandir($src);
            foreach ($files as $file)
                if ($file !== "." and $file !== "..") $this->copyDir("$src/$file", "$dst/$file");
        }
    }

    function removeDir($dir)
    {
        if (is_dir($dir)) {
            $files = scandir($dir);
            foreach ($files as $file) {
                if ($file !== "." and $file !== "..") rmdir("$dir/$file");
                rmdir($dir);
            }
        }
    }
}