<?php get_header(); ?>

	<div class="grid-3-4 main" role="main">
		<!-- section -->
		<section id="content">
		<h2>关于我们</h2>
		<!-- 根据页面ID截取简介长度 -->
			<?php  
			$page_id = 2;   
			$content = get_post($page_id)->post_content;   
			$trimmed_content = wp_trim_words( $content, 250, '<a href="'. get_permalink($page_id) .'" class="more-read"> 阅读全文→</a>' );   
			echo '<P>'.$trimmed_content.'</P>';   
			?>  
			
		<!-- 获取最新4个产品 -->
		<h2>产品推荐</h2>
		<ul class="index-pro row">
				   <?php
                  $args = array('post_type' => 'product', 'showposts' => 4, );
                  $my_query = new WP_Query($args);
                  if( $my_query->have_posts() ) {
                      while ($my_query->have_posts()) : $my_query->the_post();?>

				
					<li class="grid-1-4 col-1-2">
						<a href="<?php the_permalink(); ?>"><?php echo post_thumbnail('200','200'); ?></a>
						<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					</li>
					 <?php endwhile; wp_reset_query();} ?>
		</ul>
		<h2>新闻资讯</h2>
		<!-- 获取最新5篇文章 -->
		<ul class="index-news">
				   <?php
                  $args = array('post_type' => 'post', 'showposts' => 5, );
                  $my_query = new WP_Query($args);
                  if( $my_query->have_posts() ) {
                      while ($my_query->have_posts()) : $my_query->the_post();?>

				
					<li>
						
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>  [<?php the_time('Y-m-d'); ?>]
					</li>
					 <?php endwhile; wp_reset_query();} ?>
				</ul>

		</section>
		<!-- /section -->
	</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
