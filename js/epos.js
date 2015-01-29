// Copyright (C) 2011 eduxx GmbH Ludwigsburg. All rights reserved.
// $Revision: 1348 $ $Date: 2012-02-15 14:08:04 +0100 (Mi, 15 Feb 2012) $

if (!Array.prototype.indexOf) {
	Array.prototype.indexOf = function(elt /*, from*/) {
		var len = this.length;

		var from = Number(arguments[1]) || 0;
		from = (from < 0) ? Math.ceil(from) : Math.floor(from);
		if (from < 0)
			from += len;

		for (; from < len; from++) {
			if (from in this && this[from] === elt)
				return from;
		}
		return -1;
	};
}

$(document).ready(gf_onready);
function gf_onready() {
	$(document.documentElement).addClass('JS_ENABLED');
	if(!window.prettyphoto_settings)
		prettyphoto_settings = new Object();
	prettyphoto_settings.changepicturecallback = gf_gallery_changepicturecallback;
	$("a[rel^='prettyPhoto']").prettyPhoto(prettyphoto_settings);
	gf_btn_autopreload_always();
	if(navigator.userAgent.indexOf('Gecko') > 0) {
		$("input[type=file]").each(gf_gecko_fix_input_file_size);
	}

	var lo_encrypted_forms = $('.encrypted');
	if(lo_encrypted_forms.length > 0) {
		$(":input").removeAttr("disabled");
		lo_encrypted_forms.jCryption({getKeysURL: gf_get_base_url() + "common/jcr_key.php"});
	}

	$("a[href^='nospam:']").each(function() {
		var lo_this = $(this);
		var la_href = lo_this.attr('href').split(':');
		var la_data = window[la_href[1]];
		if(la_data instanceof Array) {
			var ls_mail = la_data[0] + '@' + la_data[1];
			lo_this.attr('href', 'mailto:' + ls_mail).text(ls_mail);
		}
	});

	var ll_gog_conv = 0;
	if(window.mailto_gog_conversion instanceof Array) {
		$("a[href^='mailto:']").each(function() {
			ll_gog_conv++;
			var lo_this = $(this);
			lo_this.bind('click', {params: window.mailto_gog_conversion, url: lo_this.attr('href'), iscall: false}, gf_gog_rep_conv);
		});
	}
	if(window.tel_gog_conversion instanceof Array) {
		$("a[href^='tel:']").each(function() {
			ll_gog_conv++;
			var lo_this = $(this);
			lo_this.bind('click', {params: window.tel_gog_conversion, url: lo_this.attr('href'), iscall: true}, gf_gog_rep_conv);
		});
	}
	if(ll_gog_conv) {
		$.getScript('http://www.googleadservices.com/pagead/conversion_async.js');
	}

	$("div[data-animation]").each(gf_start_animation);
	$('.js_msg_item').slideDown(500);
	if(typeof window.gf_page_loaded == 'function') {
		gf_page_loaded();
	}
}

function gf_gecko_fix_input_file_size() {
	var ll_desired_width = $(this)[0].clientWidth;
	var ll_last_width = 99999999;
	$(this).addClass('tmp_width_inherit');
	var ll_width = $(this)[0].clientWidth;
	while(ll_desired_width < ll_width && ll_width < ll_last_width) {
		ll_last_width = ll_width;
		$(this)[0].size--;
		ll_width = $(this)[0].clientWidth;
	}
	$(this).removeClass('tmp_width_inherit');
}

function gf_gog_rep_conv(po_param) {
	window.google_conversion_id = po_param.data.params[0];
	window.google_conversion_label = po_param.data.params[1];
	window.google_conversion_value = po_param.data.params[2];
	window.google_conversion_format = "3";
	window.google_is_call = po_param.data.iscall;
	var ls_url = po_param.data.url;
	var lo_opt = new Object();
	lo_opt.onload_callback = function() {
		if (typeof(ls_url) != 'undefined') {
			window.location = ls_url;
		}
	}
	var lf_conv_handler = window['google_trackConversion'];
	if (typeof(lf_conv_handler) == 'function') {
		lf_conv_handler(lo_opt);
	}
}

