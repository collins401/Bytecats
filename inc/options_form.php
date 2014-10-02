

<?php 

add_action('admin_menu','web589_theme_options');
function web589_theme_options(){
		add_submenu_page('themes.php','主题选项','主题选项','edit_others_posts','bpro_options','web589_theme_options_form');
// 		add_submenu_page('themes.php','Flash设置','Flash设置','edit_others_posts','set_flash','add_flash_setting_to_admin');
 }
$str[]='PGRpdiBpZD0ibGZkIj50aGVtZSBie';
function web589_theme_options_form(){

	if($_POST['submit']){
		update_option('web589BP_introduce_page',$_POST['page_id']);
		update_option('web589BP_product_cat',$_POST['cat']);
		update_option('web589BP_copyright',$_POST['copyright']);
		update_option('tel',$_POST['tel']);
        update_option('email',$_POST['email']);
        update_option('qq',$_POST['qq']);
        update_option('icp',$_POST['icp']);
	}
?>

<style type="text/css">
#index_form{width:600px; border:1px solid #ddd; background-color:#f7f7f7; margin:20px 0; padding:10px;}
#index_form label{margin-right:10px;}
#index_form textarea{width:580px; height:100px; margin-top:10px;}
</style>

<div class="wrap">
<div id="icon-options-general" class="icon32"><br></div><h2>首页选项</h2>

<form action="" method="post" id="index_form">
	<p><label for="page_id">简介页面</label>
	<?php wp_dropdown_pages(array('selected'=>get_option('web589BP_introduce_page')));?>
	</p>
	<p><label for="cat">产品展示</label>
	<?php wp_dropdown_categories(array('selected'=>get_option('web589BP_product_cat'),'taxonomy'=>'location','show_options_all'=>true,'hierarchical'=>true));?>
	</p>
	    <p><label for="tel">热线电话</label>
        <input type="text" name="tel" value="<?php echo get_option('tel'); ?>" />
    </p>
    <p><label for="qq">腾 讯Q Q</label>
        <input type="text" name="qq" value="<?php echo get_option('qq'); ?>" />
    </p>
    <p><label for="email">电子邮箱</label>
        <input type="text" name="email" value="<?php echo get_option('email'); ?>" />
    </p>
    <p><label for="icp">备 案 号</label>
        <input type="text" name="icp" value="<?php echo get_option('icp'); ?>" />
    </p>
	<p><label for="copyright">底部版权及统计代码</label>
	<textarea id="copyright" name="copyright"><?php echo stripslashes(get_option('web589BP_copyright')); ?></textarea></p>
	<?php submit_button();?>
</form>

</div>
<?php 
}
?>