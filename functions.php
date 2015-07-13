<?php
/*
 *  Author: bytecats 
 *  URL: http://www.bytecats.com 
 *  wordpress中文企业站基础模板，共有 文章模型+产品模型+人才招聘
 *  QQ:373345619
 */

/*------------------------------------*\
	External Modules/Files
\*------------------------------------*/
if (!isset($content_width))
{
    $content_width = 900;
}

if (function_exists('add_theme_support'))
{
    // Add Menu Support
    add_theme_support('menus');
    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');

}
/*------------------------------------*\
    Functions
\*------------------------------------*/
// 移除后台面板功能
add_action('wp_dashboard_setup', 'example_remove_dashboard_widgets' );
function example_remove_dashboard_widgets() {
    // Globalize the metaboxes array, this holds all the widgets for wp-admin
    global $wp_meta_boxes;
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']); // 删除 "快速发布" 模块
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']); // 删除 "引入链接" 模块
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']); // 删除 "近期评论" 模块
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);  // 删除 "近期草稿" 模块
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);  // 删除 "WordPress 开发日志" 模块
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);  // 删除 "其它 WordPress 新闻" 模块
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']); // 删除 "概况" 模块
}
//移除不必要后台菜单选项
add_action( 'admin_menu', 'wpjam_remove_admin_menus' );
function wpjam_remove_admin_menus(){
    remove_menu_page( 'index.php' );                  //移除“仪表盘”-隐藏版本更新提示
    remove_menu_page( 'edit-comments.php' );          //移除“评论”
    //remove_menu_page( 'plugins.php' );              //移除"插件"
    remove_menu_page( 'tools.php' );                  //移除"工具"
    remove_submenu_page( 'options-general.php', 'options-writing.php' );    //移除二级菜单：“设置”——“撰写”
    remove_submenu_page( 'options-general.php', 'options-discussion.php' ); //移除二级菜单：“设置”——“讨论”
    remove_submenu_page( 'options-general.php', 'options-media.php' );      //移除二级菜单：“设置”——“多媒体”
}

remove_action('admin_init', '_maybe_update_themes');
add_filter('pre_site_transient_update_themes',  create_function('$a', "return null;"));//禁用主题更新
remove_action( 'load-update-core.php', 'wp_update_plugins' );
add_filter( 'pre_site_transient_update_plugins', create_function( '$a', "return null;" ) );//禁用插件更新
remove_action('admin_init', '_maybe_update_core');
add_filter('pre_site_transient_update_core',    create_function('$a', "return null;")); //禁用版本更新


// 引入扩展库
$function_files_path = dirname(__FILE__).'/inc';
$function_files = scandir($function_files_path);
if($function_files){
    foreach($function_files as $function_file)
        if(substr($function_file,-4) == '.php')
            require_once($function_files_path.'/'.$function_file);
}
//直接输出缩略图url
function html5_thumbnail(){  
    global $post;  
    if ( has_post_thumbnail() ){  
        $domsxe = simplexml_load_string(get_the_post_thumbnail());  
        $thumbnailsrc = $domsxe->attributes()->src;  
        echo $thumbnailsrc;  
    } else {  
        $content = $post->post_content;  
        preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);  
        $n = count($strResult[1]);  
        if($n > 0){  
            echo $strResult[1][0];  
        }else {  
            echo get_bloginfo('template_url').'/img/gravatar.png';  
        }  
    }  
}
//基于timthumb.php 缩略图方法2
function post_thumbnail( $width = 300,$height = 200 ){
    global $post;
    if( has_post_thumbnail() ){
        $timthumb_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full');
     
            $post_timthumb = '<img src="'.get_bloginfo("template_url").'/timthumb.php?src='.$timthumb_src[0].'&amp;h='.$height.'&amp;w='.$width.'&amp;zc=1" alt="'.$post->post_title.'" title="'.get_the_title().'"/>';
        
        return $post_timthumb;
    } else {
        $content = $post->post_content;
        preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);
        $n = count($strResult[1]);
        if($n > 0){
        
                return '<img src="'.get_bloginfo("template_url").'/timthumb.php?w='.$width.'&amp;h='.$height.'&amp;src='.$strResult[1][0].'" title="'.get_the_title().'" alt="'.get_the_title().'"/>';
            } 
         else {
        
                return '<img class="rounded" src="'.get_bloginfo('template_url').'/img/gravatar.jpg" title="'.get_the_title().'" alt="'.get_the_title().'"/>';
            
        }
    }

}
/* 访问计数 */
function record_visitors()
{
    if (is_singular()) 
    {
      global $post;
      $post_ID = $post->ID;
      if($post_ID) 
      {
          $post_views = (int)get_post_meta($post_ID, 'views', true);
          if(!update_post_meta($post_ID, 'views', ($post_views+1))) 
          {
            add_post_meta($post_ID, 'views', 1, true);
          }
      }
    }
}
add_action('wp_head', 'record_visitors'); 
/// 函数作用：取得文章的阅读次数
function post_views($before = '(点击 ', $after = ')', $echo = 1)
{
  global $post;
  $post_ID = $post->ID;
  $views = (int)get_post_meta($post_ID, 'views', true);
  if ($echo) echo $before, number_format($views), $after;
  else return $views;
}

