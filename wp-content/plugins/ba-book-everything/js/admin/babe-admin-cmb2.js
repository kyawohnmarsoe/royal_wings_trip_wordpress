(function($){
	"use strict";

    function initCMB2Map(){}

    window.initCMB2Map = initCMB2Map;
////////////////////////////////////

$(document).ready(function(){
    
       add_datepicker('.av_dates input');
       
       add_datepicker('.date_input');
    
    ////////////////////////////////
       
    $('#start_date').datepicker({
        numberOfMonths: 1,
        dateFormat: babe_cmb2_lst.date_format,
        onSelect: function(dateText, inst) {
            //var start_date = new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDay)
            $( "#end_date" ).datepicker('option', 'minDate', dateText);
            $( "#end_date" ).datepicker('option', 'defaultDate', dateText);            
        }
    });
    
    add_datepicker('#end_date');
    
    ////////////////add_datepicker/////////////////
    function add_datepicker(id) {
      $( id ).datepicker({
	    numberOfMonths: 1,
        dateFormat: babe_cmb2_lst.date_format
      });
    }
    
    ////////////////select2///////////////////////
    
    $('.babe_cmb2_select_2').select2();
    
    $('.babe_cmb2_select_2_row select').select2();

    $('[name="billing_address[country]"]').select2();

    $('[name="billing_address[country]"]').on('select2:select', function (e) {
        let country = $(this).val();
        let newOptions = '<option value>' + babe_cmb2_lst.select2select + '</option>';
        let prop_disabled = false;

        $('[name="billing_address[state]"]').val('');

        if ( babe_cmb2_lst.states.hasOwnProperty(country) && babe_cmb2_lst.states[country].length !== 0 ){
            let select2_state_data = babe_cmb2_lst.states[country];
            for(let id in select2_state_data) {
                newOptions += '<option value="'+ id +'">'+ select2_state_data[id] +'</option>';
            }
        } else {
            newOptions = '<option value>---</option>';
            prop_disabled = true;
        }

        $('[name="billing_address[state]"]').select2('destroy').html(newOptions).prop("disabled", prop_disabled).select2();
    });

    $('[name="billing_address[state]"]').select2();

    /////////////////////////

    $('.pw_select2').each(function () {
        $(this).select2({
            allowClear: true
        });
    });

    ////// select2 in cmb-repeatable-group /////////

    // Before a new group row is added, destroy Select2. We'll reinitialise after the row is added
    $('.cmb-repeatable-group').on('cmb2_add_group_row_start', function (event, instance) {
        var $table = $(document.getElementById($(instance).data('selector')));
        var $oldRow = $table.find('.cmb-repeatable-grouping').last();
        $oldRow.find('.pw_select2').each(function () {
            $(this).select2('destroy');
        });
    });

    // When a new group row is added, clear selection and initialise Select2
    $('.cmb-repeatable-group').on('cmb2_add_row', function (event, newRow) {
        $(newRow).find('.pw_select').each(function () {
            $('option:selected', this).removeAttr("selected");
            $(this).select2({
                allowClear: true
            });
        });
        $(newRow).find('.pw_multiselect').each(function () {
            $('option:selected', this).removeAttr("selected");
            $(this).select2_sortable();
        });
        // Reinitialise the field we previously destroyed
        $(newRow).prev().find('.pw_select').each(function () {
            $(this).select2({
                allowClear: true
            });
        });
        // Reinitialise the field we previously destroyed
        $(newRow).prev().find('.pw_multiselect').each(function () {
            $(this).select2_sortable();
        });
    });

    // Before a group row is shifted, destroy Select2. We'll reinitialise after the row shift
    $('.cmb-repeatable-group').on('cmb2_shift_rows_start', function (event, instance) {
        var groupWrap = $(instance).closest('.cmb-repeatable-group');
        groupWrap.find('.pw_select2').each(function () {
            $(this).select2('destroy');
        });
    });

    // When a group row is shifted, reinitialise Select2
    $('.cmb-repeatable-group').on('cmb2_shift_rows_complete', function (event, instance) {
        var groupWrap = $(instance).closest('.cmb-repeatable-group');
        groupWrap.find('.pw_select').each(function () {
            $(this).select2({
                allowClear: true
            });
        });
        groupWrap.find('.pw_multiselect').each(function () {
            $(this).select2_sortable();
        });
    });

    // Before a new repeatable field row is added, destroy Select2. We'll reinitialise after the row is added
    $('.cmb-add-row-button').on('click', function (event) {
        var $table = $(document.getElementById($(event.target).data('selector')));
        var $oldRow = $table.find('.cmb-row').last();
        $oldRow.find('.pw_select2').each(function () {
            $(this).select2('destroy');
        });
    });

    // When a new repeatable field row is added, clear selection and initialise Select2
    $('.cmb-repeat-table').on('cmb2_add_row', function (event, newRow) {
        // Reinitialise the field we previously destroyed
        $(newRow).prev().find('.pw_select').each(function () {
            $('option:selected', this).removeAttr("selected");
            $(this).select2({
                allowClear: true
            });
        });
        // Reinitialise the field we previously destroyed
        $(newRow).prev().find('.pw_multiselect').each(function () {
            $('option:selected', this).removeAttr("selected");
            $(this).select2_sortable();
        });
    });
    
    /////////////////add time/////////////////////
    
    schedule_block_visibility_update();
    
    $('#categories').on('change', function(ev){
        schedule_block_visibility_update();
    });
    
    function schedule_block_visibility_update(){
        
        var cat = $('#categories').val();
        
        if ( $('input[name="schedule_conditions_' + cat + '"]').length > 0 ){
            $('.cmb2-id-schedule-group').css('display', 'block');
        } else {
            $('.cmb2-id-schedule-group').css('display', 'none');
        }
        
    }
    
    $('#schedule_block').on('click', '#add_schedule', function(el){
        el.stopPropagation();
        el.preventDefault();
        var day_num = $('#schedule_form_day').val(),
            hour = parseInt($('#schedule_form_hour').val()),
            minute = parseInt($('#schedule_form_minute').val());
            hour = (hour<10)?"0"+hour:hour;
            minute = (minute<10)?"0"+minute:minute;
            
        var time = hour+':'+minute;  
        $('#schedule_block .schedule_day[data-day-num="'+day_num+'"]').append('<span class="schedule_time">'+time+'<input type="hidden" class="schedule_time_'+day_num+'" name="_schedule_'+day_num+'[]" value="'+time+'"><i class="fa fa-times"></i></span>');
    });
    
    ////////////////delete time/////////////////
    $('#schedule_block').on('click', '.schedule_time i, .schedule_time svg', function(el){
        el.stopPropagation();
        el.preventDefault();
        $(this).parent().remove();
    });
    
    ///////////////save schedule//////////////////
    $('#schedule_block').on('click', '#save_schedule', function(el){
        el.stopPropagation();
        el.preventDefault();
        save_schedule();
    });
    
    //////////////////////////
    
    function save_schedule(){
        
        var obj_id = $('#schedule_block').data('obj-id'),
            start_date = $('#start_date').val(),
            end_date = $('#end_date').val(),
            cyclic_start_every = $('#cyclic_start_every').val(),
            cyclic_av = $('#cyclic_av').val();
            
        var schedule = {};    
            
        $(".schedule_details .schedule_day").each(function(){
            var day_num = $(this).data('day-num');
            schedule[day_num] = $(this).find('.schedule_time input').map(function(){return $(this).val();}).get();
        });
                       
        $('#save_schedule_spinner').html('<span class="spin_f"><i class="fas fa-spinner fa-spin fa-2x"></i></span>');      
        $.ajax({
		url : babe_cmb2_lst.ajax_url,
		type : 'POST',
		data : {
			action : 'save_schedule',
            obj_id : obj_id,
            start_date : start_date,
            end_date: end_date,
            cyclic_start_every: cyclic_start_every,
            cyclic_av: cyclic_av,
            schedule: schedule,
            // check
	        nonce : babe_cmb2_lst.nonce
		},
		success : function( msg ) {
		  $('#save_schedule_spinner').html('');
            ///////////////    
		  }
        });
    }
    
    ///////////////////////////////////////////
    
    $('#coupon_generate_num').on('click', function(el){
        
        generate_coupon_number('#_coupon_number', '#coupon_generate_num_loader', true);
        
    });
    
    //////////////generate_coupon_number////////////
    
    function generate_coupon_number(selector_name, selector_spinner_name, is_val){
        
        $(selector_spinner_name).html('<span class="spin_f"><i class="fas fa-spinner fa-spin fa-2x"></i></span>');
        
        $.ajax({
		url : babe_cmb2_lst.ajax_url,
		type : 'POST',
		data : {
			action : 'generate_coupon_number',
            // check
	        nonce : babe_cmb2_lst.nonce
		},
		success : function( msg ) {
		    if (is_val){
		       $(selector_name).val(msg);
		    } else {
		       $(selector_name).html(msg);
		    }
            $(selector_spinner_name).html('');
		  },
        error: function(){
            $(selector_spinner_name).html('');
        }  
        });    
            
    }
    
    //////////////////Google API///
    
    var inited = {};

    ////////workaround enter press on autocomplete selector////////
    $(function(){
 var keyStop = {
  // 8: ":not(input:text, textarea, input:file, input:password)", // stop backspace = back
   13: "input:text, input:password", // stop enter = submit 
   end: null
 };
 $(document).bind("keydown", function(event){
  var selector = keyStop[event.which];

  if(selector !== undefined && $(event.target).is(selector)) {
      event.preventDefault(); //stop event
     // event.stopPropagation();
  }
  return true;
 });
});
    ///////////////////
    
    $('.cmb2-metabox').on('click', '.get_from_google', function(el){
        el.stopPropagation();
        el.preventDefault();
        var address_block = $(this).parents().eq(1);
        var google_map_get = $(address_block).find('.google_map_get').first();
        
        //$(address_block).find('.address_address input').first().attr('id');
        
        var address_field_id = $(address_block).find('.address_address input').first().attr('id'),
            latitude_field_id = $(address_block).find('.address_latitude input').first().attr('id'),
            longitude_field_id = $(address_block).find('.address_longitude input').first().attr('id');
            
        $(google_map_get).css('display', 'block');    
        
        var map_div = $(address_block).find('.google_map').first();
        var autocomplete = $(address_block).find('.autocomplete').first();
        var button_save = $(address_block).find('.save_from_google').first();
        
        if(inited[address_field_id] != 1){
          init_map(map_div, google_map_get, autocomplete, button_save, address_field_id, latitude_field_id, longitude_field_id);
          inited[address_field_id] = 1;
        }  
    });
    
    /////////////init_map////////////////
    
    function init_map(map_div, google_map_get, autocomplete_selector, button_save, address_field_id, latitude_field_id, longitude_field_id){
        
        var dom_obj = $(map_div)[0]; 
        
        var map = new google.maps.Map(dom_obj, {
          center: {lat: parseFloat(babe_cmb2_lst.start_lat), lng: parseFloat(babe_cmb2_lst.start_lng)},
          mapTypeControl: false,
          panControl: false,
          streetViewControl: false,
          zoom: parseInt(babe_cmb2_lst.start_zoom)
        });
        
        var input = $(autocomplete_selector)[0];

        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push($(button_save)[0]);

        var autocomplete = new google.maps.places.Autocomplete(input, {
              types: []
            });
        autocomplete.bindTo('bounds', map);

        var infowindow = new google.maps.InfoWindow();
        var marker = new google.maps.Marker({
          map: map,
          anchorPoint: new google.maps.Point(0, -29)
        });
        
        var selected_address = '';
        var selected_lat, selected_lng;

        autocomplete.addListener('place_changed', function() {
          infowindow.close();
          marker.setVisible(false);
          var place = autocomplete.getPlace();
          
          // If the place has a geometry, then present it on a map.
          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
          }
          
          selected_lat = place.geometry.location.lat();
          selected_lng = place.geometry.location.lng();
          
          marker.setIcon(/** @type {google.maps.Icon} */({
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
              (place.address_components[2] && place.address_components[2].short_name || ''),
              (place.address_components[4] && place.address_components[4].short_name || ''),
              (place.address_components[6] && place.address_components[6].long_name || '')
            ].join(', ');
            /*selected_address = [
              (place.address_components[0] && place.address_components[0].short_name || ''),
              (place.address_components[1] && place.address_components[1].short_name || ''),
              (place.address_components[2] && place.address_components[2].short_name || ''),
              (place.address_components[4] && place.address_components[4].short_name || '')
            ].join(', ');
            */
            selected_address = $(autocomplete_selector).val();
          }

          infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
          infowindow.open(map, marker);
          
        });
        
          $(button_save).on('click', function(el){
             el.stopPropagation();
             el.preventDefault();
             $('#'+address_field_id).val(selected_address);
             $('#'+latitude_field_id).val(selected_lat);
             $('#'+longitude_field_id).val(selected_lng);
             $(google_map_get).css('display', 'none');
          });      
        
    }
    
    ///////////////////////////////
    
    $( '.cmb2-wrap > .cmb2-metabox' ).on( 'cmb2_add_row', function( evt, row ) {
			$( '.google_map_get', row ).css('display', 'none');
            $('.babe_cmb2_select_2').select2();
            
            $( '.av_dates input', row ).each(function(el){
                
                add_datepicker(this);
                
            });
            //add_datepicker('.av_dates input');
		});
        
    $('.cmb2-wrap').on('cmb2_add_group_row_start', function( evt, row ) {
			$('.babe_cmb2_select_2').select2('destroy');
		});
    
    /////////////////////////////////
    ////////////Settings tabs///////
    
    $('.babe-settings-wrap').on('click', '.nav-tab', function(event){
        
        event.preventDefault();
        
        var targ = $(this).data('target');
        
        $('.nav-tab').removeClass('nav-tab-active');
        $('.tab-target').removeClass('tab-target-active');
        $(this).addClass('nav-tab-active');
        $('#'+targ).addClass('tab-target-active');
        
        var ref = $('.babe-settings-wrap input[name="_wp_http_referer"]').val();
        var new_ref = ref;
        
        var query_string = {};
        
        var url_vars = ref.split("?");
        
        if (url_vars.length > 1){
            
            new_ref = url_vars[0] + '?';
            var url_pairs = url_vars[1].split("&");
            for (var i=0;i<url_pairs.length;i++){
                
                var pair = url_pairs[i].split("=");
                
                if (pair[0] != 'setting_tab'){
                    new_ref = new_ref + url_pairs[i] + '&';
                } 
            }
            
        } else { 
            new_ref = new_ref + '?';  
        }
        
        new_ref = new_ref + 'setting_tab=' + targ;
        
        $('.babe-settings-wrap input[name="_wp_http_referer"]').val(new_ref);
        
    });
    
    ///////////////////

    ///// Related items

    $('.related_collapsible').on('click', function(event){
        $(this).toggleClass("collapsed");
        $(this).next().toggleClass("hide");
    });

    $('.related_all_non').on('click', function(event){
        var check = true;
        $(this).siblings().find('input').each(function(ind, el){
            if ( $(el).is(':checked') ){
                check = false;
            }
        });
        $(this).siblings().find('input').prop('checked', check);
    });

});

})(jQuery);
