<?php
global $wpdb;
if(isset($_POST['stl_node_id'])):
	$_POST = stripslashes_deep($_POST);
	$id = intval($_POST['stl_node_id']);
	$node_content = $_POST['stl_node_content'];
	$node_date = strtotime($_POST['stl_node_date']);
	$node_status = $_POST['stl_node_status'];
	if($wpdb->update($wpdb->prefix.'stl_node', array( 'node_content' => $node_content, 'node_date' => $node_date, 'node_status' => $node_status ), array( 'id' => $id ) ))
	{
		echo '<div class="updated"><p><strong>'.__( 'Update successfully', 'Simple-Timeline' ).'</strong></p></div>';
	}
	else
	{
		echo '<div class="error"><p><strong>'.__( 'Update failed', 'Simple-Timeline' ).'</strong></p></div>';
	}
endif;
if(isset($_GET['node_id'])):
	$node_id = intval($_GET['node_id']);
	$nodes = $wpdb->get_results($wpdb->prepare("SELECT id, node_content, node_date, node_status FROM ".$wpdb->prefix."stl_node WHERE id = %d limit 1 ",$node_id));
endif;
if(!isset($_GET['node_id'])):
	wp_safe_redirect(admin_url('/admin.php?page=STL_admin'));
endif;
?>
<div style="width:80%;margin:50px;">
<?php _e( 'Editing Timeline Node:', 'Simple-Timeline' );?>(<a href="admin.php?page=STL_admin_add"><?php _e( 'Add new', 'Simple-Timeline' );?></a>)
<br >
<br >
<form name="stl_add_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
<label for="stl_node_date"><?php _e( 'Date', 'Simple-Timeline' );?></label>
<input class="Wdate" id="stl_node_date" name="stl_node_date" type="text" value="<?php echo date('Y-m-d',$nodes[0]->node_date); ?>" /> <?php _e( 'Format: ', 'Simple-Timeline' );?>YYYY-MM-DD
<input type="hidden" id="stl_node_id" name="stl_node_id" value="<?php echo $nodes[0]->id;?>" />
<br >
<br >
<label for="stl_node_status"><?php _e( 'Show in Front', 'Simple-Timeline' );?></label>
<select id="stl_node_status" name="stl_node_status">
	<option value="1" <?php if($nodes[0]->node_status==1){echo 'selected';} ?>><?php _e( 'Yes', 'Simple-Timeline' );?></option>
	<option value="0" <?php if($nodes[0]->node_status==0){echo 'selected';} ?>><?php _e( 'No', 'Simple-Timeline' );?></option>
</select>
<br >
<br >
<?php wp_editor( $nodes[0]->node_content, 'stl_node_content' );?>
<br />
<br >
<input type="submit" name="Submit" value="<?php _e( 'Update Node', 'Simple-Timeline' );?>" />
</form>
</div>