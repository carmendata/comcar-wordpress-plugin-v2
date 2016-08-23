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


	function fixForSsl( $url ) {
		$fixedUrl = urlencode( $url );
		// Is this an https request?
		if( is_ssl() ) {
			// Are we in a dev environment?
			if( strLen( DEV_VM ) > 0 ) {
				// convert from dev.media.comcar.co.uk/d51alfie/
				// to d51alfie.media.comcar.co.uk
				$fixedUrl = str_replace( DEV_VM.'%2F', '', $fixedUrl );
				$fixedUrl = str_replace( 'dev', DEV_VM, $fixedUrl );
				
			} 		
			$fixedUrl = str_replace( 'media.comcar.co.uk', 'secure.carmendata.co.uk', $fixedUrl  );
			$fixedUrl = str_replace( 'comcar.co.uk', 'secure.carmendata.co.uk', $fixedUrl  );
			$fixedUrl = str_replace( 'http', 'https', $fixedUrl  );
			$fixedUrl = str_replace( 'httpss', 'https', $fixedUrl  );
		}		
		return urldecode( $fixedUrl );
	}

?>
