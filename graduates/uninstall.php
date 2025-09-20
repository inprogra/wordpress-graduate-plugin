<?php 
delete_option( 'graduates_api_key' ); 
$posts= get_posts( array('post_type'=>'graduates','numberposts'=>-1) );
foreach ($posts as $p) {
wp_delete_post( $p->ID, true );
}
?>
