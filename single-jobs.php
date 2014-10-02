<?php get_header(); ?>

<div class="grid-3-4 main" role="main">
	<!-- section -->
	<section>
	<?php cmp_breadcrumbs();?>
				<?php if (have_posts()): while (have_posts()) : the_post(); ?>

					<!-- article -->
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<!-- post title -->
						<h1 class="jobs-h1">
							<?php the_title(); ?>
						</h1>
						
						<div class="entry-article">
							
							<p><strong>招聘人数：</strong><?php echo esc_html( get_post_meta( get_the_ID(), 'job_num', true ) ); ?></p>
							<p><strong>工作年限：</strong><?php echo esc_html( get_post_meta( get_the_ID(), 'job_age', true ) ); ?></p>
							<p><strong>学历要求：</strong><?php echo esc_html( get_post_meta( get_the_ID(), 'edu_rating', true ) ); ?></p>
							<p><strong>发布日期：</strong><?php the_time('Y-m-d'); ?></p>
	
							<?php the_content(); // Dynamic Content ?>
						</div>
						
					</article>
					<!-- /article -->
				<?php endwhile; ?>
				<?php else: ?>
					<!-- article -->
					<article>
						<h1><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h1>
					</article>
					<!-- /article -->
				<?php endif; ?>
		
		
	<section>
		<!-- /section -->
</div>
<?php get_sidebar(); ?>

<?php get_footer(); ?>
