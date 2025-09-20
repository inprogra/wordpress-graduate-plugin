<?php
//Hook for creating new post type
add_action('init' , 'graduate_create_custom_post_type');
function graduate_create_custom_post_type() {
    $labels = [
        'name'               => __( 'Nasi absolwenci' ),
        'singular_name'      => __( 'Nasz absolwent' ),
        'add_new'            => __( 'Dodaj nowego absolwenta' ),
        'add_new_item'       => __( 'Dodaj nowego absolwenta' ),
        'edit_item'          => __( 'Edytuj absolwenta' ),
        'new_item'           => __( 'Nowy absolwent' ),
        'all_items'          => __( 'Wszyscy absolwenci' ),
        'view_item'          => __( 'Podgląd absolwenta' ),
        'search_items'       => __( 'Szukaj absolwenta' ),
        'featured_image'     => 'Zdjęcie absolwenta',
        'set_featured_image' => 'Dodaj zdjęcie'
    ];
    

    $args = array(
        'labels'            => $labels,
        'description'       => 'Nasi absolwenci',
        'public'            => true,
        'menu_position'     => 5,
        'supports'          => array( 'editor', 'thumbnail'),
        'has_archive'       => false,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'query_var'         => false,
        'exclude_from_search' => true,
        'publicly_queryable' => false,
        'show_in_rest'         => false,

    );
    
    register_post_type('graduates',$args);
}
//add_meta_boxes callback that displays inside content;
function graduate_meta_box_callback($post) {
    wp_nonce_field( basename( __FILE__ ), 'graduate_meta_box_nonce' );
    $response = '<div style="display:flex;">';
    $response .= '<div style="padding:10px;"><p><label for="firstname">'.__('Imię*', 'graduate').'</label></p>';
    $response .= '<p><input type="text" name="firstname" value="'.get_post_meta($post->ID, 'graduate_firstname', true).'"  required/></p></div>';
    $response .= '<div style="padding:10px;"><p><label for="lastname">'.__('Nazwisko*', 'graduate').'</label></p>';
    $response .= '<p><input type="text" name="lastname" value="'.get_post_meta($post->ID, 'graduate_lastname', true).'" required/> </p></div>';
    $response .= '</div>';
    echo $response;
}
//Adds new meta box in graduates post edit
add_action('add_meta_boxes','graduate_meta_box');
function graduate_meta_box() {
        add_meta_box(
            'graduate-data',
            __('Dane absolwenta', 'graduates'),
            'graduate_meta_box_callback',
            'graduates'   
        );
}
add_action('save_post_graduates','graduate_save_meta_box_data',10,2);
//Custom data store with validation
function graduate_save_meta_box_data($post_id) {
    $verify_once = $_POST['graduate_meta_box_nonce'];
    if (!isset($verify_once) || !wp_verify_nonce( $verify_once, basename( __FILE__ ) )) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
   
    $store_name = (isset($_REQUEST['firstname']) ? update_post_meta($post_id, 'graduate_firstname', sanitize_text_field($_POST['firstname'])) : '');
    $store_lastname = (isset($_REQUEST['lastname']) ? update_post_meta($post_id, 'graduate_lastname', sanitize_text_field($_POST['lastname'])) : '');
    
}

