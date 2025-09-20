<?php

/*
    Add filters that will remove not needed columns in list view.
*/
add_filter(
    'manage_posts_columns',
    'graduates_remove_columns'
);
function graduates_remove_columns( $columns ) {
    
    $post_type = get_post_type();
    if ($post_type == 'graduates' && is_array($columns) || (!$post_type && $_GET['post_type'] == 'graduates')) {
        unset($columns['title']);
        unset($columns['date']);
    }
    
    return $columns;
}
/*
    Add new columns to list view.
*/
add_filter( 'manage_posts_columns',  'graduates_add_new_columns',10 );
function graduates_add_new_columns($columns) {
    $post_type = get_post_type();
    
    if ( $post_type == 'graduates' || (!$post_type && $_GET['post_type'] == 'graduates')) {
        
        $new_columns = array(
            'graduate_firstname' => esc_html__( 'Imię', 'graduates' ),
            'graduate_lastname' => esc_html__( 'Nazwisko', 'graduates' ),
            'graduate_description' => esc_html__('Opis','graduates'),
            'graduate_image' => esc_html__( 'Zdjęcie', 'graduates' ),
        );
       
        return array_merge($columns, $new_columns);
    }
   return $columns;
}
/*
    Displays custom data in custom columns
*/
add_action( 'manage_posts_custom_column', 'graduates_custom_columns', 5, 2 );
function graduates_custom_columns( $column_name, $id ) {
   
    $post_type = get_post_type();
    if ($post_type = 'graduates') {
        if ('graduate_firstname' === $column_name) {
            echo get_post_meta(get_the_ID(), 'graduate_firstname',true);
        }
        if ('graduate_lastname' === $column_name) {
            echo get_post_meta(get_the_ID(), 'graduate_lastname',true);
        }
        if ('graduate_description' === $column_name) {
            echo substr(strip_tags(get_the_content()), 0, 50);
        }
        if ( 'graduate_image' === $column_name ) {
            the_post_thumbnail( [50.50] );
        }
   
    }
}
