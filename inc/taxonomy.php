<?php

/*------------------------------------*\
	Custom Post Types
\*------------------------------------*/

// Create 1 Custom Post type for a Demo, called HTML5-Blank
add_action('init', 'create_post_type_html5'); // Add our HTML5 Blank Custom Post Type
function create_post_type_html5()
{
    register_taxonomy_for_object_type('category', 'html5-blank'); // Register Taxonomies for Category
    register_taxonomy_for_object_type('post_tag', 'html5-blank');
    register_post_type('product', // Register Custom Post Type
        array(
        'labels' => array(
             'name' => __('产品', 'html5blank'), // Rename these to suit
            'singular_name' => __('产品', 'html5blank'),
            'add_new' => __('添加新产品', 'html5blank'),
            'add_new_item' => __('添加新产品', 'html5blank'),
            'edit' => __('编辑', 'html5blank'),
            'edit_item' => __('编辑文章', 'html5blank'),
            'new_item' => __('新产品', 'html5blank'),
            'view' => __('查看', 'html5blank'),
            'view_item' => __('查看', 'html5blank'),
            'search_items' => __('搜索产品', 'html5blank'),
            'not_found' => __('暂无产品', 'html5blank')
            
        ),
        'public' => true,
        'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail'
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        'can_export' => true, // Allows export in Tools > Export
        'rewrite' => array('slug' => product) 

    ));
 register_taxonomy('location','product',array(
    'hierarchical' => true,
    'labels' =>'产品分类',
    'rewrite' => array( 'slug' => 'products' ),


  ));
}

/*------------------------------------*\
	ShortCode Functions
\*------------------------------------*/

// Create 1 Custom Post type for a Demo, called HTML5-Blank
add_action('init', 'create_post_type_jobs'); // Add our HTML5 Blank Custom Post Type
function create_post_type_jobs()
{
    register_taxonomy_for_object_type('category', 'html5-blank'); // Register Taxonomies for Category
    register_taxonomy_for_object_type('post_tag', 'html5-blank');
    register_post_type('jobs', // Register Custom Post Type
        array(
        'labels' => array(
             'name' => __('招聘', 'html5blank'), // Rename these to suit
            'singular_name' => __('招聘', 'html5blank'),
            'add_new' => __('添加', 'html5blank'),
            'add_new_item' => __('添加新招聘', 'html5blank'),
            'edit' => __('编辑', 'html5blank'),
            'edit_item' => __('编辑文章', 'html5blank'),
            'new_item' => __('新招聘', 'html5blank'),
            'view' => __('查看', 'html5blank'),
            'view_item' => __('查看', 'html5blank'),
            'search_items' => __('搜索招聘', 'html5blank'),
            'not_found' => __('暂无招聘', 'html5blank')
            
        ),
        'public' => true,
        'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail'
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        'can_export' => true, // Allows export in Tools > Export
        'rewrite' => array('slug' => 'jobs') 

    ));
 // register_taxonomy('alljobs','jobs',array(
 //    'hierarchical' => true,
 //    'labels' =>'招聘分类',
 //    'rewrite' => array( 'slug' => 'all-jobs' ),

 //  ));
}
add_action( 'admin_init', 'my_admin' );

    function my_admin() {
        add_meta_box( 'jobs_meta_box',
    '招聘条件字段',
    'display_job_meta_box',
    'jobs', 'normal', 'high' );
}

function display_job_meta_box( $job ) {
    //注册自定义字段
    $job_num =
    esc_html( get_post_meta( $job->ID,
    'job_num', true ) );
    $job_age =
    esc_html( get_post_meta( $job->ID,
    'job_age', true ) );
    $edu_rating =
    esc_html( get_post_meta( $job->ID,
    'edu_rating', true ) );
?>
<table>
<tr>
<td style="width: 100px;">招聘人数：</td>
<td style="width: 120px;"><input type="text" style="width: 110px"
name="job_num_name"
value="<?php echo $job_num; ?>" /></td>
<td>人</td>
</tr>
<tr>
<td style="width: 100px;">工作年限：</td>
<td style="width: 120px;"><input type="text" style="width: 110px"
name="job_age_name"
value="<?php echo $job_age; ?>" /></td>
<td>年</td>
</tr>
<tr>
<td>学历要求：</td>
<td>
<select style="width: 110px" name="edu_rating" >
 
 <option value="本科" <?php selected( $edu_rating, 本科 ); ?>>本科</option>
 <option value="硕士及其以上" <?php selected( $edu_rating, 硕士及其以上 ); ?>>硕士及其以上</option>
 <option value="大专" <?php selected( $edu_rating, 大专 ); ?>>大专</option>
 <option value="中专" <?php selected( $edu_rating, 中专 ); ?>>中专</option>
 <option value="高中" <?php selected( $edu_rating, 高中 ); ?>>高中</option>
 <option value="初中" <?php selected( $edu_rating, 初中 ); ?>>初中</option>
</select>
</td>
</tr>
</table>
<?php }

