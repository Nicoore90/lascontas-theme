<?php
/**
 * Recommended way to include parent theme styles.
 * (Please see http://codex.wordpress.org/Child_Themes#How_to_Create_a_Child_Theme)
 *
 */  

 add_action( 'wp_enqueue_scripts', 'astra_child_style' );
  function astra_child_style() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css',array('parent-style'));
}

/**
 * Your code goes below.
 */

function custom_free_product_completion( $order_id ) {
    $order = wc_get_order( $order_id );

    // Verifica si el pedido contiene productos gratuitos
    $has_free_products = false;
    foreach ( $order->get_items() as $item ) {
        if ( $item['line_total'] == 0 ) {
            $has_free_products = true;
        } else {
			$has_free_products = false;
			break;
		}
    }

    // Si el pedido tiene productos gratuitos, cambia su estado a "Completado"
    if ( $has_free_products ) {
        $order->update_status( 'completed' );
    }
}
add_action( 'woocommerce_thankyou', 'custom_free_product_completion' );

// Creamos un shortcode que nos devuelve los cursos de un grupo de Learndash y le damos estilos
function test_group(){
	$grupo_id = 1611;
	// Obtener los cursos del grupo
	$cursos_grupo = learndash_get_all_courses_with_groups( $grupo_id );
	if(!empty($cursos_grupo)){
		echo '<div class="carousel">';
        foreach ( $cursos_grupo as $curso_id ) {
			$curso = get_post( $curso_id );
			echo '<div class="carousel-item">';
			echo '<img src="'. get_the_post_thumbnail_url($curso) .'">';
            echo '<div class="carousel-caption">';
			echo '<h3>'. $curso->post_title .'</h3>';
			echo '<p>'. $curso->post_excerpt .'</p>';
            echo '</div>';
			if($curso->post_title != "Guía Devolución de Percepciones"){
				echo '<div class="aditional">';
				echo '<p>'. $curso->post_content_filtered .'</p>';
				echo '</div>';
			}
			echo '</div>';
        }
        echo '</div>';
		echo '<button class="carousel-control prev">&#9664;</button>';
		echo '<button class="carousel-control next">&#9654;</button>';
	}
	
}

add_shortcode('test_group', 'test_group');

function lascontas_enqueue_assets() {
	wp_enqueue_style( 'carousel-css',  get_theme_file_uri() . '/assets/css/carousel.css');
   	wp_enqueue_script( 'carousel-js', get_theme_file_uri() .  '/assets/js/carousel.js');
	wp_enqueue_script( 'carousel-js', get_theme_file_uri() .  '/assets/js/cursos.js');
}

add_action('wp_enqueue_scripts', 'lascontas_enqueue_assets');