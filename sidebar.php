<!-- sidebar -->
<aside class="grid-1-4 sidebar" role="complementary">

  <div class="widget">
    <!-- search -->
    <h3>新闻搜索</h3>
<form class="search" method="get" action="<?php echo home_url(); ?>" role="search">
  <input class="search-input" type="search" name="s" placeholder="<?php _e( '新闻搜索.', 'html5blank' ); ?>">
  <input name="post_type" type="hidden" value="post" />
  <button class="search-submit" type="submit" role="button"><?php _e( '搜索', 'html5blank' ); ?></button>
</form>
<!-- /search -->
 <h3>产品搜索</h3>
<form class="search" method="get" action="<?php echo home_url(); ?>" role="search">
  <input class="search-input" type="search" name="s" placeholder="<?php _e( '产品搜索.', 'html5blank' ); ?>">
  <input name="post_type" type="hidden" value="product" />
  <button class="search-submit" type="submit" role="button"><?php _e( '搜索', 'html5blank' ); ?></button>
</form>

  </div>
  <div class="widget">
    <h3>产品分类</h3>
      <?php 
  //list terms in a given taxonomy using wp_list_categories (also useful as a widget if using a PHP Code plugin)
   
  $taxonomy     = 'location';
  $orderby      = 'name'; 
  $show_count   = 0;      // 1 for yes, 0 for no
  $pad_counts   = 0;      // 1 for yes, 0 for no
  $hierarchical = 1;      // 1 for yes, 0 for no
  $title        = '';
   
  $args = array(
    'taxonomy'     => $taxonomy,
    'orderby'      => $orderby,
    'show_count'   => $show_count,
    'pad_counts'   => $pad_counts,
    'hierarchical' => $hierarchical,
    'title_li'     => $title
  );
  ?>
   
  <ul class="items-cat">
  <?php wp_list_categories( $args ); ?>
  </ul> 
  </div>
	<div class="sidebar-widget">
		<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('widget-area-1')) ?>
	</div>

</aside>
<!-- /sidebar -->
