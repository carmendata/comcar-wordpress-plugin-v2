$=jQuery;

jQuery( document ).ready( function ( $ ) {

	showContentNavActive();
	enableOrDisableNavs();
    showOrHideTextAreas();


    // Selected another nav-tab	
    $( '.nav-tab-wrapper a' ).click( function( event ) {
         if (!$(this).hasClass('WPComcar_disableSubTab')) {
    		$( 'a.nav-tab-active' ).removeClass( 'nav-tab-active' );
    		$( this ).addClass( 'nav-tab-active' );
            showContentNavActive();
         }

    });

     $('.activation_textarea').on( 'click', function( ) {
        var textarea_name = $(this).attr( 'name' ).replace( '_checkbox', '' );
        if( typeof( $(this).attr('checked') ) == 'undefined' ) {
            $( 'textarea[name=' + textarea_name + ']' ).show();
        } else {
            $( 'textarea[name=' + textarea_name + ']' ).hide();
            $( 'textarea[name=' + textarea_name + ']' ).html('');
        }
     });


    function showOrHideTextAreas() {
        $('.activation_textarea:checked').each(function(){
            var textarea_name = $(this).attr( 'name' ).replace( '_checkbox', '' );
            $( 'textarea[name=' + textarea_name + ']' ).hide();
        });
    }

    // Bring up nav content    
    function showContentNavActive() {
        $( '.content_options' ).hide();
        $( "div [name=content_" + $( 'a.nav-tab-active' ).attr( 'name' ) + "]" ).show();
    }

    function enableOrDisableNavs() {
        $('.WPComcar_disableSubTab').removeClass('WPComcar_disableSubTab');
        $('input.general_enableTools:not(:checked)').each( function( ) {
            var nav_name =  $(this).attr('name').replace( 'general_enableTools_', '' );
            nav_name = nav_name.toLowerCase();
            $('[name='+nav_name+']').addClass('WPComcar_disableSubTab');
        })
       
    }
});

