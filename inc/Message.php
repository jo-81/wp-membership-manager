<?php

namespace Inc;

final class Message
{
    public static function add(string $option, string $message, string $type = "success"): void
    {
        add_option($option, ['message' => $message, 'type' => $type]);
    }

    public static function get(string $option, ?string $field = null): mixed
    {
        $message = get_option($option, "");
        delete_option($option);

        if (empty($message) || is_null($field)) {
            return $message;
        }

        if (isset($message[$field])) {
            return $message[$field];
        }

        return $message;
    }
}