// 加载js (header.php)
function html5blank_header_scripts()
{
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {

    	wp_deregister_script('jquery'); 
    	wp_register_script('jquery', get_template_directory_uri() . '/js/jquery.min.js', array(), '1.8.1',ture); // jQuery.min-1.8.1
    	wp_enqueue_script('jquery'); 

        wp_register_script('html5blankscripts', get_template_directory_uri() . '/js/scripts.js', array(), '1.1.0',ture); // Custom scripts
        wp_enqueue_script('html5blankscripts'); 
    }
}

// 选择性加载js
function html5blank_conditional_scripts()
{
    if (is_page('pagetion')) {
        wp_register_script('scriptname', get_template_directory_uri() . '/js/page.js', array('jquery'), '1.0.0',ture); // Conditional script(s)
        wp_enqueue_script('scriptname'); 
    }
}

// 加载css
function html5blank_styles()
{

    wp_register_style('html5blank', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');
    wp_enqueue_style('html5blank'); 
}

// 注册菜单
function register_html5_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('头部导航', 'html5blank'), // Main Navigation
        'sidebar-menu' => __('边栏导航', 'html5blank'), // Sidebar Navigation
        'extra-menu' => __('附加导航', 'html5blank') // Extra Navigation if needed (duplicate as many as you need!)
    ));
}
// 移除导航ul外出 <div> 
function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    return $args;
}

// 移除导航菜单 <li> ID属性
function my_css_attributes_filter($var)
{
    return is_array($var) ? array() : '';
}

// Remove rel
function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// 添加body类
function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

