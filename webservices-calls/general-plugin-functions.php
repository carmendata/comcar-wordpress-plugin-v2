<?php

	function WPComcar_getParentTitleName($id){
			global $post;
			if (strlen($id)==0){
				$id=$post->ID;
			}
			$thePageParents = get_post_ancestors( $id );
	        /* Get the top Level page->ID count base 1, array base 0 so -1 */ 
			$parentId = ($thePageParents) ? $thePageParents[count($thePageParents)-1]: $post->ID;
			$theParent=get_page($parentId);
			return $theParent->post_title;
	}		


	function WPComcar_getPageUrlById($id){
		return get_permalink($id);
	}

?>
