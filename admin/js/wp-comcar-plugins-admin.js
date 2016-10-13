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



    $('.selectorToFillBox').on( 'change', function() {
        var field_value = $("option:selected", this).val();
        var header_value = $("option:selected", this).text();

        var field_input = $(this).closest('tr').next('tr').find('input');
        var field_input_content = field_input.val();

        var header_input = $(this).closest('tr').next('tr').next('tr').find('input');    
        var header_input_content = header_input.val();

        if ( field_input_content.length > 0 ) {
            field_input_content = field_input_content + ',' + field_value;
            header_input_content = header_input_content + ',' + header_value;
        } else {
            field_input_content = field_value;
            header_input_content = header_value;
        }
        field_input.val( field_input_content );
        header_input.val( header_input_content );


       
        

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
        console.log()
        $('input.pluginsOptions:not(:checked)').each( function( ) {
            var nav_name =  $(this).attr('name');
            $('a[name='+nav_name+']').addClass('WPComcar_disableSubTab');
        })
       
    }
});

