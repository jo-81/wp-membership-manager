<?php 
    $error_field = Inc\Message::get('wp_mm_error_role', 'message'); 
    $error = Inc\Message::get('wp_mm_error'); 
    $value_field = Inc\Message::get('wp_mm_value_role', 'message');
?>

<section>
    <header>
        <h1><?php echo esc_html(get_admin_page_title()) ?></h1>
    </header>

    <?php if ($error) : ?>
        <p><?php esc_html_e($error['message'], "wp_membership_manager"); ?></p>
    <?php endif; ?>

    <form action="<?php echo esc_url(admin_url("admin-post.php")); ?>" method="POST">
        <input type="hidden" name="action" value="wp_mm_add_role">

        <?php wp_nonce_field("wp_mm_action_add_role", "wp_mm_nonce_add_role"); ?>
    
        <div>
            <label for="wp_mm_role"><?php esc_html_e("Name", "wp-membership-manager"); ?></label>
            <input 
                type="text" 
                name="wp_mm_role" 
                id="wp_mm_role" 
                value=<?php esc_attr_e($value_field, 'wp_membership_manager'); ?>
            >

            <?php if (! empty($error_field)) : ?>
                <span><?php esc_html_e($error_field, "wp_membership_manager") ?><span>
            <?php endif; ?>
        </div>

        <div>
            <button type="submit">add</button>
        </div>
    </form>
</section>