var go_anim_fn;
function gf_start_animation() {
	if($(this).children().length > 1) {
		if(!go_anim_fn) {
			function gf_setup_custom_animation(po_param, po_current) {
				var lo_css = {};
				var la_css_defs = po_param.custom.replace(/@WIDTH@/g, po_param.width).replace(/@WIDTH2@/g, po_param.width2).replace(/@HEIGHT@/g, po_param.height).replace(/@HEIGHT2@/g, po_param.height2).split('|');
				for(var i=0; i<la_css_defs.length; i++) {
					var la_def = la_css_defs[i].split('/');
					var ls_name = la_def.shift();
					lo_css[ls_name] = la_def;
				}
				this.setup_generic(po_param, lo_css);
			}

			go_anim_fn = {
				anim01: {
					setup: gf_setup_custom_animation,
					setup_generic: function(po_param, po_css) {
						po_param.run_fn = 'anim01';
						po_param.css = {
							next_pre: {'z-index': 1, display: ''},
							next_anim: {},
							next_post: {'z-index': ''},
							cur_post: {display: 'none'}
						}
						for(var ls_name in po_css) {
							var la_def = po_css[ls_name];
							po_param.css.next_pre[ls_name] = la_def[0];
							po_param.css.next_anim[ls_name] = la_def[1];
							po_param.css.next_post[ls_name] = la_def[2];
						}
					},
					run: function(po_param, po_current, lo_next) {	// lo_next ist in Parameterliste enthalten, damit die Variable in animate_callback und waitandrun korrekt weitergegeben wird
						lo_next = gf_anim_get_next(po_current);
						lo_next.css(po_param.css.next_pre);
						lo_next.animate(po_param.css.next_anim, po_param.anim_duration, po_param.easing, function() {
							po_current.css(po_param.css.cur_post);
							lo_next.css(po_param.css.next_post);
							gf_anim_waitandrun(po_param, lo_next);
						});
					}
				},
				anim02: {
					setup: gf_setup_custom_animation,
					setup_generic: function(po_param, po_css) {
						po_param.run_fn = 'anim02';
						po_param.css = {
							next_pre: {display: ''},
							cur_pre: {'z-index': 1},
							cur_anim: {},
							cur_post: {display: 'none', 'z-index': ''}
						}
						for(var ls_name in po_css) {
							var la_def = po_css[ls_name];
							po_param.css.cur_pre[ls_name] = la_def[0];
							po_param.css.cur_anim[ls_name] = la_def[1];
							po_param.css.cur_post[ls_name] = la_def[2];
						}
					},
					run: function(po_param, po_current, lo_next) {
						lo_next = gf_anim_get_next(po_current);
						po_current.css(po_param.css.cur_pre);
						lo_next.css(po_param.css.next_pre);
						po_current.animate(po_param.css.cur_anim, po_param.anim_duration, po_param.easing, function() {
							po_current.css(po_param.css.cur_post);
							gf_anim_waitandrun(po_param, lo_next);
						});
					}
				},
				anim03: {
					setup: gf_setup_custom_animation,
					setup_generic: function(po_param, po_css) {
						po_param.run_fn = 'anim03';
						po_param.css = {
							cur_pre: {},
							cur_anim: {},
							cur_post: {display: 'none'},
							next_pre: {display: ''},
							next_anim: {},
							next_post: {}
						}
						for(var ls_name in po_css) {
							var la_def = po_css[ls_name];
							po_param.css.cur_pre[ls_name] = la_def[0];
							po_param.css.cur_anim[ls_name] = la_def[1];
							po_param.css.cur_post[ls_name] = la_def[2];
							po_param.css.next_pre[ls_name] = la_def[3];
							po_param.css.next_anim[ls_name] = la_def[4];
							po_param.css.next_post[ls_name] = la_def[5];
						}
					},
					run: function(po_param, po_current, lo_next) {
						lo_next = gf_anim_get_next(po_current);
						lo_next.css(po_param.css.next_pre);
						po_current.css(po_param.css.cur_pre)
						.animate(po_param.css.cur_anim, po_param.anim_duration, po_param.easing);
						lo_next.animate(po_param.css.next_anim, po_param.anim_duration, po_param.easing, function() {
							po_current.css(po_param.css.cur_post);
							lo_next.css(po_param.css.next_post);
							gf_anim_waitandrun(po_param, lo_next);
						});
					}
				},

				rand: {
					setup: function(po_param, po_current) {
						if(po_param.custom) {
							po_param.custom = po_param.custom.split('|');
						} else {
							po_param.custom = ['slidefromleft', 'slidefromright', 'slidefromtop', 'slidefrombottom', 
							'slidetoleft', 'slidetoright', 'slidetotop', 'slidetobottom', 
							'streamfromleft', 'streamfromright', 'streamfromtop', 'streamfrombottom', 'fade'];
						}
					},
					prep: function(po_param, po_current) {
						po_param.last_setup_fn = po_param.custom[Math.floor(Math.random() * po_param.custom.length)];
						go_anim_fn[po_param.last_setup_fn].setup(po_param, po_current);
					}
				},
				seq: {
					setup: function(po_param, po_current) {
						if(po_param.custom) {
							po_param.custom = po_param.custom.split('|');
						} else {
							po_param.custom = ['streamfromright', 'streamfrombottom', 'streamfromleft', 'streamfromtop'];
						}
						po_param.pos = 0;
					},
					prep: function(po_param, po_current) {
						po_param.last_setup_fn = po_param.custom[po_param.pos++];
						if(po_param.pos == po_param.custom.length)
							po_param.pos = 0;
						go_anim_fn[po_param.last_setup_fn].setup(po_param, po_current);
					}
				},
				replace: {
					run: function(po_param, po_current) {
						lo_next = gf_anim_get_next(po_current);
						lo_next.css({display: ''});
						po_current.css({display: 'none'});
						gf_anim_waitandrun(po_param, lo_next);
					}
				}
			}
			var lo_css = {
				slidefromleft: ['anim01', "{left: ['-'+po_param.width, '+='+po_param.width, '']}"],
				slidefromright: ['anim01', "{left: [po_param.width, '-='+po_param.width, '']}"],
				slidefromtop: ['anim01', "{top: ['-'+po_param.height, '+='+po_param.height, '']}"],
				slidefrombottom: ['anim01', "{top: [po_param.height, '-='+po_param.height, '']}"],
				slidetoleft: ['anim02', "{left: [0, '-='+po_param.width, '']}"],
				slidetoright: ['anim02', "{left: [0, '+='+po_param.width, '']}"],
				slidetotop: ['anim02', "{top: [0, '-='+po_param.height, '']}"],
				slidetobottom: ['anim02', "{top: [0, '+='+po_param.height, '']}"],
				streamfromleft: ['anim03', "{left: [0, '+='+po_param.width, '', '-'+po_param.width, '+='+po_param.width, '']}"],
				streamfromright: ['anim03', "{left: [0, '-='+po_param.width, '', po_param.width, '-='+po_param.width, '']}"],
				streamfromtop: ['anim03', "{top: [0, '+='+po_param.height, '', '-'+po_param.height, '+='+po_param.height, '']}"],
				streamfrombottom: ['anim03', "{top: [0, '-='+po_param.height, '', po_param.height, '-='+po_param.height, '']}"],
				fade: ['anim01', "{opacity: [0.0, 1.0, '']}"],
				fade_transp: ['anim03', "{opacity: [1.0, 0.0, '', 0.0, 1.0, '']}"]
			};
			var ls_code = '';
			for(var ls_name in lo_css) {
				var la_def = lo_css[ls_name];
				ls_code += "go_anim_fn." + ls_name + " = {setup: function(po_param, po_current) { go_anim_fn." + la_def[0] + ".setup_generic(po_param, " + la_def[1] + "); po_param.last_setup_fn = '" + ls_name + "' }};\n";
			}
			eval(ls_code);
		}

		var la_param = this.getAttribute('data-animation').split(',');
		var lo_param = {
			anim_duration: 2000,
			anim_pause: 5000,
			easing: 'swing'
		}
	
		var ls_fn = la_param[0];
		if(go_anim_fn[ls_fn]) {
			var ll_i = parseInt(la_param[1]);
			if(!isNaN(ll_i))
				lo_param.anim_duration = ll_i;
			ll_i = parseInt(la_param[2]);
			if(!isNaN(ll_i))
				lo_param.anim_pause = ll_i;
			if(la_param[3])
				lo_param.easing = la_param[3];
			if(la_param[4])
				lo_param.custom = la_param[4];
			var ll_tmp = $(this).width();
			lo_param.width = ll_tmp + 'px';
			lo_param.width2 = Math.floor(ll_tmp / 2) + 'px';
			ll_tmp = $(this).height();
			lo_param.height = ll_tmp + 'px';
			lo_param.height2 = Math.floor(ll_tmp / 2) + 'px';
			var lo_next = $(this).children(':first');
			if(go_anim_fn[ls_fn].prep)
				lo_param.prep_fn = ls_fn;
			if(go_anim_fn[ls_fn].run)
				lo_param.run_fn = ls_fn;
			if(go_anim_fn[ls_fn].setup) {
				go_anim_fn[ls_fn].setup(lo_param, lo_next);
			}
			gf_anim_waitandrun(lo_param, lo_next);
		}
	}

	function gf_anim_waitandrun(po_param, po_next) {
		if(po_param.prep_fn) {
			go_anim_fn[po_param.prep_fn].prep(po_param, po_next);
		}
		if(po_param.anim_pause) {
			setTimeout(function() {
				go_anim_fn[po_param.run_fn].run(po_param, po_next);
			}, po_param.anim_pause);
		} else {
			go_anim_fn[po_param.run_fn].run(po_param, po_next);
		}
	}
	function gf_anim_get_next(po_current) {
		lo_next = po_current.next();
		if(lo_next.length)
			return lo_next;
		return po_current.parent().children(':first');
	}
}
function gf_open(ps_url) {
	var w = window.open(ps_url, 'Zweitfenster', 'width=300,height=400,left=100,top=200');
	if(w)
		w.focus();
	else
		gf_notify_popup_blocker();
}

function gf_open2(ps_url, ps_window, ps_param) {
	w = window.open(ps_url, ps_window, ps_param);
	if(w)
		w.focus();
	else
		gf_notify_popup_blocker();
}

function gf_notify_popup_blocker() {
	alert('Bitte deaktivieren Sie Ihren Popup-Blocker, um diese Funktion nutzen zu können.');
}

