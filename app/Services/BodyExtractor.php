<?php

namespace App\Services;

class BodyExtractor
{
    /**
     * Extract the text from the given JSON string or Array.
     * This is used to get the real text from the EditorJS JSON blob.
     * @param string|array<string, mixed> $body
     * @return string
     */
    public static function extract($body): string
    {
        /** @var array<string, mixed> */
        $body = is_string($body) ? json_decode($body, true) : $body;
        return collect($body["blocks"])
            ->map(fn($block) => self::getTextFromBlock($block))
            ->join("\n");
    }

    /**
     * Get the text from the given block.
     * @param array<string, mixed> $block
     * @return string
     */
    private static function getTextFromBlock(array $block): string
    {
        switch ($block["type"]) {
            case "paragraph":
                return $block["data"]["text"];
            case "header":
                return $block["data"]["text"];
            case "attaches":
                if ($block["data"]["file"]["name"] !== null) {
                    return $block["data"]["file"]["name"];
                } elseif ($block["data"]["file"]["url"] !== null) {
                    return $block["data"]["file"]["url"];
                }
                return "";
            case "delimiter":
                return "";
            case "image":
                if ($block["data"]["caption"] !== null) {
                    return $block["data"]["caption"];
                }
                return $block["data"]["file"]["url"];
            case "list":
                return collect($block["data"]["items"])
                    ->map(fn($item) => $item["content"])
                    ->join("\n");
            case "quote":
                if ($block["data"]["caption"] !== null) {
                    return $block["data"]["text"] . $block["data"]["caption"];
                }
                return $block["data"]["text"];
            case "table":
                return collect($block["data"]["content"])
                    ->map(
                        fn($row) => collect($row)
                            ->map(fn($cell) => $cell["content"])
                            ->join("\t"),
                    )
                    ->join("\n");
            case "code":
                return $block["data"]["code"];
            default:
                return "";
        }
    }
}
