<?php if (have_posts()): while (have_posts()) : the_post(); ?>

	<!-- article -->
	<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
		<!-- post title -->
		<h2>
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
		</h2>
		<?php the_time('Y-m-d');?>
	</article>
	<!-- /article -->

<?php endwhile; ?>

<?php else: ?>

	<!-- article -->
	<article>
		<h2><?php _e( 'Sorry, 暂未录入资料.', 'html5blank' ); ?></h2>
	</article>
	<!-- /article -->
	<?php if(is_search()) :?>
		<h2><?php _e( '结果不存在，请重新输入.', 'html5blank' ); ?></h2>
	<?php endif;?>

<?php endif; ?>