var gb_gf_gallery_disableiframescrolling = false;
function gf_open_quiz(ps_param) {
	Q = window.open(gf_get_base_url() + "quiz.php" + ps_param, "stdw_quiz", "width=640,height=480");
	if(Q)
		Q.focus();
	else
		gf_notify_popup_blocker();
//	gb_gf_gallery_disableiframescrolling = true;
//	$.prettyPhoto.open(gf_get_base_url() + "quiz.php" + ps_param + "#iframe&width=640&height=480", '', '');
}
function gf_gallery_changepicturecallback() {
	if(gb_gf_gallery_disableiframescrolling) {
		gb_gf_gallery_disableiframescrolling = false;
		$('#pp_full_res > iframe')[0].scrolling='no';
	}
}
function gf_video_fallback(po_video_tag) {
	$(po_video_tag).after($(po_video_tag).children()).remove();
}

function gf_editmode_mouseover(po_btn) {
	lo_node = po_btn.nextSibling;
	if(lo_node && lo_node.nodeType == 8) {	// Comment - process all following feeditems
		lo_node = lo_node.nextSibling;
		while(lo_node && $(lo_node).hasClass('feeditem')) {
			$(lo_node).addClass('em_hover');
			lo_node = lo_node.nextSibling;
		}
	} else {
		$(po_btn).next().addClass('em_hover');
	}
}
function gf_editmode_mouseout(po_btn) {
	lo_node = po_btn.nextSibling;
	if(lo_node && lo_node.nodeType == 8) {	// Comment - process all following feeditems
		lo_node = lo_node.nextSibling;
		while(lo_node && $(lo_node).hasClass('feeditem')) {
			$(lo_node).removeClass('em_hover');
			lo_node = lo_node.nextSibling;
		}
	} else {
		$(po_btn).next().removeClass('em_hover');
	}
}
function gf_editmode_mouseover2() {
	$('.feeditemcol').addClass('em_hover');
}
function gf_editmode_mouseout2() {
	$('.feeditemcol').removeClass('em_hover');
}

function gf_btn_autopreload() {
	// wird nicht mehr benoetigt
}
function gf_btn_autopreload_always() {
	if(document.images) {
		var la_preloaded_images = new Array();
		for (var i=0; i<document.images.length; i++){
			var ls_tmp = gf_btn_get_state(document.images[i].src, '04');
			if(ls_tmp) {
				document.images[i].onmouseout = function() { this.src=gf_btn_get_state(this.src, '00'); return true; };
				document.images[i].onmouseover = function() { this.src=gf_btn_get_state(this.src, '04'); return true; };
				document.images[i].onmouseup = function() { this.src=gf_btn_get_state(this.src, '04'); return true; };
				document.images[i].onmousedown = function() { this.src=gf_btn_get_state(this.src, '01'); return true; };
				var i04 = new Image();
				i04.src = ls_tmp;
				var i01 = new Image();
				i01.src = gf_btn_get_state(ls_tmp, '01');
				la_preloaded_images.push(i01, i04);
			}
		}
	}
}

function gf_btn_get_state(ps_filename, ps_state) {
	var lre_regexp = /^(.*_rollover_)(\d\d)(\.\w+)$/;
	var la_result = lre_regexp.exec(ps_filename);
	if(!la_result)
		return false;
	if(la_result[2] == '08')
		return false;
	return la_result[1] + ps_state + la_result[3];
}

function gf_css_format_images() {
	for (var i = 0; i < document.images.length; ++i) {
		var ll_width = document.images[i].width;
		var ll_height = document.images[i].height;
		var ld_aspect_ratio = ll_width / ll_height;
		
		var ll_max_width = document.images[i].parentNode.offsetWidth;
		var ll_max_height = document.images[i].parentNode.offsetHeight;
		if(ll_max_width > 300) {
			ll_max_width = 300;
		}
		if(ll_width > ll_max_width) {
			document.images[i].width = ll_max_width;
			document.images[i].height = ll_max_width / ld_aspect_ratio;
		}
	}
}

function gf_css_img_format(po_image, pb_width) {
//	alert(po_image.src);
	var ll_width = po_image.width;
	var ll_height = po_image.height;
	var ld_aspect_ratio = ll_width / ll_height;
	
	var ll_max_width = po_image.parentNode.offsetWidth;
	var ll_max_height = po_image.parentNode.offsetHeight;
	if(ll_max_width > 300) {
		ll_max_width = 300;
	}
	if(ll_width > ll_max_width) {
		ll_width = ll_max_width;
		ll_height = ll_width / ld_aspect_ratio;
	}
/*	if(ll_height > ll_max_height) {
		ll_height = ll_max_height;
		ll_width = ll_height * ld_aspect_ratio;
	}*/
	if(pb_width) {
		return parseInt(ll_width) + 'px';
	} else {
		return parseInt(ll_height) + 'px';
	}
}



function print_r(pa_object, ps_padding) {
	if(ps_padding.length > 1)
		return ps_padding + "[...]\n";
	var ls_result = '';  
	for (var ls_value in pa_object)
		if (pa_object[ls_value] != null) {
			if (typeof pa_object[ls_value] == 'object')
				ls_result = ls_result + ps_padding + ls_value + "\n" + print_r(pa_object[ls_value], ps_padding + "\t");
			else if (typeof pa_object[ls_value] != 'undefined')
				ls_result = ls_result + ps_padding + ls_value + ":\t" + pa_object[ls_value] + "\n";
		}
	return ls_result;
}

function gf_get_cookie(ps_name) {
	var la_all_cookies = document.cookie.split(';');
	for (var i=0; i<la_all_cookies.length; i++) {
		var la_temp_cookie = la_all_cookies[i].split('=');
		if (la_temp_cookie[0].replace(/^\s+|\s+$/g, '') == ps_name) {
			if (la_temp_cookie.length > 1) {
				return unescape(la_temp_cookie[1].replace(/^\s+|\s+$/g, ''));
			}
			return '';
		}
	}
	return null;
}

function gf_trim(ps_string) {
	while (ps_string.substring(0,1) == ' ') {
		ps_string = ps_string.substring(1, ps_string.length);
	}
	while (ps_string.substring(ps_string.length-1, ps_string.length) == ' ') {
		ps_string = ps_string.substring(0,ps_string.length-1);
	}
	return ps_string;
}

function gf_txt(ps_text) {
	switch(gs_spc) {
	case 'en':
		switch(ps_text) {
		case 'Medieninformationen':	return 'media information';
		}
		break;
	}
	return ps_text;
}

function gf_highlight(po_field, ps_action, ps_css_class, ps_checkbox_name) {
	var ls_current_class;
	var ls_new_class;

	ls_current_class = po_field.className;

	switch(ps_action) {
		case 'over':
			ls_new_class = ps_css_class + '_over';
			break;
		case 'out':
			if(po_field.onmouseleave)
				return;
		case 'leave':
			if(document.getElementsByName(ps_checkbox_name)[0].checked) {
				ls_new_class = ps_css_class + '_sel';
			} else {
				ls_new_class = ps_css_class;
			}
			break;
		case 'click':
			if(document.getElementsByName(ps_checkbox_name)[0].checked) {
				ls_new_class = ps_css_class;
				document.getElementsByName(ps_checkbox_name)[0].checked = false;
			} else {
				ls_new_class = ps_css_class + '_sel';
				document.getElementsByName(ps_checkbox_name)[0].checked = true;
			}
			break;
		case 'check':
			ls_new_class = ps_css_class + '_sel';
			document.getElementsByName(ps_checkbox_name)[0].checked = true;
			break;
		case 'uncheck':
			ls_new_class = ps_css_class;
			document.getElementsByName(ps_checkbox_name)[0].checked = false;
			break;
	}

	if(ls_new_class) {
		po_field.className = ls_new_class;
	}
	return false;
}

