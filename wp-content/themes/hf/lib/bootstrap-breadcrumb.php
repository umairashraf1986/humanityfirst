<?php

/**
 * Retrieve category parents.
 *
 * @param int $id Category ID.
 * @param array $visited Optional. Already linked to categories to prevent duplicates.
 * @return string|WP_Error A list of category parents on success, WP_Error on failure.
 */
function custom_get_category_parents( $id, $visited = array() ) {
  $chain = '';
  $parent = get_term( $id, 'category' );
  
  if ( is_wp_error( $parent ) )
    return $parent;
  
  $name = $parent->name;
  
  if ( $parent->parent && ( $parent->parent != $parent->term_id ) && !in_array( $parent->parent, $visited ) ) {
    $visited[] = $parent->parent;
    $chain .= custom_get_category_parents( $parent->parent, $visited );
  }
  
  $chain .= '<li class="breadcrumb-item"><a href="' . esc_url( get_category_link( $parent->term_id ) ) . '">' . $name. '</a>' . '</li>';
  
  return $chain;
}


function bootstrap_breadcrumb() {
  global $post;
  
  $html = '<ol class="breadcrumb row d-flex justify-content-center">';
  
  if ( (is_front_page()) || (is_home()) ) {
    $html .= '<li class="breadcrumb-item active">Home</li>';
  }
  
  else {
    $html .= '<li class="breadcrumb-item"><a href="'.esc_url(home_url('/')).'">Home</a></li>';
    
    if ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $categories = get_the_category($parent->ID);
      
      if ( $categories[0] ) {
        $html .= custom_get_category_parents($categories[0]);
      }

      if(strtolower($parent->post_title) == "about us") {
        $html .= '<li class="breadcrumb-item"><a class="forAboutSlide" href="' . esc_url( get_permalink( $parent ) ) . '">' . $parent->post_title . '</a></li>';
      } elseif(strtolower($parent->post_title) == "our work") {
        $html .= '<li class="breadcrumb-item"><a class="forWorkSlide" href="' . esc_url( get_permalink( $parent ) ) . '">' . $parent->post_title . '</a></li>';
      } elseif(strtolower($parent->post_title) == "our impact") {
        $html .= '<li class="breadcrumb-item"><a class="forImpactSlide" href="' . esc_url( get_permalink( $parent ) ) . '">' . $parent->post_title . '</a></li>';
      } elseif(strtolower($parent->post_title) == "current happenings") {
        $html .= '<li class="breadcrumb-item"><a class="forHappeningSlide" href="' . esc_url( get_permalink( $parent ) ) . '">' . $parent->post_title . '</a></li>';
      } elseif(strtolower($parent->post_title) == "multimedia") {
        $html .= '<li class="breadcrumb-item"><a class="forResourcesSlide" href="' . esc_url( get_permalink( $parent ) ) . '">' . $parent->post_title . '</a></li>';
      } elseif(strtolower($parent->post_title) == "get involved") {
        $html .= '<li class="breadcrumb-item"><a class="forInvolvedSlide" href="' . esc_url( get_permalink( $parent ) ) . '">' . $parent->post_title . '</a></li>';
      } else {
        $html .= '<li class="breadcrumb-item"><a href="' . esc_url( get_permalink( $parent ) ) . '">' . $parent->post_title . '</a></li>';
      }
      
      $html .= '<li class="breadcrumb-item active">' . get_the_title() . '</li>';
    }
    
    elseif ( is_category() ) {

      $category = get_category( get_query_var( 'cat' ) );
      
      if ( $category->parent != 0 ) {
        $html .= custom_get_category_parents( $category->parent );
      }
      
      $html .= '<li class="breadcrumb-item active">' . single_cat_title( '', false ) . '</li>';
    // }elseif ( is_product_category() ) {

    //   $shop_page_id = wc_get_page_id( 'shop' );
    //   $shop_page_url = $shop_page_id ? get_permalink( $shop_page_id ) : '';
    //   $shop_page_title = get_the_title($shop_page_id);

    //   $html .= '<li class="breadcrumb-item"><a href="' . $shop_page_url . '">'.$shop_page_title.'</a></li>';

    //   $html .= '<li class="breadcrumb-item active">' . single_cat_title( '', false ) . '</li>';

    }
    
    elseif ( is_page() && !is_front_page() ) {
      $parent_id = $post->post_parent;
      $parent_pages = array();
      
      while ( $parent_id ) {
        $page = get_page($parent_id);
        $parent_pages[] = $page;
        $parent_id = $page->post_parent;
      }
      
      $parent_pages = array_reverse( $parent_pages );
      
      if ( !empty( $parent_pages ) ) {
        foreach ( $parent_pages as $parent ) {

          if(strtolower(get_the_title( $parent->ID )) == "about us") {
            $html .= '<li class="breadcrumb-item"><a class="forAboutSlide" href="' . esc_url( get_permalink( $parent->ID ) ) . '">' . get_the_title( $parent->ID ) . '</a></li>';
          } elseif(strtolower(get_the_title( $parent->ID )) == "our work") {
            $html .= '<li class="breadcrumb-item"><a class="forWorkSlide" href="' . esc_url( get_permalink( $parent->ID ) ) . '">' . get_the_title( $parent->ID ) . '</a></li>';
          } elseif(strtolower(get_the_title( $parent->ID )) == "our impact") {
            $html .= '<li class="breadcrumb-item"><a class="forImpactSlide" href="' . esc_url( get_permalink( $parent->ID ) ) . '">' . get_the_title( $parent->ID ) . '</a></li>';
          } elseif(strtolower(get_the_title( $parent->ID )) == "current happenings") {
            $html .= '<li class="breadcrumb-item"><a class="forHappeningSlide" href="' . esc_url( get_permalink( $parent->ID ) ) . '">' . get_the_title( $parent->ID ) . '</a></li>';
          } elseif(strtolower(get_the_title( $parent->ID )) == "multimedia") {
            $html .= '<li class="breadcrumb-item"><a class="forResourcesSlide" href="' . esc_url( get_permalink( $parent->ID ) ) . '">' . get_the_title( $parent->ID ) . '</a></li>';
          } elseif(strtolower(get_the_title( $parent->ID )) == "get involved") {
            $html .= '<li class="breadcrumb-item"><a class="forInvolvedSlide" href="' . esc_url( get_permalink( $parent->ID ) ) . '">' . get_the_title( $parent->ID ) . '</a></li>';
          } else {
           $html .= '<li class="breadcrumb-item"><a href="' . esc_url( get_permalink( $parent->ID ) ) . '">' . get_the_title( $parent->ID ) . '</a></li>';
         }
       }
     }
      if(get_the_slug() == "event-booking" || get_the_slug() == 'become-event-sponsor' || get_the_slug() == 'pledge'){
          $html .= '<li class="breadcrumb-item"><a href="'.home_url("events").'">Events</a></li>';
          $html .= '<li class="breadcrumb-item"><a href="'.esc_url( get_permalink( $_GET['event_id'] ) ).'">'.get_the_title($_GET['event_id']).'</a></li>';
      }
     $html .= '<li class="breadcrumb-item active">' . get_the_title() . '</li>';
   }

   elseif ( is_singular( 'post' ) ) {
    $categories = get_the_category();
    $slug= isset($categories[0]->slug) ? $categories[0]->slug : '';
    $postDetails='';
    $parentPageMaping = array(
      'stories' => 'about-us/stories',
      'news' => 'current-happenings/news',
      'blog' => 'current-happenings/blog'
    );

    $parentPagePath=isset($parentPageMaping[$slug]) ? $parentPageMaping[$slug] : '';
    if(!empty($parentPagePath)){
     $postDetails = get_page_by_path($parentPagePath);
   }

   $parent_id = isset($postDetails->ID) ? $postDetails->ID : '';

   if(!empty($parent_id)){
    $parent_pages = array();

    while ( $parent_id ) {
      $page = get_page($parent_id);
      $parent_pages[] = $page;
      $parent_id = $page->post_parent;
    }

    $parent_pages = array_reverse( $parent_pages );

    if ( !empty( $parent_pages ) ) {
      foreach ( $parent_pages as $parent ) {

        if(strtolower(get_the_title( $parent->ID )) == "about us") {
          $html .= '<li class="breadcrumb-item"><a class="forAboutSlide" href="' . esc_url( get_permalink( $parent->ID ) ) . '">' . get_the_title( $parent->ID ) . '</a></li>';
        } elseif(strtolower(get_the_title( $parent->ID )) == "our work") {
          $html .= '<li class="breadcrumb-item"><a class="forWorkSlide" href="' . esc_url( get_permalink( $parent->ID ) ) . '">' . get_the_title( $parent->ID ) . '</a></li>';
        } elseif(strtolower(get_the_title( $parent->ID )) == "our impact") {
          $html .= '<li class="breadcrumb-item"><a class="forImpactSlide" href="' . esc_url( get_permalink( $parent->ID ) ) . '">' . get_the_title( $parent->ID ) . '</a></li>';
        } elseif(strtolower(get_the_title( $parent->ID )) == "current happenings") {
          $html .= '<li class="breadcrumb-item"><a class="forHappeningSlide" href="' . esc_url( get_permalink( $parent->ID ) ) . '">' . get_the_title( $parent->ID ) . '</a></li>';
        } elseif(strtolower(get_the_title( $parent->ID )) == "multimedia") {
          $html .= '<li class="breadcrumb-item"><a class="forResourcesSlide" href="' . esc_url( get_permalink( $parent->ID ) ) . '">' . get_the_title( $parent->ID ) . '</a></li>';
        } elseif(strtolower(get_the_title( $parent->ID )) == "get involved") {
          $html .= '<li class="breadcrumb-item"><a class="forInvolvedSlide" href="' . esc_url( get_permalink( $parent->ID ) ) . '">' . get_the_title( $parent->ID ) . '</a></li>';
        } else {
         $html .= '<li class="breadcrumb-item"><a href="' . esc_url( get_permalink( $parent->ID ) ) . '">' . get_the_title( $parent->ID ) . '</a></li>';
       }
     }
   }

 } else if ( $categories[0] ) {
  $html .= custom_get_category_parents($categories[0]);
}

$html .= '<li class="breadcrumb-item active">' . mb_strimwidth(get_the_title(), 0, 40, '...') . '</li>';
}

elseif (is_singular( array( 'hf_programs','hf_members','hf_sponsors','hf_partners','hf_glbl_sites','hf_countries','hf_projects','hf_events','hf_campaigns','hf_alerts','product') )){


  $postType=get_post_type();

  $parentPageMaping = array(
    'hf_members' => 'about-us/team',
    'hf_sponsors' => 'about-us/sponsors',
    'hf_partners' => 'about-us/partners',
    'hf_glbl_sites' => 'about-us/global-sites',
    'hf_programs' => 'our-work/programs',
    'product' => 'donate',
    'hf_countries' => 'our-work/geographic-regions',
    'hf_projects' => 'our-work/projects',
    'hf_events' => 'current-happenings/events',
    'hf_campaigns' => 'current-happenings/campaigns',
    'hf_alerts' => 'current-happenings/alerts',
  );


  $parentPagePath=$parentPageMaping[$postType];

  $postDetails = get_page_by_path($parentPagePath);

  $parent_id = isset($postDetails->ID) ? $postDetails->ID : '';

  if(!empty($parent_id)){

    $parent_pages = array();

    while ( $parent_id ) {
      $page = get_page($parent_id);
      $parent_pages[] = $page;
      $parent_id = $page->post_parent;
    }

    $parent_pages = array_reverse( $parent_pages );

    if ( !empty( $parent_pages ) ) {
      foreach ( $parent_pages as $parent ) {

        if(strtolower(get_the_title( $parent->ID )) == "about us") {
          $html .= '<li class="breadcrumb-item"><a class="forAboutSlide" href="' . esc_url( get_permalink( $parent->ID ) ) . '">' . get_the_title( $parent->ID ) . '</a></li>';
        } elseif(strtolower(get_the_title( $parent->ID )) == "our work") {
          $html .= '<li class="breadcrumb-item"><a class="forWorkSlide" href="' . esc_url( get_permalink( $parent->ID ) ) . '">' . get_the_title( $parent->ID ) . '</a></li>';
        } elseif(strtolower(get_the_title( $parent->ID )) == "our impact") {
          $html .= '<li class="breadcrumb-item"><a class="forImpactSlide" href="' . esc_url( get_permalink( $parent->ID ) ) . '">' . get_the_title( $parent->ID ) . '</a></li>';
        } elseif(strtolower(get_the_title( $parent->ID )) == "current happenings") {
          $html .= '<li class="breadcrumb-item"><a class="forHappeningSlide" href="' . esc_url( get_permalink( $parent->ID ) ) . '">' . get_the_title( $parent->ID ) . '</a></li>';
        } elseif(strtolower(get_the_title( $parent->ID )) == "multimedia") {
          $html .= '<li class="breadcrumb-item"><a class="forResourcesSlide" href="' . esc_url( get_permalink( $parent->ID ) ) . '">' . get_the_title( $parent->ID ) . '</a></li>';
        } elseif(strtolower(get_the_title( $parent->ID )) == "get involved") {
          $html .= '<li class="breadcrumb-item"><a class="forInvolvedSlide" href="' . esc_url( get_permalink( $parent->ID ) ) . '">' . get_the_title( $parent->ID ) . '</a></li>';
        } else {
         $html .= '<li class="breadcrumb-item"><a href="' . esc_url( get_permalink( $parent->ID ) ) . '">' . get_the_title( $parent->ID ) . '</a></li>';
       }
     }
   }

 }


 $html .= '<li class="breadcrumb-item active">' . get_the_title() . '</li>';
}

elseif ( is_tag() ) {
  $html .= '<li class="breadcrumb-item active">' . single_tag_title( '', false ) . '</li>';
}

elseif ( is_day() ) {
  $html .= '<li class="breadcrumb-item"><a href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '">' . get_the_time( 'Y' ) . '</a></li>';
  $html .= '<li class="breadcrumb-item"><a href="' . esc_url( get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) ) . '">' . get_the_time( 'm' ) . '</a></li>';
  $html .= '<li class="breadcrumb-item active">' . get_the_time('d') . '</li>';
}

elseif ( is_month() ) {
  $html .= '<li class="breadcrumb-item"><a href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '">' . get_the_time( 'Y' ) . '</a></li>';
  $html .= '<li class="breadcrumb-item active">' . get_the_time( 'F' ) . '</li>';
}

elseif ( is_year() ) {
  $html .= '<li class="breadcrumb-item active">' . get_the_time( 'Y' ) . '</li>';
}

elseif ( is_author() ) {
  $html .= '<li class="breadcrumb-item active">' . get_the_author() . '</li>';
}

elseif ( is_search() ) {
  $html .= '<li class="breadcrumb-item active">Search</li>';
}

elseif ( is_404() ) {
  $html .= '<li class="breadcrumb-item active">404</li>';
}

}

$html .= '</ol>';

echo $html;
}
