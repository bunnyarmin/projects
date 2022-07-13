<?php

declare(strict_types=1);

namespace ServerEngine\chatfilter;

class ChatFilter
{
    function filterBadWords(string $message, array $bannedWords): bool
    {
        foreach ($bannedWords as $bannedWord) {
            if (str_contains($message, $bannedWord)) {
                return true;
            }
        }
        return false;
    }
}