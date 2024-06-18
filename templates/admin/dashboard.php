<?php

    use Wp_Membership_Manager\Model\WP_MM_Role_Model;

    $message = Inc\Message::get('wp_mm_message_role');
    $roles = (new WP_MM_Role_Model)->get_roles();
?>

<section>
    <header>
        <h1><?php echo esc_html(get_admin_page_title()) ?></h1>
    </header>

    <?php if ($message) : ?>
        <p><?php esc_html_e($message['message'], "wp_membership_manager"); ?></p>
    <?php endif; ?>

    <section>
        <h2><?php esc_html_e("List of the roles", "wp-membership-manager") ?></h2>
        <p>
            <a href="<?php echo esc_url(add_query_arg(
                ['page' => 'wp_mm_roles']
                , admin_url('admin.php'))); ?>"><?php esc_html_e("add", "wp-membership-manager"); ?></a>
        </p>

        <div>

            <?php if (empty($roles)) : ?>
                <p><?php esc_html_e("No roles registered", "wp-membership-manager") ?></p>
            <?php endif; ?>

            <?php foreach(array_reverse($roles) as $role) : ?>

                <p><?php echo ucfirst($role->display_name); ?></p>
                <p><a href="<?php echo esc_url(add_query_arg([
                    'page' => 'wp_mm_roles',
                    'role_name' => $role,
                ], admin_url("admin.php"))) ?>">Consulter</a></p>

                <?php add_thickbox(); ?>
                <div id="ww-mm-remove-role" style="display:none;">
                    <form method="POST" action="<?php echo esc_url(admin_url("admin-post.php")); ?>">

                        <input type="hidden" name="action" value="wp_mm_remove_role">
                        <input type="hidden" name="wp_mm_role" value="<?php echo esc_attr($role->name); ?>">

                        <?php wp_nonce_field("wp_mm_action_remove_role", "wp_mm_nonce_remove_role"); ?>

                        <p><?php esc_html_e("Do you want delete this role ?", "wp-membership-manager") ?></p>
                        <p>
                            <button tyoe="submit"><?php esc_html_e("Remove", "wp-membership-manager"); ?></button>
                        </p>
                    </form>
                </div>

                <a href="#TB_inline?&width=600&height=120&inlineId=ww-mm-remove-role" class="thickbox"><?php esc_html_e("Remove", "wp-membership-manager"); ?></a>

            <?php endforeach; ?>
        </div>
    </section>
</section>