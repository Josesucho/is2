var IS2 = IS2 || {};
	
IS2.initDatepickers = function( setDefaultValue ) {
	var $elems = $( '.datepicker' ).datepicker( {
		format: 'dd/mm/yyyy',
		language: 'es'
	} );
	if( setDefaultValue ) {
		$elems.datepicker( 'setValue', new Date() );
	}
};

IS2.initTimepickers = function( config ) {
	$( '.timepicker' ).timepicker( $.extend( {
		showInputs: false,
		showMeridian: false
	}, config ) );	
};

IS2.prevStateDict = [
	'is2-appointment-state'
];

IS2.cleanPrevState = function( skip ) {
	IS2.prevStateDict.forEach( function( name ) {
		if( skip !== name ) {
			localStorage.removeItem( name );
		}
	} );
};

IS2.loadPrevState = function( name, callback ) {
	var prevState = JSON.parse( localStorage.getItem( name ) );
	if( prevState ) {
		if( window.location.search.indexOf( 'error' ) >= 0 ) {
			for( var fieldName in prevState ) {
				$( '[name=' + fieldName + ']' ).val( prevState[fieldName] );
			}
		}
		this.cleanPrevState();
		callback && callback( prevState );
	}
};

IS2.savePrevState = function( name, skip ) {
	var prevState = {};
	$( 'form ' ).find( 'input, select' ).each( function( e ) {
		var $el = $( this ),
			fieldName = $el.attr( 'name' );
		if( fieldName && fieldName !== skip ) {
			prevState[fieldName] = $el.val().replace( /&/g, '&amp;' ).replace( /</g, '&lt;' ).replace( />/g, '&gt;' );
		}
	} );
	window.localStorage.setItem( name, JSON.stringify( prevState ) );
};

IS2.showNewRecord = function( $el ) {
	
	var $document = $( document ),
		$popoverTemplate = $( '.is2-popover' ),
		$popoverClose,
		$popover,
		closePopupTimeout;
	
	$el.addClass( 'is2-record-new' ).popover( {
		trigger: 'manual',
		placement: 'bottom',
		html: true,
		content: $popoverTemplate.prop( 'outerHTML' )
	} );

	$popover = $el.data( 'popover').tip();
	$popover.css( 'visibility', 'hidden' );
	$el.popover( 'show' );
	$popover.css( 'top', '+=10' ).hide().css( 'visibility', 'visible' ).fadeIn( 'fast' ).animate( { top: '-=15' } );

	$popoverClose = $popover.find( '.is2-popover-close' );
	$popoverClose.on( 'click', function( e ) {
		e.stopPropagation();
		$el.popover( 'hide' ).removeClass( 'is2-record-new' ).off( 'click', arguments.callee );
		window.clearTimeout( closePopupTimeout );
	} );
	$document.on( 'click', function( e ) {
		e.stopPropagation();
		var $el = $( e.target );
		while( $el.length && !$el.hasClass( 'popover' ) ) { 
			$el = $el.parent();
		}
		if( !$el.length ) {
			$popoverClose.click();
			$document.off( 'click', arguments.callee )
		}
	} );
	closePopupTimeout = window.setTimeout( function() {
		$popoverClose.click();
	}, 5000 );
};

IS2.emptyFieldMsg = '<div class="alert alert-error is2-popover-msg is2-patient-empty">Este campo no puede estar vacio</div>';
IS2.lookForEmptyFields = function( $theForm, notShowPopover ) {
	
	var $fields = $theForm.find( 'input:not( [type=hidden] )' ), $field,
		$groupControl,
		isError = false,
		i = 0, l = $fields.length;
	
	for( ; i < l; i++ ) {
		$field = $fields.eq( i );
		// clean any prevous popover setup
		if( !notShowPopover ) {
			$field.popover( 'destroy' );
		}
		$groupControl = IS2.findGroupControl( $field );

		if( !$field.val().trim() ) {
			if( !notShowPopover ) {
				$field.popover( { content: IS2.emptyFieldMsg, html: true, trigger: 'manual' } ).popover( 'show' );
			}
			$groupControl.addClass( 'error' );
			isError = true;
		} else {
			$groupControl.removeClass( 'error' );
		}
	}
	
	return isError;
};

IS2.findGroupControl = function( $groupControl ) {
	while( ( $groupControl = $groupControl.parent() ).length && !$groupControl.hasClass( 'control-group' ) );
	return $groupControl;
};

IS2.showCrudMsg = function( $msg, offset, delay ) {
	
	var height = $msg.css( 'visibility', 'hidden' ).outerHeight(),
		diff = height * ( offset || 1 );
	
	$msg.css( 'visibility', 'visible' ).css( 'top', height * -1 ).show().animate( { top: '+=' + (  diff - 3 ) }, { complete: function() {
		$msg.delay( delay || 2000 ).animate( { top: '-=' + diff } );
	} } );	
};

var BinaryTree = function() {};
BinaryTree.prototype = {
	add: function( key, data ) {
		if( !this.key ) {
			this.key = key;
			// es un array por el tema de los repetidos
			this.data = [ data ];
			this.left = null;
			this.right = null;
			
		} else if( this.key > key ) {
			if( !this.left ) { 
				this.left = new BinaryTree();
			}
			this.left.add( key, data );
			
		} else if( this.key < key ) {
			if( !this.right ) {
				this.right = new BinaryTree();
			}
			this.right.add( key, data );
			
		} else {
			// repetidos cuentan
			this.data.push( data );
		}
	},
	walkAsc: function( callback ) {
		if( this.key ) {
			this.walkAsc.call( this.left, callback );
			while( this.data.length ) {
				callback( this.key, this.data.shift() );
			}
			this.walkAsc.call( this.right, callback );
		}
	},
	walkDesc: function( callback ) {
		if( this.key ) {
			this.walkDesc.call( this.right, callback );
			while( this.data.length ) {
				callback( this.key, this.data.shift() );
			}
			this.walkDesc.call( this.left, callback );
		}
	}
};
