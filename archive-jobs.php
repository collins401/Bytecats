<?php get_header(); ?>
<div class="grid-3-4 main" role="main">
	<!-- section -->
	<section>
	<?php cmp_breadcrumbs();?>

				<div class="box-jobs">
					<dl class="hd-title odd">
						<dd class="title">招聘职位</dd>
						<dd>学历</dd>
						<dd>招聘人数</dd>
						<dd>工作年限</dd>
						<dd>发布日期</dd>
					</dl>
		
					<?php $access_key = 1; if (have_posts()): while (have_posts()) : the_post(); $access_key++ ?>
					<dl <?php if($access_key % 2==1){echo "class='odd'";} ?>>
						<a href="<?php the_permalink(); ?>">
						<dd class="title"><?php the_title(); ?></dd>
						<dd>&nbsp;<?php echo esc_html( get_post_meta( get_the_ID(), 'edu_rating', true ) ); ?></dd>
						<dd>&nbsp;<?php echo esc_html( get_post_meta( get_the_ID(), 'job_num', true ) ); ?></dd>
						<dd>&nbsp;<?php echo esc_html( get_post_meta( get_the_ID(), 'job_age', true ) ); ?></dd>
						<dd>&nbsp;<?php the_time('Y-m-d'); ?></dd>
						</a>
					</dl>
					<?php endwhile; ?>

						<?php else: ?>

							<!-- article -->
							<article>
								<h2><?php _e( '暂未发布招聘信息.', 'html5blank' ); ?></h2>
							</article>
							<!-- /article -->
					<?php endif; ?>
				</div>
			

			<?php get_template_part('pagination'); ?>
			
		<!-- /section -->
	</section>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
