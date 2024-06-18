<?php

namespace Wp_Membership_Manager\Controller;

use Inc\Admin\Menu_Sub_Page;
use Wp_Membership_Manager\Interface\Controller_Interface;
use Wp_Membership_Manager\Model\WP_MM_Role_Model;

final class Role_Controller implements Controller_Interface
{
    public function register(): void
    {
        $this->wp_mm_add_sub_page();

        if (is_admin()) {
            add_action("admin_post_wp_mm_add_role", [$this, 'wp_mm_add_role']);
            add_action("admin_post_wp_mm_remove_role", [$this, 'wp_mm_remove_role']);
        }
    }

    private function wp_mm_add_sub_page(): void
    {
        $menuPage = new Menu_Sub_Page();
        $menuPage
            ->add([
                'parent_slug' => "wp_membership_manager",
                'page_title' => __("Roles", "wp-membership-manager"),
                'menu_title' => __("Roles", "wp-membership-manager"),
                'menu_slug' => 'wp_mm_roles',
                'capability' => 'manage_options',
                'position' => 10,
                'callback' => function () {
                    require_once WP_MM_TEMPLATES . "/admin/role/role.php";
                },
            ])
        ;

        $menuPage->register();
    }

    public function wp_mm_add_role(): void
    {
        /** wp_nonce */
        if (
            ! isset($_POST['wp_mm_nonce_add_role']) 
            || ! wp_verify_nonce($_POST['wp_mm_nonce_add_role'], 'wp_mm_action_add_role')
        ) 
        {
            \Inc\Message::add('wp_mm_error', 'Error with nonce', 'error');
            wp_safe_redirect(add_query_arg(['page' => 'wp_mm_roles' ], admin_url("admin.php")));
            die;
        }

        /** user not capability : manage_options */
        if (! current_user_can('manage_options')) :
            wp_safe_redirect(add_query_arg(['page' => 'wp_membership_manager' ], admin_url("admin.php")));
            die;
        endif;

        $datas = map_deep($_POST, 'sanitize_text_field');
        if (! isset($datas['wp_mm_role'])) :
            wp_safe_redirect(add_query_arg(['page' => 'wp_membership_manager' ], admin_url("admin.php")));
            die;
        endif;

        if (empty($datas['wp_mm_role'])) :
            \Inc\Message::add('wp_mm_error_role', 'The field is empty', 'error');
            wp_safe_redirect(add_query_arg(['page' => 'wp_mm_roles' ], admin_url("admin.php")));
            die;
        endif;

        $role_name = "wp_mm_role_" . $datas['wp_mm_role'];

        /** if role name aleady exist */
        if (get_role($role_name) instanceof \WP_Role) {
            \Inc\Message::add('wp_mm_error_role', 'The role name already exist', 'error');
            \Inc\Message::add('wp_mm_value_role', $datas['wp_mm_role']);

            wp_safe_redirect(add_query_arg(['page' => 'wp_mm_roles' ], admin_url("admin.php")));
            die;
        }

        $role = add_role($role_name, $datas['wp_mm_role'], []);
        if ($role instanceof \WP_Role) {
            \Inc\Message::add('wp_mm_success', 'The role has been added');

            wp_safe_redirect(add_query_arg(['page' => 'wp_membership_manager' ], admin_url("admin.php")));
            die;
        }

        \Inc\Message::add('wp_mm_message_role', 'The role has not been added', 'error');
        wp_safe_redirect(add_query_arg(['page' => 'wp_membership_manager' ], admin_url("admin.php")));
        die;
    }

    public function wp_mm_remove_role(): void
    {
        $datas = map_deep($_POST, 'sanitize_text_field');
        $role_model = new WP_MM_Role_Model;

        /** wp_nonce */
        if (
            ! isset($datas['wp_mm_nonce_remove_role']) 
            || ! wp_verify_nonce($datas['wp_mm_nonce_remove_role'], 'wp_mm_action_remove_role')
        ) 
        {
            \Inc\Message::add('wp_mm_message_role', 'Error with nonce', 'error');
            wp_safe_redirect(add_query_arg(['page' => 'wp_membership_manager' ], admin_url("admin.php")));
            die;
        }

        /** user not capability : manage_options */
        if (! current_user_can('manage_options')) :
            wp_safe_redirect(add_query_arg(['page' => 'wp_membership_manager' ], admin_url("admin.php")));
            die;
        endif;

        if (! isset($datas['wp_mm_role'])) :
            wp_safe_redirect(add_query_arg(['page' => 'wp_membership_manager' ], admin_url("admin.php")));
            die;
        endif;

        if (! $role_model->exist($datas['wp_mm_role'])) {
            \Inc\Message::add('wp_mm_message_role', 'Role not exist', 'error');
            wp_safe_redirect(add_query_arg(['page' => 'wp_membership_manager' ], admin_url("admin.php")));
            die;
        }

        $success = $role_model->remove($datas['wp_mm_role']);
        if ($success) {
            \Inc\Message::add('wp_mm_message_role', 'Role is remove', 'success');
            wp_safe_redirect(add_query_arg(['page' => 'wp_membership_manager' ], admin_url("admin.php")));
            die;
        }

        \Inc\Message::add('wp_mm_message_role', 'Role not exists', 'error');
        wp_safe_redirect(add_query_arg(['page' => 'wp_membership_manager' ], admin_url("admin.php")));
        die;
    }
}
