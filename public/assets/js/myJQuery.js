$(document).ready(function(){
	$('#add-new-owne-link').click(function(){
		$('.tabs_row,.owner_information_link,.back_btn_row').show();
		$('.owner_main_row').hide();
	});
	$('#add-new-prop-link').click(function(){
		$('.property_tabs_row,.prop_information_link,.prop_back_btn_row').show();
		$('.prop_main_row').hide();
	});
// 	$('#add-new-deals-link').click(function(){
// 		$('.property_tabs_row,.prop_information_link,.prop_back_btn_row').show();
// 		$('.prop_main_row').hide();
// 	});
// 	jQuery('#').click(function(){
//         console.log('dasd');
//     });
	
	$('.tabs_row .customtab li').on('click',function(){
		var get_li_id = $(this).attr('id');
		$('.owner_information_link,.owner_prop_link,.owner_docs_link').hide();
		$('.owner_'+get_li_id).show();
		$('.owner_prop_link').addClass('op');
	});
	$('#back_to_owner').click(function(){
		$('.tabs_row,.owner_information_link,.back_btn_row,.owner_docs_link').hide();
		$('.owner_main_row').show();
	});
	$('#back_to_prop').click(function(){
		$('.property_tabs_row,.prop_information_link,.prop_back_btn_row').hide();
		$('.prop_main_row').show();
	});
	$('.checked_icon').addClass('visible');
	$('.type_left').on('click',function(){
		$('.chk_icon_left').removeClass('visible');
		var get_it = $(this).attr('id');
		$('.'+get_it+'_chk_left').addClass('visible');
	});
	$('.type_right').on('click',function(){
		$('.chk_icon_right').removeClass('visible');
		var get_it = $(this).attr('id');
		$('.'+get_it+'_chk_right').addClass('visible');
	});
	$('.property_tabs_row .customtab li').click(function(){
	$('.property_content').hide();
	var get_tab_id = $(this).attr('id');
	$("."+get_tab_id+'_content').show();
	});
    $('.icon_wrapper').click(function(){
        $(this).toggleClass('rotate');
    });
    $('.available-text-wrapper').addClass('success');
    $('.availability-wrapper p:not(:first):not(:last)').click(function(){
        $('.availability-wrapper p:not(:first):not(:last) span:not(:first)').removeClass('success');
        $(this).find('span:not(:first)').addClass('success');
        $('.input-available_wrapper').hide();
        var get_avail_id = $(this).attr('id');
        $('.input-'+get_avail_id).show();
    });
    $('.checkmark_wrapper').addClass('padding');
    $('.exclusive_chk_box_wrapper').click(function(){
        $('.checkmark_wrapper').toggleClass('padding');
       $('.exclusively_date_wrapper,.checkmark_wrapper img').toggle();
    });
    $('#dtcm').addClass('padding');
    $('.dtcm-content-wrapper').hide();
    $('.property-permit-wrapper .lower_checkmark_wrapper').click(function(){
        $('.lower_checkmark_wrapper img').hide();
        $('.lower_checkmark_wrapper').addClass('padding');
        var id = $(this).attr('id');
        $(this).removeClass('padding');
        $(this).find('img').show();
        $('.rera-content-wrapper,.dtcm-content-wrapper').hide();
        $('.'+id+'-content-wrapper').show();
    });
    $('.manual_tab_content').hide();
    $('.automatic_tab,.manual_tab').click(function(){
        $('.automatic_tab_content,.manual_tab_content').hide();
        var cls = $(this).attr('class');
        $('.'+cls+'_content').show();
    });
    // $('.rented-wrapper').prop('disabled', true);
});
function initMap() {
    var map = new google.maps.Map(document.getElementById('map-canvas'), {
      center: {lat: -33.8688, lng: 151.2195},
      zoom: 13
    });
    var input = document.getElementById('location_input');
    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);
    var infowindow = new google.maps.InfoWindow();
    var marker = new google.maps.Marker({
        map: map,
        anchorPoint: new google.maps.Point(0, -29)
    });

    autocomplete.addListener('place_changed', function() {
        infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            window.alert("Autocomplete's returned place contains no geometry");
            return;
        }
 
        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }
        marker.setIcon(({
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(35, 35)
        }));
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);
   
        var address = '';
        if (place.address_components) {
            address = [
              (place.address_components[0] && place.address_components[0].short_name || ''),
              (place.address_components[1] && place.address_components[1].short_name || ''),
              (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
        }
   
        infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
        infowindow.open(map, marker);
     
        
    });
}