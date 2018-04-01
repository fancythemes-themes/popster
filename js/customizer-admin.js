
( function( $ ) {

	var completeVar = Array('100(Ultra Light)', '200 (Light)', '300 (Book)', '400 (Normal)', '500 (Medium)', '600 (Semi Bold)', '700 (Bold)', '800 (Extra Bold)', '900 (Ultra Bold)' ); 

	$.fn.initFontWeight = function( wObj ) {
		$(this).live('change', function() {

			fontVariant = $(this).val();
			arrFontVariant = fontVariant.split('__');
			arrVariant = arrFontVariant[1].split(',');
			currentVal = $( wObj ).val();
			currentValExist = false;
			$( wObj + ' option').remove();
			for( i=0 ; i < arrVariant.length ; i++ ){
				variant = arrVariant[i]; //.replace('italic','');
				if ( currentVal == variant ) currentValExist = true;
				if ( variant.indexOf('italic') < 0 ){
					$( wObj ).append('<option value="'+variant+'">' + completeVar[(variant/100)-1] + '</option>');
				}
			}
			if ( !currentValExist ){
				$( wObj ).val(variant).change();
				$( wObj +' option[value="'+ variant +'"]').prop("selected", "selected").change();
			}else{
				$( wObj ).val(currentVal).change();
				$( wObj + ' option[value="'+ currentVal +'"]').prop("selected", "selected").change();
			}


		} );
	} ;

	$('#customize-control-widget_title_font_family select').initFontWeight('#customize-control-widget_title_font_weight select');
	$('#customize-control-meta_font_family select').initFontWeight('#customize-control-meta_font_weight select');
	$('#customize-control-menu_font_family select').initFontWeight('#customize-control-menu_font_weight select');
	$('#customize-control-heading_font_family select').initFontWeight('#customize-control-heading_font_weight select');

	$('#customize-control-widget_title_font_family select').change();
	$('#customize-control-meta_font_family select').change();
	$('#customize-control-menu_font_family select').change();
	$('#customize-control-heading_font_family select').change();

} ( jQuery ) ); 