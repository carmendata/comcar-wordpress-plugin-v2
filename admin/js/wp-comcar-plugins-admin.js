$=jQuery;

jQuery( document ).ready( function ( $ ) {
	showContentActiveNav();
	

    // Selected another nav-tab	
    $( '.nav-tab-wrapper a' ).click( function( event ) {


		$( 'a.nav-tab-active' ).removeClass( 'nav-tab-active' );
		$( this ).addClass( 'nav-tab-active' );
        showContentActiveNav();

    });


    // Bring up nav content    
    function showContentActiveNav() {
        $( '.content_options' ).hide();
        $( "div [name=content_" + $( 'a.nav-tab-active' ).attr( 'name' ) + "]" ).show();
    }



});










// var WPComcar_web_service_options="jquery_options";
// var WPComcar_tax_calculator_request="jquery_request";
// var WPComcar_tax_calculator_headers="jquery_headers";



// /******************* jQuery $ symbol necessary to be with $ for the carmenData plugin to work *********/
// $=jQuery;


// /*************************** TABS MANAGEMENT ******************/
// //we will save if we can access the subtab or not (if not selected in the checkbox, then disabled)
// var skvActivatedSubTabs = {};
// //always have access to the general tab
// skvActivatedSubTabs["general"]=true;

// var arrOrderOfPluginsInTabs=new Array();




// function WPComcar_activateSubTabs(){
// 	$(".WPComcar_subTabs").each(function(){
// 		//get the data of the current checkbox to get the tab id
// 		var thisValue=$(this).val();
// 		if( $(this).is(':checked')){
// 			skvActivatedSubTabs[thisValue]=true;
// 			var theWrapper=$(".nav-tab-wrapper ."+thisValue);
// 			theWrapper.removeClass("WPComcar_disableSubTab");
// 		} else {
// 			skvActivatedSubTabs[thisValue]=false;
// 			var theWrapper=$(".nav-tab-wrapper ."+thisValue);
// 			theWrapper.addClass("WPComcar_disableSubTab");
// 		}
// 	});
// }



// function WPComcar_hideAllElementsAndShow(value){
// 	var thisId=0;

// 	if( skvActivatedSubTabs[value] === false ){
// 		return false;
// 	}

// 	for(var i=0;i<arrOrderOfPluginsInTabs.length;i++){
// 		if( arrOrderOfPluginsInTabs[i] === value){
// 			thisId=i;
// 			break;
// 		}
// 	}	

// 	//hide all elements
// 	$("#WPComcar_sections").children().hide();
// 	//get the ith element and show until the following h3
// 	var headerType = 'h3';
// 	if( $("#WPComcar_sections h2").length ) {
// 		var headerType = 'h2';
// 	}
// 	$("#WPComcar_sections " + headerType + ":eq("+ thisId +")").nextUntil( headerType ).show();
// }




// function WPComcar_click_tab(value){
// 	if(WPComcar_hideAllElementsAndShow(value) === false){
// 		return;
// 	}
// 	$(".nav-tab").each(function (index){
// 		$(this).removeClass("nav-tab-active");

// 		if( index === arrOrderOfPluginsInTabs.indexOf(value)){
// 			$(this).addClass("nav-tab-active");
// 		}
// 	});
// }


// $(document).ready(function ($){

// 	/********************** GENERAL OPTIONS ***********************/

// 	for( var i=0; i<arrOrderOfPlugins.length; i++ ){
// 		arrOrderOfPluginsInTabs[i]=arrOrderOfPlugins[i][0];
// 	}

// 	$(".nav-tab-wrapper a").click( function(){
// 		var targettab = $(this).data('targettab');
// 		WPComcar_click_tab(targettab);
// 	});

// 	//hide all the sections and show only the main settings
// 	WPComcar_hideAllElementsAndShow("general");
// 	WPComcar_activateSubTabs();





// 	/* **************** OPTIONS OF TAX CALCULATOR CONTROL ************** */
// 	//we will hide or show the options

// 	$("select[id^=" + WPComcar_web_service_options + "]").change(function(){
// 		//get the value from the options panel
// 		var theWebServiceRequest = $(this).val();

// 		if( theWebServiceRequest == "0")
// 			return;

// 		var theId=$(this).attr("id");
// 		var thisVehicleType="";
// 		if( theId.indexOf("vans")!=-1){
// 			thisVehicleType="vans";
// 		}else if( theId.indexOf("cars")!=-1){
// 			thisVehicleType="cars";
// 		}
// 		//get the text of the option
// 		var theHeader=$("#"+theId+" option:selected").text();

// 		//append its value to the current value of the inputs (HEADERS and REQUEST)
// 		requestVal=$("#"+WPComcar_tax_calculator_request+"_"+thisVehicleType).val();
// 		if( requestVal.length>0){
// 			requestVal=requestVal+","+theWebServiceRequest;
// 		}else{
// 			requestVal=theWebServiceRequest;
// 		}
// 		$("#"+WPComcar_tax_calculator_request+"_"+thisVehicleType).val(requestVal);


// 		headersVal=$("#"+WPComcar_tax_calculator_headers+"_"+thisVehicleType).val();
// 		if( headersVal.length>0){
// 			headersVal=headersVal + "," + theHeader;
// 		}else{
// 			headersVal=theHeader;
// 		}		
// 		$("#"+WPComcar_tax_calculator_headers+"_"+thisVehicleType).val(headersVal);
// 	});
// 	$(".WPComcar_subTabs").click(function(){WPComcar_activateSubTabs();});




// 	/* ******** Functionality for showing/hiding input on "Default" checkbox clicked ********* */
// 	/* *************************************************************************************** */

// 	$(".WPComcar_jquery_editOption").hide();

// 	$(".WPComcar_jquery_click_checkbox").click(function (){
// 		var theRow=$(this).parent().parent().find(".WPComcar_jquery_editOption");
// 		if( !$(this).is(':checked')){
// 			theRow.show();
// 		}else{
// 			//checked
// 			//use default
// 			$(this).parent().parent().find(".WPComcar_jquery_editOption").val("");
// 			theRow.hide();
// 		}
// 	});

// 	WPComcar_checkIfThereIsAnyValueAlreadySaved();


// });




// /* ************************* DEFAULT VALUES IN TEXTS ************************* */
// /* --------------------------------------------------------------------------- */

// function WPComcar_checkIfThereIsAnyValueAlreadySaved(){

// 	$(".WPComcar_jquery_editOption").each(function (){
// 		var thisValue=$(this).val();
// 		var thisType=$(this).attr('type');

// 		//it was already defined, so hide the "Use default thing"
// 		if( (thisValue!=null) && (thisValue.length>0)){
// 			//show the value
// 			$(this).show();
// 			//get the checkbox and click on it
// 			$(this).parent().find(".WPComcar_jquery_click_checkbox").attr("checked",false);
// 		}
// 		//if it is a select
// 		if( thisType==null){
// 			$(this).parent().find(".WPComcar_checkBoxWrap").hide();
// 		}
// 	});
// }




