<?php get_header(); ?>

	<div class="grid-3-4 main" role="main">
	<!-- section -->
	<section>
<?php cmp_breadcrumbs();?>
	<?php if (have_posts()): while (have_posts()) : the_post(); ?>

		<!-- article -->
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<!-- post thumbnail -->
			<?php if ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
					<?php the_post_thumbnail(); // Fullsize image for the single post ?>
				</a>
			<?php endif; ?>
			<!-- /post thumbnail -->

			<!-- post title -->
			<h1>
				<?php the_title(); ?>
			</h1>
			<!-- /post title -->

			<!-- post details -->
			<div class="post-meta">
				<span class="author"><?php _e( '编辑：', 'html5blank' ); the_author(); ?></span>
				<span class="date"><?php  _e( '时间：', 'html5blank' );  the_time('Y-m-d'); ?></span>
				<span class="category"><?php _e( '分类: ', 'html5blank' ); the_category(', '); // Separated by commas ?></span>
				<span class="views"><?php post_views('阅读：',''); ?></span>
			</div>
			<!-- post details -->
			<div class="entry-article">
				<?php the_content(); // Dynamic Content ?>
			

				<?php the_tags( __( '标签: ', 'html5blank' ), ', ', '<br>'); // Separated by commas with a line break at the end ?>
颜色：<?php echo get_the_term_list($post->ID, 'color', '', ', ', ''); ?> <br>
价格：<?php echo get_the_term_list($post->ID, 'jijie', '', ', ', ''); ?>
			</div>
		 	<ul class="pagetion clearfix">
              <li class="nav-prev"><?php previous_post_link('上一篇： %link'); ?></li>
              <li class="nav-next"><?php next_post_link('下一篇： %link'); ?></li>     
            </ul>   

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
