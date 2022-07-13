<?php

declare(strict_types=1);

namespace BedWars\arena;

class MapReset
{
    function copyDir($from, $to): void
    {
        $dir = opendir($from);

        @mkdir($to);

        while ($file = readdir($dir)) {
            if (($file != ".") and ($file != "..")) {
                if (is_dir($from . "/" . $file)) {
                    $this->copyDir($from . "/" . $file, $to . "/" . $file);
                } else {
                    copy($from . "/" . $file, $to . "/" . $file);
                }
            }
        }
        closedir($dir);
    }

    function deleteDir($dir): bool
    {
        $files = array_diff(scandir($dir), array(".", ".."));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? $this->deleteDir("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }
}