<?php

namespace Inc;

abstract class Abstract_Element
{
    protected function register_action(string $hook_name, $callback, int $priority = 10, int $accepted_args = 1)
    {   
        add_action($hook_name, $callback, $priority, $accepted_args);
    }
}