function gf_highlight_by_name(ps_field_name, ps_action) {
	var lo_rowelem = document.getElementById(ps_field_name);
	if(lo_rowelem) {
		var ls_css_class = lo_rowelem.className.slice(0, 4);
		gf_highlight(lo_rowelem, ps_action, ls_css_class, 'item[' + ps_field_name + ']');
	}
}

function gf_checkbox_foreach(ps_highlight_action) {
	if(document.forms.chooseform) {
		for (var i=0; i<document.forms.chooseform.elements.length; i++) {
			var lo_elem = document.forms.chooseform.elements[i];
			if(lo_elem.type == 'checkbox') {
				var ls_field_name = lo_elem.name.replace(/(item\[|\])/g, '');
				gf_highlight_by_name(ls_field_name, ps_highlight_action);
			}
		}
	}
}
function gf_select_all() {
	gf_checkbox_foreach('check');
}
function gf_select_none() {
	gf_checkbox_foreach('uncheck');
}

function gf_help(ps_context) {
	var ls_url = "help/" + ps_context + ".htm";
	var lw_help = window.open(ls_url, "_blank", "width=640,height=480");
	lw_help.focus();
}

function gf_nav(ps_url) {
	location.href = ps_url;
}

var go_push_buttons = new Object();
var go_push_button_cache = new Object();

function gf_init_push_buttons(ps_group, ps_typ, ps_button_type, ps_field, ps_display_buttons) {
	go_push_buttons[ps_group] = new Object();
	go_push_buttons[ps_group].field = document.getElementsByName(ps_field)[0];
	go_push_buttons[ps_group].display_buttons = document.getElementById(ps_display_buttons);
	go_push_buttons[ps_group].button_type = ps_button_type;
	go_push_buttons[ps_group].states = new Object();
	go_push_buttons[ps_group].visible_buttons = new Object();
	
	if(!go_push_button_cache[ps_button_type])
		go_push_button_cache[ps_button_type] = new Object();
	
	var la_values = go_push_buttons[ps_group].field.value.split(',');
	for(var i=0; i<la_values.length; i++) {
		ls_btn = la_values[i];
		if(ls_btn.length)
			go_push_buttons[ps_group].states[ls_btn] = 10;
	}
	gf_load_push_buttons(ps_group, ps_typ);
}

function gf_load_push_buttons(ps_group, ps_typ) {
	var ls_html = '';
	var ls_img_url;
	var ls_param = go_esy_auswahl.MMTYP.n2p[ps_typ];
	if(!ls_param)
		ls_param = '';
	if(!go_push_buttons[ps_group])
		return;
	if(ls_param != '')
		go_push_buttons[ps_group].visible_buttons = ls_param.split(',');
	else
		go_push_buttons[ps_group].visible_buttons = new Array();

	for(var i=0; i<go_push_buttons[ps_group].visible_buttons.length; i++) {
		ls_btn = go_push_buttons[ps_group].visible_buttons[i];
		ls_img_url = 'bilder/pushbtn_' + go_push_buttons[ps_group].button_type + '_' + ls_btn + '_00.jpg';
		if(!go_push_button_cache[go_push_buttons[ps_group].button_type][ls_btn])
			go_push_button_cache[go_push_buttons[ps_group].button_type][ls_btn] = gf_new_button(ls_img_url, '04,10,14');
		
		la_btn = go_push_button_cache[go_push_buttons[ps_group].button_type][ls_btn];
		ls_descr = go_esy_auswahl.MVTYP.n2b[ls_btn];
		ls_html += '<img id="btn_' + ps_group + '_' + ls_btn + '" src="' + ls_img_url + '" onmouseover="gf_push_button_action(\'' + ps_group + '\',this,\'' + ls_btn + '\',\'hover\')" onclick="gf_push_button_action(\'' + ps_group + '\',this,\'' + ls_btn + '\',\'click\')" onmouseout="gf_push_button_action(\'' + ps_group + '\',this,\'' + ls_btn + '\',\'\')" title="' + ls_descr + '"> ';
	}

	go_push_buttons[ps_group].display_buttons.innerHTML = ls_html;
	for(var i=0; i<go_push_buttons[ps_group].visible_buttons.length; i++)
		gf_push_button_action(ps_group, document.getElementById('btn_' + ps_group + '_' + go_push_buttons[ps_group].visible_buttons[i]), go_push_buttons[ps_group].visible_buttons[i], '');
}

function gf_new_button(ps_first_img, ps_button_states) {
	var la_button_states = ps_button_states.split(',');
	la_button = new Array();
	la_button[0] = new Image();
	la_button[0].src = ps_first_img;
	for(var i=0; i<la_button_states.length; i++) {
		ll_state = parseInt(la_button_states[i]);
		la_button[ll_state] = new Image();
		la_button[ll_state].src = ps_first_img.replace(/00/, la_button_states[i]);
	}
	return la_button;
}

function gf_push_button_action(ps_group, po_img_tag, ps_btn_id, ps_action) {
	var ll_button_state = 0;
	switch(ps_action) {
	case 'click':
		if(go_push_buttons[ps_group].states[ps_btn_id])
			go_push_buttons[ps_group].states[ps_btn_id] = 0;
		else
			go_push_buttons[ps_group].states[ps_btn_id] = 10;
		break;
	case 'hover':
		ll_button_state = 4;
		break;
	}
	if(!isNaN(go_push_buttons[ps_group].states[ps_btn_id]))
		ll_button_state += go_push_buttons[ps_group].states[ps_btn_id];
  	po_img_tag.src = go_push_button_cache[go_push_buttons[ps_group].button_type][ps_btn_id][ll_button_state].src;
  	go_push_buttons[ps_group].field.value = gf_get_pressed_push_buttons(ps_group);
}

function gf_get_pressed_push_buttons(ps_group) {
	var ls_result = ',';
	for(var i=0; i<go_push_buttons[ps_group].visible_buttons.length; i++)
		if(go_push_buttons[ps_group].states[go_push_buttons[ps_group].visible_buttons[i]])
			ls_result += go_push_buttons[ps_group].visible_buttons[i] + ',';
	if(ls_result == ',')
		return '';
	return ls_result;
}

