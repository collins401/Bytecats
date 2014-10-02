<?php get_header(); ?>

	<div class="grid-3-4 main" role="main">
		<!-- section -->
		<section>
<?php cmp_breadcrumbs();?>
			<h1><?php echo sprintf( __( '%s 条搜索结果', 'html5blank' ), $wp_query->found_posts ); 
					echo "<strong>".get_search_query()."</strong>" ?></h1>

			<?php


		$search_refer = $_GET["post_type"];
		if ($search_refer == 'product') {
   		 if ('meta_key=champion&meta_value=$search_query') {     load_template(TEMPLATEPATH . '/loop-product.php'); } 

   		}else{
    		 get_template_part('loop'); 
    	};
    	

 ?>
			<?php get_template_part('pagination'); ?>

		</section>
		<!-- /section -->
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
