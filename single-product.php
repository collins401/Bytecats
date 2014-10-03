<?php get_header(); ?>

	<div class="grid-3-4 main" role="main">
	<!-- section -->
	<section>
	<?php cmp_breadcrumbs();?>
<?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); ?>

	<?php if (have_posts()): while (have_posts()) : the_post(); ?>

		<!-- article -->
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			

			<!-- post title -->
			<h1>
				<?php the_title(); ?>
			</h1>
	
			
			<div class="entry-article">
				<?php the_content(); // Dynamic Content ?>
			</div>
<?php 

// 按同分类获取相关产品

$custom_taxterms = wp_get_object_terms( $post->ID, 'location', array('fields' => 'ids') );
// arguments
$args = array(
'post_type' => 'product',
'post_status' => 'publish',
'posts_per_page' => 3, // you may edit this number
'orderby' => 'rand',
'tax_query' => array(
    array(
        'taxonomy' => 'location',
        'field' => 'id',
        'terms' => $custom_taxterms
    )
),
'post__not_in' => array ($post->ID),
);
$related_items = new WP_Query( $args );
// loop over query
if ($related_items->have_posts()) :
echo '<h3 class="related">相关产品</h3>';
echo '<ul class="row clearfix">';
while ( $related_items->have_posts() ) : $related_items->the_post();
?>
    <li class="gird-1-4">
    	<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo post_thumbnail('110','90'); ?></a>
    </li>
<?php
endwhile;
echo '</ul>';
endif;
// Reset Post Data
wp_reset_postdata();
?>
		</article>
		<!-- /article -->

	<?php endwhile; ?>

	<?php else: ?>

		<!-- article -->
		<article>

			<h1><?php _e( 'Sorry, 暂未录入资料.', 'html5blank' ); ?></h1>

		</article>
		<!-- /article -->

	<?php endif; ?>

	</section>
	<!-- /section -->
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
