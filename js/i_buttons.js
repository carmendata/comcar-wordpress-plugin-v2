/*  
    behaviour.js is included at the bottom of the document in the template, 
    it should eventually replace behave.js once conversion to new template style is complete
*/

// IE8 compatible attach event
function behaviour_addEvent(el, evt, fn) {

    if( el.addEventListener ){
        el.addEventListener(evt, fn, false);
    } else if (el.attachEvent) {
        el.attachEvent('on' + evt, function(){ fn.call(el); } );
    }
}

// i button click function shows/hides an element and switches the style of sender
function behaviour_toggleExplainP(){
    var associatedElemeID = this.getAttribute("data-assocelemid");
    var elemAssociated = document.getElementById(associatedElemeID);
    if( elemAssociated.style.display === 'none' ){
        elemAssociated.style.display = '';
        this.className = this.className.concat( ' button_i_active');
    } else {
        elemAssociated.style.display = 'none';
        this.className = this.className.replace( /button_i_active/g, '');
    } 
}

function behaviour_appendClickToIButton( thisElem ){
    var associatedElemeID = thisElem.getAttribute("data-assocelemid");
    if( typeof associatedElemeID === 'string' ){
        behaviour_addEvent( thisElem, "click", behaviour_toggleExplainP );
    }
}

function behaviour_appendToggleExplainPToClass( strClassName ){

    if( !document.querySelectorAll ){
        // If querySelectorAll() method is not supported, stop
        return;
    }

    var arrButtons = document.querySelectorAll('.' + strClassName);
    for( var i = 0, iLimit = arrButtons.length; i < iLimit; i++ ){

        behaviour_appendClickToIButton( arrButtons[i] );
    }
}

function isSessionStorageAvailableCheck(){
    var test = 'test';
    try {
        sessionStorage.setItem(test, test);
        sessionStorage.removeItem(test);
        return true;
    } catch(e) {
        return false;
    }
}



window.onload = function () {   
    behaviour_appendToggleExplainPToClass('button_i');
    behaviour_appendToggleExplainPToClass('button_d');
};