add_action( 'save_post','add_job_fields', 10, 2 );
function add_job_fields( $job_id,$job ) {
     // 保存自定义字段
    if ( $job->post_type == 'jobs' ) {
   
        if ( isset( $_POST['job_num_name'] ) && $_POST['job_num_name'] != '' ) {
            update_post_meta( $job_id, 'job_num',
            $_POST['job_num_name'] );
        }
        if ( isset( $_POST['job_age_name'] ) && $_POST['job_age_name'] != '' ) {
            update_post_meta( $job_id, 'job_age',
            $_POST['job_age_name'] );
        }
        if ( isset( $_POST['edu_rating'] ) && $_POST['edu_rating'] != '' ) {
            update_post_meta( $job_id, 'edu_rating',
            $_POST['edu_rating'] );
        }
    }
}

//添加自定义文章到存档页
function example_getarchives_where($where) {
    return str_replace("WHERE post_type = 'product'", "WHERE post_type
    IN ('product', 'cpt')", $where);
}
add_filter('getarchives_where', 'example_getarchives_where');
if( !class_exists('CustomPostTypeArchiveInNavMenu') ) {
    class CustomPostTypeArchiveInNavMenu {
        function CustomPostTypeArchiveInNavMenu() {
            add_action( 'admin_head-nav-menus.php', array( &$this, 'cpt_navmenu_metabox' ) );
            add_filter( 'wp_get_nav_menu_items', array( &$this,'cpt_archive_menu_filter'), 10, 3 );
        }
        function cpt_navmenu_metabox() {
            add_meta_box( 'add-cpt', __('自定义文章类型菜单'), array( &$this, 'cpt_navmenu_metabox_content' ), 'nav-menus', 'side', 'default' );
        }
        function cpt_navmenu_metabox_content() {
            $post_types = get_post_types( array( 'show_in_nav_menus' => true, 'has_archive' => true ), 'object' );
            if( $post_types ) {
                foreach ( $post_types as &$post_type ) {
                    $post_type->classes = array();
                    $post_type->type = $post_type->name;
                    $post_type->object_id = $post_type->name;
                    $post_type->title = $post_type->labels->name . __( '存档' );
                    $post_type->object = 'cpt-archive';
                }
                $walker = new Walker_Nav_Menu_Checklist( array() );
                echo '<div id="cpt-archive" class="posttypediv">';
                echo '<div id="tabs-panel-cpt-archive" class="tabs-panel tabs-panel-active">';
                echo '<ul id="ctp-archive-checklist" class="categorychecklist form-no-clear">';
                echo walk_nav_menu_tree( array_map('wp_setup_nav_menu_item', $post_types), 0, (object) array( 'walker' => $walker) );
                echo '</ul>';
                echo '</div><!-- /.tabs-panel -->';
                echo '</div>';
                echo '<p class="button-controls">';
                echo '<span class="add-to-menu">';
                echo '<input type="submit"' . disabled( $nav_menu_selected_id, 0 ) . ' class="button-secondary submit-add-to-menu right" value="'. __('添加至菜单') . '" name="add-ctp-archive-menu-item" id="submit-cpt-archive" />';
                echo '<span class="spinner"></span>';
                echo '</span>';
                echo '</p>';
            } else {
                echo '没有自定义文章类型';
            }
        }
        function cpt_archive_menu_filter( $items, $menu, $args ) {
            foreach( $items as &$item ) {
                if( $item->object != 'cpt-archive' ) continue;
                $item->url = get_post_type_archive_link( $item->type );
                if( get_query_var( 'post_type' ) == $item->type ) {
                    $item->classes[] = 'current-menu-item';
                    $item->current = true;
                }
            }
            return $items;
        }
    }
    $CustomPostTypeArchiveInNavMenu = new CustomPostTypeArchiveInNavMenu();
}
// 自定义文章类型固定链接
add_filter('post_type_link', 'custom_product_link', 1, 3);
function custom_product_link( $link, $post = 0 ){
    if ( $post->post_type == 'product' ){
        return home_url( 'product/' . $post->ID .'.html' );
    } else {
        return $link;
    }
}
add_action( 'init', 'custom_product_rewrites_init' );
function custom_product_rewrites_init(){
    add_rewrite_rule(
        'product/([0-9]+)?.html$',
        'index.php?post_type=product&p=$matches[1]',
        'top' );
}