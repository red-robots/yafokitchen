<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package ACStarter
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function acstarter_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

    if ( is_front_page() || is_home() ) {
        $classes[] = 'homepage';
    } else {
        $classes[] = 'subpage';
    }

	$browsers = ['is_iphone', 'is_chrome', 'is_safari', 'is_NS4', 'is_opera', 'is_macIE', 'is_winIE', 'is_gecko', 'is_lynx', 'is_IE', 'is_edge'];
    $classes[] = join(' ', array_filter($browsers, function ($browser) {
        return $GLOBALS[$browser];
    }));

	return $classes;
}
add_filter( 'body_class', 'acstarter_body_classes' );

if( function_exists('acf_add_options_page') ) {
    acf_add_options_page();
}


function add_query_vars_filter( $vars ) {
  $vars[] = "pg";
  return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );

/* GENERATE SITEMAP */
function generate_sitemap($menuName=null,$sortbyMenu=null) {
  global $wpdb;
  $pages = $wpdb->get_results( "SELECT ID,post_title,post_parent,post_type FROM {$wpdb->prefix}posts WHERE post_type = 'page' AND post_status='publish' ORDER BY post_title ASC", OBJECT );
  $links = array();
  $menus = ($menuName) ? wp_get_nav_menu_items($menuName) : '';
  $site_url = get_site_url();
  $menu_pages = array();

  if( $menus ) {
    foreach ($menus as $m) {
      $m_id = $m->ID;
      $m_type = $m->type;
      $pagelink = $m->url;
      $menu_parent_id = $m->menu_item_parent;
      $object_id = $m->object_id;
      $parts = explode("#",$pagelink);

      if( $m_type =='custom' ) {
        $custom_url_parse = parse_url($pagelink);
        $site_url_parse = parse_url($site_url);
        if( isset($custom_url_parse['host']) && $custom_url_parse['host'] ) {
          $custom_host = $custom_url_parse['host'];
          $site_host = $site_url_parse['host'];
          if($custom_host!=$site_host) {
            $m->url = $pagelink;
            $m->external_link = $pagelink;
          }
        } else {

          $hash = ($parts) ? array_filter($parts) : false;

          if( $hash ) {
            if (strpos($pagelink, $site_url) !== false) {
              $pagelink = $pagelink;
            } else {
              $str = ltrim($pagelink, '/');
              $pagelink = $site_url . '/' . $str;
            }
            $m->url = $pagelink;
          }

        }

      } else {
        $menu_pages[$object_id] = $m->title;
      }
    }
  }

  /* Sort Sitemap by Menu Order */
  if( $sortbyMenu ) {
    if( $menus ) {

      foreach ($menus as $m) {
        $id = $m->ID;
        $menu_name = $m->title;
        $m_type = $m->type;
        $object_id = $m->object_id;
        $pagelink = $m->url;
        $menu_parent_id = $m->menu_item_parent;
        $external_link = ( isset($m->external_link) && $m->external_link ) ?  true : false;
        if($menu_parent_id>0) {
          $links[$menu_parent_id]['children'][] = array(
              'title' => $menu_name,
              'id'  => $object_id,
              'url' => $pagelink,
              'external_link'=>$external_link
          );
        } else {
          $links[$id] = array(
            'title' => $menu_name,
            'id'  => $object_id,
            'url' => $pagelink,
            'external_link'=>$external_link
          );
        } 
      }

    }

  } else {

    /* Sort pages alphabetically */
    $links = array();
    $children_menus = array();
    $custom_menu_children = array();

    if( $pages ) {
      foreach( $pages as $p ) {
        $id = $p->ID;
        $page_title = $p->post_title;
        $parent_id = $p->post_parent;
        if( $page_title=='Homepage' ) {
          $page_title = 'Home';
        }
        if( $menu_pages && array_key_exists($id, $menu_pages) ) {
          $page_title = $menu_pages[$id];
        }

        $pagelink = get_permalink($id); 
        if($parent_id>0) {
          $children_menus[$parent_id][$id] = array(
                'title' => $page_title,
                'id'  => $id,
                'url' => $pagelink
            );
        } else {
           $links[$id] = array(
                'title' => $page_title,
                'id'  => $id,
                'url' => $pagelink
              );
        }
      }
    }

    /* Add custom menu */
    if( $menus ) {
      foreach ($menus as $m) {
        $id = $m->ID;
        $menu_name = $m->title;
        $m_type = $m->type;
        $object_id = $m->object_id;
        $pagelink = $m->url;
        $menu_parent_id = $m->menu_item_parent;
        $external_link = ( isset($m->external_link) && $m->external_link ) ?  true : false;

        if( $menu_parent_id > 0 ) {
          $menuObj = get_menu_object( $menu_parent_id, $menuName );
          $menu_object_id = ( isset($menuObj->object_id) && $menuObj->object_id ) ? $menuObj->object_id : '';

          $children_menus[$menu_object_id][$object_id] = array(
            'title' => $menu_name,
            'id'  => $object_id,
            'url' => $pagelink,
            'external_link'=>$external_link
          );

          $existing_children = ( isset($children_menus[$menu_object_id]) && $children_menus[$menu_object_id] ) ? $children_menus[$menu_object_id] : '';
          if( $existing_children && !array_key_exists($object_id, $existing_children)) {
            $children_menus[$menu_object_id][$object_id] = array(
              'title' => $menu_name,
              'id'  => $object_id,
              'url' => $pagelink,
              'external_link'=>$external_link
            );
          }
          
          

        } else {

          if( $m_type=='custom' ) {
            $links[$object_id] = array(
              'title' => $menu_name,
              'id'  => $object_id,
              'url' => $pagelink,
              'external_link'=>$external_link
            );
          }
          
        } 

      }
    }

  }


  /* Arrange parent links alphabetically */
  if( !$sortbyMenu ) {
    /* Arrange children menu alphabetically */
    if( $children_menus ) {
      foreach( $children_menus as $parent_id=>$child_objects ) {
        $child_sorted = sort_array_items($child_objects, 'title', 'ASC');
        $children_menus[$parent_id] = $child_sorted;
        if( array_key_exists($parent_id, $links)) {
          $children = array_values($child_sorted);
          $links[$parent_id]['children'] = $children;
        }
      }
    }
    $links = ($links) ? sort_array_items($links, 'title', 'ASC') : '';
  }
  
  return $links;
  
}