// 注册挂件
if (function_exists('register_sidebar'))
{
    // 设置 小挂件1
    register_sidebar(array(
        'name' => __('小挂件1', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-1',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    // 设置 小挂件2
    register_sidebar(array(
        'name' => __('小挂件2', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-2',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
}

// 分页函数
function html5wp_pagination()
{
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
}

// 定义简介字数  调用函数 html5wp_excerpt('html5wp_index');
function html5wp_index($length)
{
    return 50;
}

// 定义简介字数200 调用函数 html5wp_excerpt('html5wp_custom_post');
function html5wp_custom_post($length)
{
    return 200;
}

// 创建简介回调函数
function html5wp_excerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}

// 定义"更多"样式
function html5_blank_view_article($more)
{
    global $post;
    return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('阅读全文', 'html5blank') . '</a>';
}

// 移除引入样式 'text/css' 
function html5_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// 移除缩略图width与height参数
function remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

// 设置头像本地存储
function html5blankgravatar ($avatar_defaults)
{
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}



/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('init', 'html5blank_header_scripts'); // 通过 wp_head 引入js文件
add_action('wp_print_scripts', 'html5blank_conditional_scripts'); // Add Conditional Page Scripts

add_action('wp_enqueue_scripts', 'html5blank_styles'); // Add Theme Stylesheet
add_action('init', 'register_html5_menu'); // Add HTML5 Blank Menu
add_action('init', 'html5wp_pagination'); // Add our HTML5 Pagination

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); //移除head中的rel="EditURI"
remove_action('wp_head', 'wlwmanifest_link'); //移除head中的rel="wlwmanifest"
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); //禁止在head泄露wordpress版本号
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
add_filter('avatar_defaults', 'html5blankgravatar'); // 自定义用户头像 in Settings > Discussion
add_filter('body_class', 'add_slug_to_body_class'); //添加body类
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // 允许在简介中使用短代码 (Manual Excerpts only)
add_filter('excerpt_more', 'html5_blank_view_article'); // 在简介中添加 '阅读全文' 
add_filter('style_loader_tag', 'html5_style_remove'); // 移除样式中的 'text/css'
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // 移除缩略图中的width与height参数
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // 移除文章正文中的width与height参数

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

/*------------------------------------*\
	获取单篇文章图片总数 <!--?php echo post_img_number().'张'; ?-->
\*------------------------------------*/
//获取文章图片总数
function post_img_number(){
    global $post, $posts;
    ob_start();
    ob_end_clean();

    //使用do_shortcode($post->post_content) 是为了处理在相册的情况下统计图片张数
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i',do_shortcode($post->post_content), $matches);
    $cnt = count( $matches[1] );
    	if($cnt==0){
    		return '';
    	}
    	return '共'.$cnt.'张图片';
}
//面包屑
function cmp_breadcrumbs() {
    $delimiter = '<span class="divider">/</span>'; // 分隔符
    $before = '<span class="active">'; // 在当前链接前插入
    $after = '</span>'; // 在当前链接后插入
    if ( !is_home() && !is_front_page() || is_paged() ) {
        echo '<div class="breadcrumb">';
        global $post;
        $homeLink = home_url();
        echo '当前位置： <a href="' . $homeLink . '">' . __( '首页' , 'html5blank' ) . '</a> ' . $delimiter . ' ';
        if ( is_category() ) { // 分类 存档
            global $wp_query;
            $cat_obj = $wp_query->get_queried_object();
            $thisCat = $cat_obj->term_id;
            $thisCat = get_category($thisCat);
            $parentCat = get_category($thisCat->parent);
            if ($thisCat->parent != 0){
                $cat_code = get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' ');
                echo $cat_code = str_replace ('<a','<a', $cat_code );
            }
            echo $before . '' . single_cat_title('', false) . '' . $after;
        } elseif ( is_month() ) { // 月 存档
            echo '<a itemprop="breadcrumb" href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
            echo $before . get_the_time('F') . $after;
        } elseif ( is_year() ) { // 年 存档
            echo $before . get_the_time('Y') . $after;
        } elseif ( is_single() && !is_attachment() ) { // 文章
            if ( get_post_type() != 'post' ) { // 自定义文章类型
                $post_type = get_post_type_object(get_post_type());
                $slug = $post_type->rewrite;
                echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
                echo $before . get_the_title() . $after;
            } else { // 文章 post
                $cat = get_the_category(); $cat = $cat[0];
                $cat_code = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
                echo $cat_code = str_replace ('<a','<a', $cat_code );
                echo $before . '正文' . $after;
            }
        } elseif ( !is_single() && !is_page() && get_post_type() != 'post' ) {
            $post_type = get_post_type_object(get_post_type());
            echo $before . $post_type->labels->singular_name . $after;
        } elseif ( is_page() && !$post->post_parent ) { // 页面
            echo $before . get_the_title() . $after;
        } elseif ( is_page() && $post->post_parent ) { // 父级页面
            $parent_id  = $post->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                $page = get_page($parent_id);
                $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
                $parent_id  = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
            echo $before . get_the_title() . $after;
        } elseif ( is_search() ) { // 搜索结果
            echo $before ;
            printf( __( '搜索结果: %s', 'html5blank' ),  get_search_query() );
            echo  $after;
        } elseif ( is_404() ) { // 搜索结果
            echo $before ;
            printf( __( '404错误页面提示', 'html5blank' ),  get_search_query() );
            echo  $after;
        }
        elseif ( is_tag() ) { //标签 存档
            echo $before ;
            printf( __( 'Tag标签: %s', 'html5blank' ), single_tag_title( '', false ) );
            echo  $after;
        } 
        elseif ( is_author() ) { //标签 存档
            echo $before ;
            printf( __( '作者: <strong> %s </strong>的所有文章', 'html5blank' ), get_the_author() );
            echo  $after;
        } 
        if ( get_query_var('paged') ) { // 分页
            if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() )
                echo sprintf( __( '( 分页 %s )', 'html5blank' ), get_query_var('paged') );
        }
        echo '</div>';
    }
}

/**
 * WordPress 后台禁用Google Open Sans字体，加速网站
 */
add_filter( 'gettext_with_context', 'wpdx_disable_open_sans', 888, 4 );
function wpdx_disable_open_sans( $translations, $text, $context, $domain ) {
  if ( 'Open Sans font: on or off' == $context && 'on' == $text ) {
    $translations = 'off';
  }
  return $translations;
}
/**
 * 禁用 Emoji 功能
 */
remove_action( 'admin_print_scripts',   'print_emoji_detection_script');
remove_action( 'admin_print_styles',    'print_emoji_styles');

remove_action( 'wp_head',       'print_emoji_detection_script', 7);
remove_action( 'wp_print_styles',   'print_emoji_styles');

remove_filter( 'the_content_feed',  'wp_staticize_emoji');
remove_filter( 'comment_text_rss',  'wp_staticize_emoji');
remove_filter( 'wp_mail',       'wp_staticize_emoji_for_email');
//自定义后台登陆界面样式        
// function diy_login_page() {
//   echo '<link rel="stylesheet" href="' . get_bloginfo( 'template_directory' ) . '/login.css" type="text/css" media="all" />' . "\n";
// }
// add_action( 'login_enqueue_scripts', 'diy_login_page' );

//去除category
 add_action( 'load-themes.php',  'no_category_base_refresh_rules');
 add_action('created_category', 'no_category_base_refresh_rules');
 add_action('edited_category', 'no_category_base_refresh_rules');
 add_action('delete_category', 'no_category_base_refresh_rules');
 function no_category_base_refresh_rules() {
     global $wp_rewrite;
     $wp_rewrite -> flush_rules();
 }
 add_action('init', 'no_category_base_permastruct');
 function no_category_base_permastruct() {
     global $wp_rewrite, $wp_version;
     if (version_compare($wp_version, '3.4', '<')) {
         $wp_rewrite -> extra_permastructs['category'][0] = '%category%';
     } else {
         $wp_rewrite -> extra_permastructs['category']['struct'] = '%category%';
     }
 }
 add_filter('category_rewrite_rules', 'no_category_base_rewrite_rules');
 function no_category_base_rewrite_rules($category_rewrite) {
     $category_rewrite = array();
     $categories = get_categories(array('hide_empty' => false));
     foreach ($categories as $category) {
         $category_nicename = $category -> slug;
         if ($category -> parent == $category -> cat_ID)// recursive recursion
             $category -> parent = 0;
         elseif ($category -> parent != 0)
             $category_nicename = get_category_parents($category -> parent, false, '/', true) . $category_nicename;
         $category_rewrite['(' . $category_nicename . ')/(?:feed/)?(feed|rdf|rss|rss2|atom)/?$'] = 'index.php?category_name=$matches[1]&feed=$matches[2]';
         $category_rewrite['(' . $category_nicename . ')/page/?([0-9]{1,})/?$'] = 'index.php?category_name=$matches[1]&paged=$matches[2]';
         $category_rewrite['(' . $category_nicename . ')/?$'] = 'index.php?category_name=$matches[1]';
     }
     global $wp_rewrite;
     $old_category_base = get_option('category_base') ? get_option('category_base') : 'category';
     $old_category_base = trim($old_category_base, '/');
     $category_rewrite[$old_category_base . '/(.*)$'] = 'index.php?category_redirect=$matches[1]';
     return $category_rewrite;
 }

 add_filter('query_vars', 'no_category_base_query_vars');
 function no_category_base_query_vars($public_query_vars) {
     $public_query_vars[] = 'category_redirect';
     return $public_query_vars;
 }
    
 add_filter('request', 'no_category_base_request');
 function no_category_base_request($query_vars) {
     if (isset($query_vars['category_redirect'])) {
         $catlink = trailingslashit(get_option('home')) . user_trailingslashit($query_vars['category_redirect'], 'category');
         status_header(301);
         header("Location: $catlink");
         exit();
     }
     return $query_vars;
 }