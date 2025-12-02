<?php

namespace Mreweb\JsoncParser;

use Exception;

class JsoncParser
{
    public static function parseFile(string $filePath, bool $assoc = true)
    {
        if (!file_exists($filePath)) {
            throw new Exception("File not found: $filePath");
        }

        $jsonc = file_get_contents($filePath);
        $result = '';
        $inString = false;
        $inSingleComment = false;
        $inMultiComment = false;
        $len = strlen($jsonc);

        for ($i = 0; $i < $len; $i++) {
            $c = $jsonc[$i];
            $next = $i + 1 < $len ? $jsonc[$i + 1] : '';

            if (!$inSingleComment && !$inMultiComment) {
                if ($c === '"' && ($i == 0 || $jsonc[$i - 1] !== '\\')) {
                    $inString = !$inString;
                }
            }

            if (!$inString && !$inMultiComment && $c === '/' && $next === '/') {
                $inSingleComment = true;
                $i++;
                continue;
            }

            if (!$inString && !$inSingleComment && $c === '/' && $next === '*') {
                $inMultiComment = true;
                $i++;
                continue;
            }

            if ($inSingleComment && ($c === "\n" || $c === "\r")) {
                $inSingleComment = false;
                $result .= $c;
                continue;
            }

            if ($inMultiComment && $c === '*' && $next === '/') {
                $inMultiComment = false;
                $i++;
                continue;
            }

            if (!$inSingleComment && !$inMultiComment) {
                $result .= $c;
            }
        }

        $data = json_decode($result, $assoc);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("JSON parse error: " . json_last_error_msg());
        }

        return $data;
    }
}
