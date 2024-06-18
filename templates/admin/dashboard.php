<?php 
    $success = Inc\Message::get('wp_mm_success');
?>

<section>
    <header>
        <h1><?php echo esc_html(get_admin_page_title()) ?></h1>
    </header>

    <?php if ($success) : ?>
        <p><?php esc_html_e($success['message'], "wp_membership_manager"); ?></p>
    <?php endif; ?>

    <section>
        <h2><?php esc_html_e("List of the roles", "wp-membership-manager") ?></h2>
        <p>
            <a href="<?php echo esc_url(add_query_arg(
                ['page' => 'wp_mm_roles']
                , admin_url('admin.php'))); ?>"><?php esc_html_e("add", "wp-membership-manager"); ?></a>
        </p>
    </section>
</section>