<?php

namespace Inc\Admin;

use Inc\Abstract_Element;

final class Menu_Sub_Page extends Abstract_Element
{
    private array $menus = [];

    /**
     * register
     *
     * @param  int $priority = 10
     * @param  int $accepted_args = 1
     * @return void
     */
    public function register(int $priority = 10, int $accepted_args = 1): void
    {
        $this->register_action('admin_menu', [$this, "build"], $priority, $accepted_args);
    }

    /**
     * add
     *
     * @param  array $menus
     * @return self
     */
    public function add(array $menus): self
    {
        $this->menus[] = $menus;

        return $this;
    }

    /**
     * build
     *
     * @return void
     */
    public function build(): void
    {
        foreach($this->menus as $menu) {
            add_submenu_page(
                $menu['parent_slug'],
                $menu['page_title'],
                $menu['menu_title'],
                $menu['capability'],
                $menu['menu_slug'],
                $menu['callback'] ?? '',
                $menu['position'] ?? null,
            );
        }
    }
}