var gs_base_url = '';
function gf_get_base_url() {
	if(gs_base_url != '')
		return gs_base_url;
	$.each($('script'), function(pl_i, po_script) {
		if(po_script.src.match(/^(.*\/)common\//)) {
			gs_base_url = RegExp.$1;
			return false;
		}
	});
	return gs_base_url;
}

function gf_get_permalink() {
	var ls_url = $('meta[property="og:url"]').attr('content');
	if(!ls_url)
		ls_url = location.href;
	return ls_url;
}

function gf_get_tweet_url(ps_hashtags, ps_related) {
	var ls_url = 'http://twitter.com/intent/tweet?url=' + encodeURIComponent(gf_get_permalink());
	var ls_text = document.title;
	var la_hashtags = new Array();
	if(ps_hashtags && ps_hashtags != '') {
		la_hashtags = ps_hashtags.replace(/-/g, '').split(/,\s*/);
	}
	var ll_hashtags = 0;
	var la_hashtags_new = new Array();
	for(var i=0; i<la_hashtags.length; i++) {
		var lo_regexp = new RegExp('(^|\\s)(' + la_hashtags[i].replace(/([\^\$\.\*\+\?\=\!\:\|\\\/\(\)\[\]\{\}])/g,'\\$1') + ')(\s|[-.,:;_+!"\'?\\/]|$)', 'i');
		var ll_found = ls_text.search(lo_regexp);
		if(ll_found >= 0) {
			ls_text = ls_text.replace(lo_regexp, '$1#$2$3');
			ll_hashtags++;
		} else {
			la_hashtags_new.push(la_hashtags[i]);
		}
	}
	if(ps_related != '') {
		ls_one_related = ps_related.match(/^[^,:]*/);
		if(ls_one_related != '') {
			ls_text = '@' + ls_one_related + ' ' + ls_text;
		}
	}
	ls_url += '&text=' + encodeURIComponent(ls_text);
	if(!ll_hashtags && la_hashtags_new.length) {
		if(la_hashtags_new.length > 2) {
			ls_url += '&hashtags=' + encodeURIComponent(la_hashtags_new[0]);
		} else {
			ls_url += '&hashtags=' + encodeURIComponent(la_hashtags_new.join(','));
		}
	}
	if(ps_related != '') {
		ls_url += '&related=' + ps_related;
	}
	return ls_url;
}

function gf_tweet() {
	var la_twitter_accounts = new Array();
	var la_twitter_links = $('a[href*="twitter.com"]');
	for(var i=0; i<la_twitter_links.length; i++) {
		if(la_twitter_links[i].getAttribute('href').match(/^https?:\/\/twitter.com\/([^\/]+)$/)) {
			if(la_twitter_accounts.indexOf(RegExp.$1) == -1)
				la_twitter_accounts.push(RegExp.$1);
		}
	}
	gf_open2(gf_get_tweet_url($('meta[name="keywords"]').attr('content'), la_twitter_accounts.join(',')), 'tweet', 'width=360,height=500,status=0,toolbar=0');

	if(_gaq)
		_gaq.push(['_trackSocial', 'twitter', 'tweet', gf_get_permalink()]);

};

function gf_fb_share() {
	var ls_url = gf_get_permalink();
	gf_open2('http://www.facebook.com/sharer.php?u='+encodeURIComponent(ls_url)+'&t='+encodeURIComponent(document.title), 'sharer', 'width=626,height=436,status=0,toolbar=0');

	if(_gaq)
		_gaq.push(['_trackSocial', 'facebook', 'send', ls_url]);
}

function gf_remote_call(ps_data, ps_gateway) {
	$('body').addClass('processing');
	$('a').addClass('processing');
	var lo_settings = {
		type:'POST',
		url:gf_get_base_url() + 'common/json.php',
		data:ps_data,
		dataType:'jsonp',
		success:gf_remote_call_success,
		error:gf_remote_call_error,
		complete:gf_remote_call_complete
	}
	if(ps_gateway) {
		lo_settings.type = 'GET';
		lo_settings.url = ps_gateway;
	}
	if(ps_data.match(/a=[a-z_]*testlauf/)) {
		lo_settings.async = false;
	}
	$.ajax(lo_settings);
	void(0);
}
function gf_remote_call_success(po_data) {
	$.each(po_data, function(ll_i, ps_item) {
		eval(ps_item);
	});
}
function gf_remote_call_error(po_xhr, ps_status, po_error) {
	if(console)
		console.error('remote call ' + ps_status + ': ' + print_r(po_error, ''));
}
function gf_remote_call_complete(po_xhr, ps_status) {
	$('body').removeClass('processing');
	$('a').removeClass('processing');
}

function xf_open_gallery(ps_id, ps_gateway) {
/*	if(!$.prettyPhoto.open) {
		$('head').append('<link rel="stylesheet" href="' + gf_get_base_url() + 'common/prettyPhoto/prettyPhoto.css" type="text/css" />').prettyPhoto();
	}
*/
	gf_remote_call('fkt=xf_open_gallery&id=' + ps_id, ps_gateway);
}

function gf_enable_galleries() {
/*	if(!$.prettyPhoto.open) {
		$('head').append('<link rel="stylesheet" href="' + gf_get_base_url() + 'common/prettyPhoto/prettyPhoto.css" type="text/css" />');
		$("a[rel^='prettyPhoto']").prettyPhoto();
	}
*/
}

var ga_tooltip = new Array();
var gs_tooltip_show = '';
var gb_tooltip_init = false;
var go_tooltip_obj;
var go_tooltip_pos = {pageX:0, pageY:0};
var gs_tooltip_typ = '';

var ga_val_invalid_fields = new Array();
var gb_validate_form = false;
var gb_enable_messages = false;
var gl_keypress_id = 0;

function gf_show_tooltip(po_obj, ps_typ, ps_info, ps_title) {
	if(po_obj) {
		go_tooltip_obj = po_obj;
	}
	if(!gb_tooltip_init) {
		gb_tooltip_init = true;
		$('body').append('<div id="ee_tooltip" style="position: absolute; z-index: 1000; background-image: none; left: -10000px; top: -10000px;"></div>');
	}
	if(ps_typ == 'EMM') {
		ps_title = gf_txt('Medieninformationen');
	} else if(!ps_title) {
		ps_title = gf_txt('Info');
	}
	gs_tooltip_typ = ps_typ;
	$('#ee_tooltip').css({left:-10000, top:-10000}).html('<table class="tt_bg" cellspacing="1" cellpadding="0"><tr><td style="font-weight:bold; color:#ffffff; padding-left: 3px;">' + ps_title + '</td></tr><tr><td class="tt_txt" valign="top">' + ps_info + '</td></tr></table>').show();
	$(go_tooltip_obj).mousemove(gf_tooltip_mousemove).mouseout(function(e){
		gs_tooltip_show = '';
		$('#ee_tooltip').hide();
	});
}
function gf_tooltip_mousemove(e){
	go_tooltip_pos.pageX = e.pageX;
	go_tooltip_pos.pageY = e.pageY;
	var lo_tt = $('#ee_tooltip');
	if(gs_tooltip_typ == 'EMM')
		lo_tt.css({left:e.pageX-lo_tt.width()-15, top:e.pageY-lo_tt.height()/2});
	else
		lo_tt.css({left:e.pageX+15, top:e.pageY+15});
}

function gf_tooltip(po_obj, ps_typ, ps_id) {
	go_tooltip_obj = po_obj;
	gs_tooltip_show = ps_id;
	ls_info = ga_tooltip[ps_id];
	if(ls_info) {
		return gf_show_tooltip(po_obj, ps_typ, ls_info);
	} else {
		$(go_tooltip_obj).mousemove(gf_tooltip_mousemove).mouseout(function(e){
			gs_tooltip_show = '';
		});
		return gf_remote_call('fkt=xf_tooltip&typ=' + ps_typ + '&id=' + ps_id);
	}
}

function gf_tooltip_set_info(ps_typ, ps_id, ps_info) {
	ga_tooltip[ps_id] = ps_info;
	if(gs_tooltip_show == ps_id) {
		gf_show_tooltip(null, ps_typ, ps_info);
		window.setTimeout('gf_tooltip_mousemove(go_tooltip_pos)', 100);
	}
}

function gf_showhide_optional(pl_id) {
	var ls_display = $('.optional')[0].style.display;
	var lb_do_show = (ls_display == 'none' || ls_display == '');
	if($.browser.msie) {
		// .toggle() und .animate funktionieren in IE8 nicht fuer tr/td - zumindest mit jQuery 1.4.2
		if(lb_do_show) {
			$('.optional').show();
		} else {
			$('.optional').hide();
		}
	} else {
		$('.optional').animate({opacity:'toggle'}, 1000);
	}
	$lo_objmenuitem = $('.objmenuitem a[href="javascript:gf_showhide_optional(' + pl_id + ')"]');
	if(lb_do_show) {
		$lo_objmenuitem.text($lo_objmenuitem.text().replace(/anzeigen/, 'ausblenden').replace(/show/, 'hide'));
		$lo_objmenuitem.parent().prev().find('img').attr('src', 'bilder/ee_less.gif');
	} else {
		$lo_objmenuitem.text($lo_objmenuitem.text().replace(/ausblenden/, 'anzeigen').replace(/hide/, 'show'));
		$lo_objmenuitem.parent().prev().find('img').attr('src', 'bilder/ee_more.gif');
	}
	gf_remote_call('fkt=xf_show_opt&id=' + pl_id + '&s=' + lb_do_show);
}

var ga_media_select_callbacks = new Array();
var gl_media_last_callback_id = 0;
function gf_media_select_from(ps_mode, ps_col) {
	gl_media_last_callback_id--;
	ga_media_select_callbacks[gl_media_last_callback_id] = ps_col;
	var ls_url = 'common/mdb-select.php?CKEditorFuncNum=' + gl_media_last_callback_id + '&mode=' + ps_mode;
	if(ps_mode == 'IrsBild')
		ls_url = 'ee.php?c=ee_choose_items&p=qt&CKEditorFuncNum=' + gl_media_last_callback_id;
	else if(ps_mode == 'IrsLink')
		ls_url = 'ee.php?c=ee_choose_items&p=lqt&CKEditorFuncNum=' + gl_media_last_callback_id;
	var w = window.open(ls_url, '', 'location=no,menubar=no,toolbar=no,scrollbars=yes,dependent=yes,minimizable=no,modal=yes,alwaysRaised=yes,resizable=yes,top=0,left=' + ((screen.width - 1024) / 2) + ',width=1024,height=' + screen.height * 0.9);
	if(w) {
		w.focus();
	}
}

function wf_media_selected_callback(pl_callback_id, po_choice) {
	if(pl_callback_id < 0) {
		var ls_col = ga_media_select_callbacks[pl_callback_id];
		lo_field = document.getElementsByName(ls_col)[0];
		if(lo_field) {
			lo_field.value = po_choice.url;
		}
		lo_field = document.getElementsByName(ls_col + '_w')[0];
		if(lo_field) {
			lo_field.value = po_choice.width;
		}
		lo_field = document.getElementsByName(ls_col + '_h')[0];
		if(lo_field) {
			lo_field.value = po_choice.height;
		}
		lo_field = document.getElementsByName(ls_col + '_s')[0];
		if(lo_field) {
			lo_field.value = po_choice.length;
		}
		lo_field = document.getElementsByName(ls_col + '_m')[0];
		if(lo_field) {
			lo_field.value = po_choice.mime;
		}
		lo_field = document.getElementsByName(ls_col + '_d')[0];
		if(lo_field) {
			lo_field.value = po_choice.duration;
		}
		lo_field = document.getElementsByName(ls_col + '_intmmnr')[0];
		if(lo_field) {
			lo_field.value = po_choice.intmmnr;
		}
	} else {
		CKEDITOR.tools.callFunction(pl_callback_id, po_choice.url, function() {
			var lo_element, lo_dialog = this.getDialog();
			if(lo_dialog.getName() == 'image') {
			lo_element = lo_dialog.getContentElement('info', 'txtAlt');
			if(lo_element)
				lo_element.setValue(po_choice.title);
			}
		});
	}
}

function wf_link_selected_callback(pl_callback_id, po_choice) {
	if(pl_callback_id < 0) {
		var ls_col = ga_media_select_callbacks[pl_callback_id];
		lo_field = document.getElementsByName(ls_col)[0];
		if(lo_field) {
			lo_field.value = po_choice.url;
		}
	} else {
		CKEDITOR.tools.callFunction(pl_callback_id, po_choice.url);
	}
}

function gf_media_clear(ps_col) {
	var la_suffixes = new Array('', '_t', '_w', '_h', '_s', '_m', '_d', '_intmmnr');
	for (var i=0; i<la_suffixes.length; ++i) {
		lo_field = document.getElementsByName(ps_col + la_suffixes[i])[0];
		if(lo_field) {
			lo_field.value = '@DEL@';
		}
	}
	$('.preview_' + ps_col).hide();
}

function gf_css_img_format(po_image, pb_width) {
	var ll_width = po_image.width;
	var ll_height = po_image.height;
	var ld_aspect_ratio = ll_width / ll_height;
	
	var ll_max_width = po_image.parentNode.offsetWidth;
	var ll_max_height = po_image.parentNode.offsetHeight;
	if(ll_width > ll_max_width) {
		ll_width = ll_max_width;
		ll_height = ll_width / ld_aspect_ratio;
	}
	if(ll_height > ll_max_height) {
		ll_height = ll_max_height;
		ll_width = ll_height * ld_aspect_ratio;
	}
	if(pb_width) {
		return parseInt(ll_width) + 'px';
	} else {
		return parseInt(ll_height) + 'px';
	}
}

function gf_get_charset() {
	var ls_charset = document.characterSet;
	if (ls_charset === undefined) {
		ls_charset = document.charset;
	}
	return ls_charset.toUpperCase();
}

function gf_submit(po_form) {
	gb_validate_form = true;

	$(po_form).find(':input').each(function() {
		if(this.type != 'file') {
			var ls_value = $(this).val();
			if(ls_value != null && gf_get_charset() == 'ISO-8859-1') {
				$(this).val(	// Windows-1252 --> ISO-8859-1
					ls_value
					.replace(/\u0152/g, "OE")	//	Œ
					.replace(/\u0153/g, "oe")	//	œ
					.replace(/\u0160/g, "S")	//	Š
					.replace(/\u0161/g, "s")	//	š
					.replace(/\u0178/g, "Y")	//	Ÿ
					.replace(/\u017D/g, "Z")	//	Ž
					.replace(/\u017E/g, "z")	//	ž
					.replace(/\u0192/g, "f")	//	ƒ
					.replace(/\u02C6/g, "^")	//	ˆ
					.replace(/\u02DC/g, "~")	//	˜
					.replace(/\u2013/g, "-")	//	–
					.replace(/\u2014/g, "-")	//	—
					.replace(/\u2018/g, "`")	//	‘
					.replace(/\u2019/g, "´")	//	’
					.replace(/\u201A/g, ",")	//	‚
					.replace(/\u201C/g, "«")	//	“
					.replace(/\u201D/g, "»")	//	”
					.replace(/\u201E/g, "»")	//	„
					.replace(/\u2022/g, "·")	//	•
					.replace(/\u2026/g, "...")	//	…
					.replace(/\u2039/g, "<")	//	‹
					.replace(/\u203A/g, ">")	//	›
					.replace(/\u20AC/g, "EUR")
					.replace(/\u2122/g, "(TM)")

					.replace(/\u1E9E/g, "SS")	// großes ß
				);
			}
		}
	});
	if(gf_validate_all())
		po_form.submit();
}

function gf_onsubmit_set_meg() {
	var la_meg_codes = new Array();
	$('.meg_btn_pushed').each(function() {
		la_meg_codes.push(this.id.replace(/^meg/, ''));
	});
	$('.meg_ddlb:visible option:selected').each(function() {
		if(this.value)
			la_meg_codes.push(this.value);
	});
	$('#meg_codes').val(la_meg_codes.join(','))
	var la_mmtyp = new Array();
	$('.mmtyp_btn_pushed').each(function() {
		la_mmtyp.push(this.id.replace(/^mmtyp_/, ''));
	});
	$('#mmtyp_codes').val(la_mmtyp.join(','))
	return true;
}

function gf_toggle_btn_with_ddlb(ps_btn_id, ps_pushed_class, ps_eatyp) {
	var lb_vis = $(ps_btn_id).hasClass(ps_pushed_class);
	$('.btngrp_' + ps_eatyp).removeClass(ps_pushed_class);
	if(!lb_vis)
		$(ps_btn_id).addClass(ps_pushed_class);
	$('.ddlbgrp_' + ps_eatyp).hide();
	if(!lb_vis)
		$(ps_btn_id + '_ddlb').show();
}

function gf_keypress() {
	gl_keypress_id++;
	window.setTimeout('gf_keypress_delayed(' + gl_keypress_id + ')', 1000);
}
function gf_keypress_delayed(pl_keypress_id) {
	if(gl_keypress_id == pl_keypress_id)
		gf_validate_all();
}


var gl_msg_id = 0;
function gf_add_msg(ps_message, ps_class, pb_autohide) {
	if(!gl_msg_id++) {
		if($('#js_msg_container').length > 0)
			gl_msg_id = $('.js_msg_item').length + 1;
		else
			$('<div />', {id: 'js_msg_container'}).appendTo('body');
	}
	var ls_msg_id = 'js_msg_' + gl_msg_id;
	if(!pb_autohide)
		ps_class = ps_class + ' js_msg_noautohide';
	var lo_msg_item = $('<div/>', {'class': 'js_msg_item ' + ps_class, 'id': ls_msg_id}).appendTo('#js_msg_container').html(ps_message);
	if(!pb_autohide)
		lo_msg_item.prepend('<div style="cursor: pointer; float: right; font-weight: bold" onclick="gf_remove_msg(\'' + ls_msg_id + '\')">X</div>');
	$('#js_msg_container').stop(true, true).show();
	lo_msg_item.slideDown(500);
	if(pb_autohide)
		setTimeout("gf_remove_msg('" + ls_msg_id + "')", 5000);
}
function gf_remove_msg(ps_msg_id) {
	$('#' + ps_msg_id).slideUp(500, gf_check_no_msgs);
}
function gf_remove_all_msgs() {
	$('.js_msg_noautohide').slideUp(500, gf_check_no_msgs);
	$('#js_remove_all_msgs').fadeOut(500);
}
function gf_check_no_msgs() {
	if(!$('.js_msg_item:visible').length) {
		$('#js_remove_all_msgs').fadeOut(500);
		$('#js_msg_container').fadeOut(500);
	}
}

var gs_msg_theme;
var gs_last_msg_fix = '';
var gb_msg_fix_visible = false;
function gf_set_msg(ps_msg, pl_err) {
	if(!gs_msg_theme)
		gs_msg_theme = 'ee';
	if(gs_msg_theme == 'noimg') {
		if(pl_err)
			ls_msg = '<div class="msg1_err">' + ps_msg + '</div>';
		else
			ls_msg = '<div class="msg1_ok">' + ps_msg + '</div>';
		document.getElementById('msg').innerHTML = ls_msg;
	} else {
		if(gs_last_msg_fix != ps_msg) {
			gs_last_msg_fix = ps_msg;
			if(pl_err)
				var ls_class = 'js_msg_item js_msg_err';
			else {
				var ls_class = 'js_msg_item js_msg_ok';
				setTimeout('gf_check_msg_fix()', 5000);
			}
			var lo_msg_fix = $('#js_msg_fix');
			if(!lo_msg_fix.length) {
				if(!$('#js_msg_container').length)
					$('<div />', {id: 'js_msg_container'}).appendTo('body');
				lo_msg_fix = $('<div/>', {'class': ls_class, 'id': 'js_msg_fix'}).html(ps_msg);
				var lo_remove_all_msgs = $('#js_remove_all_msgs');
				if(lo_remove_all_msgs.length)
					lo_msg_fix.insertAfter(lo_remove_all_msgs);
				else
					lo_msg_fix.prependTo('#js_msg_container');
				gb_msg_fix_visible = true;
				$('#js_msg_container').stop(true, true).show();
				lo_msg_fix.slideDown(500);
			} else {
				lo_msg_fix.html(ps_msg).attr('class', ls_class);
				if(!gb_msg_fix_visible) {
					gb_msg_fix_visible = true;
					$('#js_msg_container').stop(true, true).show();
					lo_msg_fix.slideDown(500);
				}
			}
		}
	}
}
function gf_check_msg_fix() {
	if(gb_msg_fix_visible) {
		var lo_msg_fix = $('#js_msg_fix');
		if(lo_msg_fix.hasClass('js_msg_ok') && !lo_msg_fix.is(':animated')) {
			gb_msg_fix_visible = false;
			lo_msg_fix.slideUp(500, gf_check_no_msgs);
		}
	}
}

function gf_validate_all() {
	var ll_err = 0;

	if(!gb_validate_form)
		return true;

	gb_form_valid = true;
	gs_form_errors = '';

	for(var i=0; i<ga_val_invalid_fields.length; i++)
		gf_set_valid(ga_val_invalid_fields[i], true);
	ga_val_invalid_fields = new Array();


	
	for(var i=0; i<ga_validations.length - 1; i++)
		gf_validate(ga_validations[i], i)

	if(gs_form_errors.length) {
		ls_msg = '<ul>' + gs_form_errors + '</ul>';
		gb_enable_messages = true;
		ll_err = -1;
	} else
		ls_msg = ga_validations[ga_validations.length - 1];

	if(gb_enable_messages)
		gf_set_msg(ls_msg, ll_err);
	
	return gb_form_valid;
}


function gf_val_not_empty(pa_fields) {
	for(var i=0; i<pa_fields.length; i++) {
		lo_item = document.getElementsByName(pa_fields[i])[0];
		if(lo_item && gf_trim(lo_item.value).length == 0)
			return false;
	}
	return true;
}

function gf_val_one_not_empty(pa_fields) {
	for(var i=0; i<pa_fields.length; i++) {
		lo_item = document.getElementsByName(pa_fields[i])[0];
		if(lo_item && gf_trim(lo_item.value).length > 0)
			return true;
	}
	return false;
}

function gf_val_all_or_none(pa_fields) {
	var lb_has_one_empty = false;
	var lb_has_one_not_empty = false;
	for(var i=0; i<pa_fields.length; i++) {
		lo_item = document.getElementsByName(pa_fields[i])[0];
		if(lo_item) {
			if(gf_trim(lo_item.value).length > 0)
				lb_has_one_not_empty = true;
			else
				lb_has_one_empty = true;
		}
	}
	return (lb_has_one_empty && !lb_has_one_not_empty) || (!lb_has_one_empty && lb_has_one_not_empty);
}

function gf_val_one_radio(pa_fields) {
	for(var i=0; i<pa_fields.length; i++) {
		lo_items = document.getElementsByName(pa_fields[i]);
		for(var j=0; j<lo_items.length; j++)
			if(lo_items[j].checked)
				return true;
	}
}

function gf_val_int(pa_fields) {
	for(var i=0; i<pa_fields.length; i++) {
		lo_item = document.getElementsByName(pa_fields[i])[0];
		if(lo_item) {
			ls_value = gf_trim(lo_item.value);
			if(lo_item.value != ls_value)
				lo_item.value = ls_value;
			
			if(ls_value.length == 0)
				ls_value = '0';
			
			if(!ls_value.match(/^-?\d+$/))
				return false;
		}
	}
	return true;
}

function gf_val_int_list(pa_fields) {
	for(var i=0; i<pa_fields.length; i++) {
		lo_item = document.getElementsByName(pa_fields[i])[0];
		if(lo_item) {
			ls_value = lo_item.value.replace(/\s/g, '');
			if(lo_item.value != ls_value)
				lo_item.value = ls_value;
		
			if(ls_value.length && !ls_value.match(/^-?\d+(,-?\d+)*$/))
				return false;
		}
	}
	return true;
}

function gf_val_email(pa_fields, pb_allow_empty) {
	for(var i=0; i<pa_fields.length; i++) {
		lo_item = document.getElementsByName(pa_fields[i])[0];
		if(lo_item) {
			ls_value = gf_trim(lo_item.value);
			if(lo_item.value != ls_value)
				lo_item.value = ls_value;
			
			if(ls_value.length) {
				if(ls_value.match(/(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/))
					return false;
				if(!ls_value.match(/^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,6}|[0-9]{1,3})(\]?)$/))
					return false;
			} else if(!pb_allow_empty)
				return false;
		}
	}
	return true;
}

