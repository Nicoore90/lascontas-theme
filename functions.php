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

	echo '<style>
    .carousel {
    position: relative;
    padding: 35px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
   @media only screen and (max-width: 768px){
    .carousel{
        flex-direction: column;
    }
  }
  .carousel-item {
    display: none;
    width: 100%;
    background-color: #FFFFFF;
    box-shadow: 0px 21.519418716430664px 32.27912521362305px 0px #00000038;
    border-radius: 0 0 7px 7px;
    min-height: 500px;
  }
  
  @media only screen and (max-width: 768px){
      .carousel-item {
          min-height: 350px;
      }
  }

  .carousel-item img {
    width: 100%;
    height: auto;
    border-radius: 7px 7px 0px 0px;
  }

  .carousel-caption {
    background-color: #FFFFFF;
    padding: 10px;
    color: #fff;
    border-radius: 0 0 7px 7px;
    padding: 25px;
  }
  
  .carousel-caption h3 {
      color: #094E86;
      margin-bottom: 10px;
	  font-size: 20px;
  }
  
  .carousel-caption p {
      color: #292D32BD;
      margin: 0px;
	  font-size: 12px;
  }

  .carousel-control {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: rgba(0, 0, 0, 0.5);
    color: #fff;
    border: none;
    border-radius: 7px;
    padding: 15px;
    font-size: 20px;
    cursor: pointer;
  }

  .carousel-control.prev {
    left: -20px;
  }

  .carousel-control.next {
    right: -20px;
  }

  .no-principal {
    transform: scale(0.7);
  }
  .aditional {
    background-color: #094E86;
    color: #FFFFFF;
    padding: 10px 30px;
    border-radius: 7px;
    margin: 0px 20px;
    position: relative;
    bottom: -50px;
  }
  .aditional p {
  	margin: 0px;
  }
  </style>';
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
	
	echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
    const carouselItems = document.querySelectorAll('.carousel-item');
    let currentIndex = 0;
    let timeInterval = 5000;

    function showSlide(index) {
        indexNext = index + 1
        indexBefore = index == 0 ? 2 : index - 1
        if(indexNext > carouselItems.length - 1){
            indexNext = 3
        }
        if (index < 0) {
            index = carouselItems.length - 1;
        } else if (index >= carouselItems.length) {
            index = 0;
        }
        if(indexBefore == carouselItems.length - 2 && index == carouselItems.length - 1 && indexNext == carouselItems.length - 3){
            indexBefore = 2
            index = 0
            indexNext = 1
        }
        carouselItems.forEach(item => item.style.display = 'none');
        if(screen.width > 768){
            carouselItems[indexBefore].style.display = 'block';
            carouselItems[indexBefore].className += ' no-principal'
            carouselItems[indexNext].style.display = 'block';
            carouselItems[indexNext].className += ' no-principal'
        }
        carouselItems[index].style.display = 'block';
        carouselItems[index].classList.remove('no-principal')
        currentIndex = index;
    }

    function showNextSlide() {
      showSlide(currentIndex + 1);
    }

    showSlide(currentIndex);
    setInterval(showNextSlide, timeInterval);

    document.querySelector('.carousel-control.prev').addEventListener('click', function() {
      currentIndex == 0 ? 0 : showSlide(currentIndex - 1);
    });

    document.querySelector('.carousel-control.next').addEventListener('click', function() {
      showNextSlide();
    });
  });
  </script>";
}

add_shortcode('test_group', 'test_group');