<div class="row clearfix">
<?php if (have_posts()): while (have_posts()) : the_post(); ?>

	<!-- article -->
	<article id="post-<?php the_ID(); ?>" <?php post_class('grid-1-4'); ?>>

	

	<!-- post thumbnail -->
	
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<?php echo post_thumbnail('150','150'); // Declare pixel size you need inside the array ?>
			</a>
	
		<!-- /post thumbnail -->
	

		<!-- post title -->
		<h2>
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
		</h2>
		<!-- /post title -->
	</article>
	<!-- /article -->

<?php endwhile; ?>

<?php else: ?>

	<!-- article -->
	<article class="grid-1-1">
		<h2><?php _e( '结果不存在，请重新输入.', 'html5blank' ); ?></h2>
	</article>
	<!-- /article -->

<?php endif; ?>
</div>