function gf_val_fix_url(pa_fields) {
	for(var i=0; i<pa_fields.length; i++) {
		lo_item = document.getElementsByName(pa_fields[i])[0];
		if(lo_item) {
			ls_value = gf_trim(lo_item.value);

			if((ls_value.substring(0,4) == 'www.' || (ls_value.search(/^[^\/]+\.(com|net|org|info|de|ch|at|eu)$/) != -1)) && (ls_value.search('://') == -1))
				ls_value = 'http://' + ls_value;

			if((ls_value.search('://') != -1) && (ls_value.search(/:\/\/.*\//) == -1))
				ls_value = ls_value + '/';

			if(lo_item.value != ls_value)
				lo_item.value = ls_value;
		}
	}
	return true;
}

function gf_val_subpage_url(pa_fields) {
	lo_items = document.getElementsByName(pa_fields[0]);
	if(lo_items[lo_items.length-1].checked) {
		if(gf_trim(document.getElementsByName(pa_fields[1])[0].value) != '')
			return false;
	}
	return true;
}



function gf_validate(pa_validation_row, pl_row) {
	var lb_invalid, ll_cached;
	
	switch(pa_validation_row[0]) {
	case 'not_empty':
		if(!gf_val_not_empty(pa_validation_row[1]))
			gf_validation_failed(pa_validation_row[2], pa_validation_row[3]);
		break;
	case 'one_not_empty':
		if(!gf_val_one_not_empty(pa_validation_row[1]))
			gf_validation_failed(pa_validation_row[2], pa_validation_row[3]);
		break;
	case 'all_or_none':
		if(!gf_val_all_or_none(pa_validation_row[1]))
			gf_validation_failed(pa_validation_row[2], pa_validation_row[3]);
		break;
	case 'one_radio':
	case 'checked':
		if(!gf_val_one_radio(pa_validation_row[1]))
			gf_validation_failed(pa_validation_row[2], pa_validation_row[3]);
		break;
	case 'int':
		if(!gf_val_int(pa_validation_row[1]))
			gf_validation_failed(pa_validation_row[2], pa_validation_row[3]);
		break;
	case 'int_ne':
		if(!gf_val_int(pa_validation_row[1]) || !gf_val_not_empty(pa_validation_row[1]))
			gf_validation_failed(pa_validation_row[2], pa_validation_row[3]);
		break;
	case 'int_list':
		if(!gf_val_int_list(pa_validation_row[1]))
			gf_validation_failed(pa_validation_row[2], pa_validation_row[3]);
		break;
	case 'int_list_ne':
		if(!gf_val_int_list(pa_validation_row[1]) || !gf_val_not_empty(pa_validation_row[1]))
			gf_validation_failed(pa_validation_row[2], pa_validation_row[3]);
		break;
	case 'email':
		if(!gf_val_email(pa_validation_row[1], true))
			gf_validation_failed(pa_validation_row[2], pa_validation_row[3]);
		break;
	case 'email_ne':
		if(!gf_val_email(pa_validation_row[1], false))
			gf_validation_failed(pa_validation_row[2], pa_validation_row[3]);
		break;
	case 'fix_url':
		gf_val_fix_url(pa_validation_row[1]);
		break;
	case 'subpage_url':
		if(!gf_val_subpage_url(pa_validation_row[1]))
			gf_validation_failed(pa_validation_row[2], pa_validation_row[3]);
		break;
	}
}

function gf_validation_failed(ps_message, pa_fail_fields) {
	var lb_has_invalid = false;
	for(var i=0; i<pa_fail_fields.length; i++) {
		lo_field = document.getElementsByName(pa_fail_fields[i])[0];
		if(lo_field.value != '@DEL@') {
			ga_val_invalid_fields.push(lo_field);
			gf_set_valid(lo_field, false);
			lb_has_invalid = true;
		}
	}
	if(lb_has_invalid) {
		gb_form_valid = false;
		gs_form_errors = gs_form_errors + '<li>' + ps_message + '</li>';
	}
}

function gf_set_valid(po_field, pb_valid) {
	if(po_field) {
		if(pb_valid)
			po_field.className = po_field.className.split(' ')[0];
		else {
			po_field.className = po_field.className.split(' ')[0] + ' fieldinvalid';
		}
	}
}


function obfus(ps_string) {
	document.write(ROTn(ps_string, "(v`J[ra0$:d3>C.9e|zE<R'1?Uw~ohAbmV*nZWyT\"gL6,xYc+jM^N]OID#2%Pp;/5ut&_sBiH4Xl!}@GKqk-7fFQ8{\\S=)"));
}
////////////////////////////////////////////////
// (C) 2010 Andreas  Spindler. Permission to use, copy,  modify, and distribute
// this software and  its documentation for any purpose with  or without fee is
// hereby  granted.   Redistributions of  source  code  must  retain the  above
// copyright notice and the following disclaimer.
//
// THE SOFTWARE  IS PROVIDED  "AS IS" AND  THE AUTHOR DISCLAIMS  ALL WARRANTIES
// WITH  REGARD   TO  THIS  SOFTWARE   INCLUDING  ALL  IMPLIED   WARRANTIES  OF
// MERCHANTABILITY AND FITNESS.  IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY
// SPECIAL,  DIRECT,   INDIRECT,  OR  CONSEQUENTIAL  DAMAGES   OR  ANY  DAMAGES
// WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER IN AN ACTION
// OF  CONTRACT, NEGLIGENCE  OR OTHER  TORTIOUS ACTION,  ARISING OUT  OF  OR IN
// CONNECTION WITH THE USE OR PERFORMANCE OF THIS SOFTWARE.
// 
// $Writestamp: 2010-06-09 13:07:07$
// $Maintained at: www.visualco.de$

function ROTn(text, map) {
	// Generic ROT-n algorithm for keycodes in MAP.
	var R = new String();
	var i, j, c, len = map.length;
	for(i = 0; i < text.length; i++) {
		c = text.charAt(i);
		j = map.indexOf(c);
		if (j >= 0) {
			c = map.charAt((j + len / 2) % len);
		}
		R = R + c;
	}
	return R;
}

////////////////////////////////////////////////


// Auszug aus datepick.js
var argDate;
var argYear;
var argMonth;
var argDay;
function datepick(theme,field) {
	argYear = '';
	argMonth = '';
	argDay = '';
	argDate = field;
	open('ee_helper/smarty_datepick/?type=textfield&theme='+theme+'&date='+argDate.value,'datepick','width=200,height=200');
}
