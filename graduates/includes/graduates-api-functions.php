<?php

function graduates_list_users_callback($limit) {
    $token = get_option('graduates_api_key');
    if (!$token) {
        return;
    }
    if ($token !== $_GET['token']) {
        return;
    }
    $graduates_list = get_posts([
        'post_type' => 'graduates',
        'posts_per_page' => $limit['id']
    ]);
   
    return $graduates_list;
}
add_action( 'rest_api_init', function () {
  register_rest_route( 'graduates/v1', '/list/(?P<limit>\d+)', array(
    'methods' => 'GET',
    'callback' => 'graduates_list_users_callback',
  ) );
} );
function graduates_admin_notice() {
    $screen = get_current_screen();
    // Only render this notice in the post editor.
    
    if ( ! $screen || ('edit' !== $screen->base  || 'graduates' !== get_post_type() && !$_GET['post_type'] == 'graduates')) {
        return;
    }
    
    if (!get_option('graduates_api_key')) {
        $key = sha1(time());
        add_option('graduates_api_key', $key);
    }
    // Render the notice's HTML.
    wp_admin_notice(
        sprintf( __( 'Dostęp do listy absolwentów za pomocą REST API jest dostępny przy użyciu tokenu: <b>'.get_option('graduates_api_key').'</b>' ), get_preview_post_link() ),
        array(
            'type'        => 'success',
            'dismissible' => false,
        )
    );
};
add_action( 'admin_notices', 'graduates_admin_notice' );