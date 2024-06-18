<?php

namespace Wp_Membership_Manager\Controller;

use Inc\Admin\Menu_Page;
use Wp_Membership_Manager\Interface\Controller_Interface;

final class Dashboard_Controller implements Controller_Interface
{
    public function register(): void
    {
        if (is_admin()) {
            $this->add_page();
        }
    }

    private function add_page(): void
    {
        $menuPage = new Menu_Page;
            $menuPage
                ->add([
                    'page_title' => __("WP Membership Manager", "wp-membership-manager"),
                    'menu_title' => __("WP Membership Manager", "wp-membership-manager"),
                    'menu_slug' => 'wp_membership_manager',
                    'capability' => 'manage_options',
                    'position' => 10,
                    'callback' => function() {
                        require_once WP_MM_TEMPLATES . "/admin/dashboard.php";
                    },
                ])
            ;

        $menuPage->register();
    }
}