function get_menu_object( $menuId, $menuName ) {
  $obj = '';
  if( $menuId && $menuName ) {
    if( $menus = wp_get_nav_menu_items($menuName) ) {
      foreach( $menus as $m ) {
        $id = $m->ID;
        if( $menuId==$id ) {
          $obj = $m;
          break;
        }
      }
    }
  }
  return $obj;
}

function title_formatter($string) {
    if($string) {
        $parts = explode(' ',trim($string));
        $count_str = count($parts);
        $offset = ceil($count_str/2);
        $row_title = '<span>';
        $i=1; foreach($parts as $a) {
            $comma = ($i>1) ? ' ' : '';
            if($i<=$offset) {
                $row_title .= $comma . $a;
                if($i==$offset) {
                    $row_title .= '</span>';
                }
            } else {
                $row_title .= $comma . $a;
            }
            $i++;
        }
        $row_title = trim($row_title);
        $row_title = preg_replace('/\s+/', ' ', $row_title);
    } else {
        $row_title = '';
    }
    return $row_title;
}


function shortenText($string, $limit, $break=".", $pad="...") {
  // return with no change if string is shorter than $limit
  if(strlen($string) <= $limit) return $string;

  // is $break present between $limit and the end of the string?
  if(false !== ($breakpoint = strpos($string, $break, $limit))) {
    if($breakpoint < strlen($string) - 1) {
      $string = substr($string, 0, $breakpoint) . $pad;
    }
  }

  return $string;
}

/* Fixed Gravity Form Conflict Js */
add_filter("gform_init_scripts_footer", "init_scripts");
function init_scripts() {
    return true;
}

function get_page_id_by_template($fileName) {
    $page_id = 0;
    if($fileName) {
        $pages = get_pages(array(
            'post_type' => 'page',
            'meta_key' => '_wp_page_template',
            'meta_value' => $fileName.'.php'
        ));

        if($pages) {
            $row = $pages[0];
            $page_id = $row->ID;
        }
    }
    return $page_id;
}

function string_cleaner($str) {
    if($str) {
        $str = str_replace(' ', '', $str); 
        $str = preg_replace('/\s+/', '', $str);
        $str = preg_replace('/[^A-Za-z0-9\-]/', '', $str);
        $str = strtolower($str);
        $str = trim($str);
        return $str;
    }
}


function sort_array_items($array, $key, $sort='DESC') {
    $sorter=array();
    $ret=array();
    $items = array();

    foreach($array as $k=>$v) {
        $str = string_cleaner($v[$key]);
        $index = $str.'_'.$k;
        $sorter[$index] = $v;
    }

    if($sort=='DESC') {
        krsort($sorter);
    } else {
        ksort($sorter);
    }

    foreach($sorter as $key=>$val) {
        $parts = explode('_',$key);
        $n = $parts[1];
        $items[$n] = $val;
    }
    return $items;
}


function format_phone_number($string) {
    if(empty($string)) return '';
    $append = '';
    if (strpos($string, '+') !== false) {
        $append = '+';
    }
    $string = preg_replace("/[^0-9]/", "", $string );
    $string = preg_replace('/\s+/', '', $string);
    return $append.$string;
}

function get_instagram_setup() {
    global $wpdb;
    $result = $wpdb->get_row( "SELECT option_value FROM $wpdb->options WHERE option_name = 'sb_instagram_settings'" );
    if($result) {
        $option = ($result->option_value) ? @unserialize($result->option_value) : false;
    } else {
        $option = '';
    }
    return $option;
}
