<?php

// 主题设置
add_action('admin_menu','add_flash_submenu_to_admin');
function add_flash_submenu_to_admin(){
	if(!empty($_POST) && $_POST['page'] == $_GET['page'] && $_POST['action'] == 'update_flash') :
		check_admin_referer();
		if(!empty($_POST['flash_list'])){
			$flash_list = $_POST['flash_list'];
			foreach($flash_list as $key => $flash){
				if($flash[0] == '')$flash_list[$key] = '';
			}
			$flash_list = array_filter($flash_list);
			$flash_list = serialize($flash_list);
			update_option('flash_list',$flash_list) or add_option('flash_list',$flash_list);
		}else{
			delete_option('flash_list');
		}
		wp_redirect('admin.php?page='.$_POST['page'].'&saved=true');
		exit;
	endif;
	add_submenu_page('themes.php','幻灯设置','幻灯设置','edit_others_posts','set_flash','add_flash_setting_to_admin');

}

function add_flash_setting_to_admin(){
	if(@$_GET['saved'] == 'true')
		echo '<div id="message" class="updated fade"><p><strong>Flash更新成功！</strong></p></div>';
?>
<div class="wrap">
<form method="post" id="theme-setting">
	<h2 class="nav-tab-wrapper">幻灯设置</h2>
	<div class="metabox-holder">
		<div class="postbox">
			<h3 class="hndle">幻灯图片列表</h3>
			<div class="inside" style="border-bottom: 1px solid #CCC;margin: 0;padding: 8px 10px;">
				<table id="flash-list-table">
					<thead><tr><td>图片地址</td><td>图片链接</td><td>图片描述（标题）</td></tr></thead>
					<tbody>
					<?php
					$key_poser = 0;
					$flash_list = unserialize(get_option('flash_list'));
					if(!empty($flash_list)) :
						foreach($flash_list as $key => $flash){
							echo '<tr>
								<td><input type="text" name="flash_list['.$key.'][]" class="regular-text" value="'.$flash[0].'" /></td>
								<td><input type="text" name="flash_list['.$key.'][]" class="regular-text" value="'.$flash[1].'" /></td>
								<td><input type="text" name="flash_list['.$key.'][]" class="regular-text" value="'.$flash[2].'" /></td>
							</tr>';
							$key_poser = $key;
						}
					else :
						echo '<tr>
							<td><input type="text" name="flash_list[0][]" class="regular-text" value="" /></td>
							<td><input type="text" name="flash_list[0][]" class="regular-text" value="" /></td>
							<td><input type="text" name="flash_list[0][]" class="regular-text" value="" /></td>
						</tr>';
					endif;
					?>
					</tbody>
				</table>
				<p><a href="javascript:add_input_line('flash-list-table','flash_list');">添加一行</a> <span>更新时，将想要删除的图片地址留空就可以删除对应的这项</span></p>
			</div>
		</div>
	</div>
	<div class="metabox-holder">
		<div class="postbox">
			<h3 class="hndle">使用说明</h3>
			<div class="inside" style="border-bottom: 1px solid #CCC;margin: 0;padding: 8px 10px;">
				<p>1、添加对应的内容，当图片地址不存在时，这一行将被删除；</p>
				<p>2、前台调用方法：</p>
				<pre>$flash_list = unserialize(get_option('flash_list'));
if(!empty($flash_list))foreach($flash_list as $flash){
	$img = '&lt;img src="'.$flash[0].'" alt="'.$flash[2].'" /&gt;';
	$image = empty($flash[1]) ? $img : '&lt;a href="'.$flash[1].'" target="_blank" title="'.$flash[2].'"&gt;'.$img.'&lt;/a&gt;';
	echo '&lt;li&gt;'.$image.'&lt;/li&gt;';
}</pre>
				<p>其中$flash[0]就是图片地址，$flash[1]就是链接地址，$flash[2]就是图片标题及alt信息</p>
			</div>
		</div>
	</div>
	<p class="submit">
		<input name="save" type="submit" class="button-primary" value="提交" />
	</p>
	<input type="hidden" name="action" value="update_flash" />
	<input type="hidden" name="page" value="<?php echo $_GET['page']; ?>" />
	<?php wp_nonce_field(); ?>
</form>
</div>
<script>
var $line = <?php echo $key_poser ?>;
function add_input_line($element,$key){
	$element = jQuery('#' + $element + ' tbody');
	$line ++;
	$element.append('<tr><td><input type="text" name="' + $key + '[' + $line + '][]" class="regular-text" value="" /></td><td><input type="text" name="' + $key + '[' + $line + '][]" class="regular-text" value="" /></td><td><input type="text" name="' + $key + '[' + $line + '][]" class="regular-text" value="" /></td></tr>');
}
</script>
<?php
}