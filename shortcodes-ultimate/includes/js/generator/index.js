!function n(a,s,o){function i(t,e){if(!s[t]){if(!a[t]){var r="function"==typeof require&&require;if(!e&&r)return r(t,!0);if(u)return u(t,!0);throw(e=new Error("Cannot find module '"+t+"'")).code="MODULE_NOT_FOUND",e}r=s[t]={exports:{}},a[t][0].call(r.exports,function(e){return i(a[t][1][e]||e)},r,r.exports,n,a,s,o)}return s[t].exports}for(var u="function"==typeof require&&require,e=0;e<o.length;e++)i(o[e]);return i}({1:[function(e,t,r){"use strict";var p,n,s,o,i,u,c,l,g,a,d,f;window.SUG={},window.SUG.App=(p=jQuery,n=p("#su-generator"),s=p("#su-generator-search"),o=p("#su-generator-filter"),i=o.children("a"),u=p("#su-generator-choices"),c=u.find("span"),l=p("#su-generator-settings"),g=p("#su-compatibility-mode-prefix"),a=p("#su-generator-result"),d=p("#su-generator-selected"),(f={state:{mceSelection:"",target:"",wpActiveEditor:null,context:"",insertArgs:"",preview:{timer:null,request:null}}}).el={body:p("body")},f.init=()=>{var a;i.click(function(e){var t,r=p(this).data("filter");"all"===r?c.css({opacity:1}).removeClass("su-generator-choice-first"):(t=new RegExp(r,"gi"),c.css({opacity:.2}),c.each(function(){null!==p(this).data("group").match(t)&&p(this).css({opacity:1}).removeClass("su-generator-choice-first")})),e.preventDefault()}),p("#su-generator").on("click",".su-generator-home",function(e){s.val(""),l.html("").hide(),n.removeClass("su-generator-narrow"),o.show(),u.show(),c.show(),f.state.mceSelection="",s.focus(),e.preventDefault()}),p("#su-generator").on("click",".su-generator-close",function(e){p.magnificPopup.close(),e.preventDefault()}),s.on({focus:function(){p(this).val(""),l.html("").hide(),n.removeClass("su-generator-narrow"),u.show(),c.css({opacity:1}).removeClass("su-generator-choice-first"),o.show()},blur:function(){},keyup:function(e){var t=p(".su-generator-choice-first:first"),r=p(this).val(),n=new RegExp(r,"gi"),a=0;13===e.keyCode&&0<t.length&&(e.preventDefault(),p(this).val("").blur(),t.trigger("click")),c.css({opacity:.2}).removeClass("su-generator-choice-first"),c.each(function(){var e=p(this).data(),t=e.shortcode,e=[t,e.name,e.desc,e.group].join(" ").match(n);null!==e&&(p(this).css({opacity:1}),r===t?(c.removeClass("su-generator-choice-first"),p(this).addClass("su-generator-choice-first"),a=999):e.length>a&&(c.removeClass("su-generator-choice-first"),p(this).addClass("su-generator-choice-first"),a=e.length))}),""===r&&c.removeClass("su-generator-choice-first")}}),c.on("click",function(e){var t=p(this).data("shortcode");p.ajax({type:"POST",url:ajaxurl,data:{action:"su_generator_settings",shortcode:t},beforeSend:function(){p("#su-generator-preview").hide(),u.hide(),l.addClass("su-generator-loading").show(),n.addClass("su-generator-narrow"),o.hide()},success:function(e){l.removeClass("su-generator-loading"),l.html(e);e=p("#su-generator-content");void 0!==f.state.mceSelection&&""!==f.state.mceSelection&&"hidden"!==e.attr("type")&&e.val(f.state.mceSelection),p(".su-generator-range-picker").each(function(e){var t=p(this).find("input"),r=t.attr("min"),n=t.attr("max"),a=t.attr("step");t.simpleSlider({snap:!0,step:a,range:[r,n]}),t.show(),t.on("keyup blur",function(e){t.simpleSlider("setValue",t.val())})}),p(".su-generator-select-color").each(function(e){p(this).find(".su-generator-select-color-wheel").filter(":first").farbtastic(".su-generator-select-color-value:eq("+e+")"),p(this).find(".su-generator-select-color-value").focus(function(){p(".su-generator-select-color-wheel:eq("+e+")").show()}),p(this).find(".su-generator-select-color-value").blur(function(){p(".su-generator-select-color-wheel:eq("+e+")").hide()})}),p(".su-generator-isp").each(function(){function n(){var t,e,r,n="none",a="",s=o.val();"media"===s?(t=[],i.find("span").each(function(e){t[e]=p(this).data("id")}),0<t.length&&(a=t.join(","))):"category"===s?0<(e=u.val()||[]).length&&(a=e.join(",")):"taxonomy"===s?(e=c.val()||"",r=l.val()||[],"0"!==e&&0<r.length&&(n="taxonomy: "+e+"/"+r.join(","))):n="0"===s?"none":s,g.val(n=""!==a?s+": "+a:n).trigger("change")}var t,r=p(this),o=r.find(".su-generator-isp-sources"),a=r.find(".su-generator-isp-source"),e=r.find(".su-generator-isp-add-media"),i=r.find(".su-generator-isp-images"),u=r.find(".su-generator-isp-categories"),c=r.find(".su-generator-isp-taxonomies"),l=p(".su-generator-isp-terms"),g=r.find(".su-generator-attr");o.on("change",function(e){var t=p(this).val();e.preventDefault(),a.removeClass("su-generator-isp-source-open"),-1===t.indexOf(":")&&r.find(".su-generator-isp-source-"+t).addClass("su-generator-isp-source-open"),n()}),i.on("click","span i",function(){p(this).parent("span").css("border-color","#f03").fadeOut(300,function(){p(this).remove(),n()})}),e.click(function(e){e.preventDefault(),void 0!==t&&t.close(),(t=wp.media.frames.su_media_frame_1=wp.media({title:SUGL10n.isp_media_title,library:{type:"image"},button:{text:SUGL10n.isp_media_insert},multiple:!0})).on("open",function(){p(".mfp-wrap").addClass("hidden")}),t.on("close",function(){p(".mfp-wrap").removeClass("hidden")}),t.on("select",function(){var e=t.state().get("selection").toJSON();i.find("em").remove(),p.each(e,function(e){i.append('<span data-id="'+this.id+'" title="'+this.title+'"><img src="'+this.url+'" alt="" /><i class="sui sui-times"></i></span>')}),n()}).open()}),i.sortable({revert:200,containment:r,tolerance:"pointer",stop:function(){n()}}),u.on("change",n),l.on("change",n),c.on("change",function(){var e,t=p(this).parents(".su-generator-isp-source"),r=p(this).val();l.hide().find("option").remove(),n(),"0"!==r&&(e=p.ajax({url:ajaxurl,type:"post",dataType:"html",data:{action:"su_generator_get_terms",tax:r,class:"su-generator-isp-terms",multiple:!0,size:10},beforeSend:function(){"object"==typeof e&&e.abort(),l.html("").attr("disabled",!0).hide(),t.addClass("su-generator-loading")},success:function(e){l.html(e).attr("disabled",!1).show(),t.removeClass("su-generator-loading")}}))})}),p(".su-generator-upload-button").each(function(){var t,e=p(this),r=p(this).parents(".su-generator-attr-container").find("input:text");e.on("click",function(e){e.preventDefault(),e.stopPropagation(),void 0!==t&&t.close(),(t=wp.media.frames.su_media_frame_2=wp.media({title:SUGL10n.upload_title,button:{text:SUGL10n.upload_insert},multiple:!1})).on("select",function(){var e=t.state().get("selection").first().toJSON();r.val(e.url).trigger("change")}),t.on("open",function(){p(".mfp-wrap").addClass("hidden")}),t.on("close",function(){p(".mfp-wrap").removeClass("hidden")}),t.open()})}),p(".su-generator-icon-picker-button").each(function(){var e=p(this),t=p(this).parents(".su-generator-attr-container"),n=t.find(".su-generator-attr"),a=t.find(".su-generator-icon-picker"),s=a.find("input:text");e.click(function(e){a.toggleClass("su-generator-icon-picker-visible"),s.val("").trigger("keyup"),a.hasClass("su-generator-icon-picker-loaded")||(p.ajax({type:"post",url:ajaxurl,data:{action:"su_generator_get_icons"},dataType:"html",beforeSend:function(){a.addClass("su-generator-loading"),a.addClass("su-generator-icon-picker-loaded")},success:function(e){a.append(e);var r=a.children("i");r.click(function(e){n.val("icon: "+p(this).attr("title")),a.removeClass("su-generator-icon-picker-visible"),n.trigger("change"),e.preventDefault()}),s.on({keyup:function(){var e=p(this).val(),t=new RegExp(e,"gi");r.hide(),r.each(function(){null!==p(this).attr("title").match(t)&&p(this).show()})},focus:function(){p(this).val(""),r.show()}}),a.removeClass("su-generator-loading")}}),e.preventDefault())})}),p(".su-generator-switch").click(function(e){var t=p(this).parent().children("input");("yes"===t.val()?t.val("no"):t.val("yes")).trigger("change"),e.preventDefault()}),p(".su-generator-switch-value").on("change",function(){var e=p(this),t=e.parent().children(".su-generator-switch"),e=e.val();"yes"===e?t.removeClass("su-generator-switch-no").addClass("su-generator-switch-yes"):"no"===e&&t.removeClass("su-generator-switch-yes").addClass("su-generator-switch-no")}),p("select#su-generator-attr-taxonomy").on("change",function(){var e=p(this).val(),t=p("select#su-generator-attr-tax_term");window.su_generator_get_terms=p.ajax({type:"POST",url:ajaxurl,data:{action:"su_generator_get_terms",tax:e,noselect:!0},dataType:"html",beforeSend:function(){"object"==typeof window.su_generator_get_terms&&window.su_generator_get_terms.abort(),t.parent().addClass("su-generator-loading")},success:function(e){t.find("option").remove(),t.append(e),t.parent().removeClass("su-generator-loading")}})}),p(".su-generator-shadow-picker").each(function(e){var t=p(this),r=t.find(".su-generator-shadow-picker-field input"),n=t.find(".su-generator-sp-hoff"),a=t.find(".su-generator-sp-voff"),s=t.find(".su-generator-sp-blur"),o={cnt:t.find(".su-generator-shadow-picker-color"),value:t.find(".su-generator-shadow-picker-color-value"),wheel:t.find(".su-generator-shadow-picker-color-wheel")},i=t.find(".su-generator-attr");o.wheel.farbtastic(o.value),o.value.focus(function(){o.wheel.show()}),o.value.blur(function(){o.wheel.hide()}),r.on("change blur keyup",function(){i.val(n.val()+"px "+a.val()+"px "+s.val()+"px "+o.value.val()).trigger("change")}),i.on("keyup",function(){var e=p(this).val().split(" ");4===e.length&&(n.val(e[0].replace("px","")),a.val(e[1].replace("px","")),s.val(e[2].replace("px","")),o.value.val(e[3]),r.trigger("keyup"))})}),p(".su-generator-border-picker").each(function(e){var t=p(this),r=t.find(".su-generator-border-picker-field input, .su-generator-border-picker-field select"),n=t.find(".su-generator-bp-width"),a=t.find(".su-generator-bp-style"),s={cnt:t.find(".su-generator-border-picker-color"),value:t.find(".su-generator-border-picker-color-value"),wheel:t.find(".su-generator-border-picker-color-wheel")},o=t.find(".su-generator-attr");s.wheel.farbtastic(s.value),s.value.focus(function(){s.wheel.show()}),s.value.blur(function(){s.wheel.hide()}),r.on("change blur keyup",function(){o.val(n.val()+"px "+a.val()+" "+s.value.val()).trigger("change")}),o.on("keyup",function(){var e=p(this).val().split(" ");3===e.length&&(n.val(e[0].replace("px","")),a.val(e[1]),s.value.val(e[2]),r.trigger("keyup"))})}),l.find(".su-generator-attr").on("change keyup blur",function(){var e=p(this).parents(".su-generator-attr-container"),t=e.data("default");p(this).val()!=t?e.removeClass("su-generator-skip"):e.addClass("su-generator-skip")}),p(".su-generator-set-value").click(function(e){p(this).parents(".su-generator-attr-container").find("input").val(p(this).text()).trigger("change")}),d.val(t),p.ajax({type:"GET",url:ajaxurl,data:{action:"su_generator_get_preset",id:"last_used",shortcode:t,nonce:p("#su_generator_presets_nonce").val()},beforeSend:function(){},success:function(e){f.setSettings(e);e=p("#su-generator-content");void 0!==f.state.mceSelection&&""!==f.state.mceSelection&&"hidden"!==e.attr("type")&&e.val(f.state.mceSelection)},dataType:"json"})},dataType:"html"})}),p("#su-generator").on("click",".su-generator-insert",f.insertShortcode),p("#su-generator").on("click",".su-generator-toggle-preview",function(e){var t=p("#su-generator-preview");p(this).hide(),t.addClass("su-generator-loading").show(),l.find("input, textarea, select").on("change keyup blur",function(){f.updatePreview()}),f.updatePreview(!0),e.preventDefault()}),p("#su-generator").on("mouseenter click",".su-generator-presets",function(){clearTimeout(a),p(".su-gp-popup").show()}),p("#su-generator").on("mouseleave",".su-generator-presets",function(){a=window.setTimeout(function(){p(".su-gp-popup").fadeOut(200)},600)}),p("#su-generator").on("click",".su-gp-new",function(e){p(this).parents(".su-generator-presets");var t=p(".su-gp-list"),r=(new Date).getTime(),n=prompt(SUGL10n.presets_prompt_msg,SUGL10n.presets_prompt_value);""!==n&&null!==n&&(t.find("b").hide(),t.append('<span data-id="'+r+'"><em>'+n+'</em><i class="sui sui-times"></i></span>'),f.addPreset(r,n))}),p("#su-generator").on("click",".su-gp-list span",function(e){var t=p(".su-generator-presets").data("shortcode"),r=p(this).data("id"),n=p(".su-generator-insert");p(".su-gp-popup").hide(),clearTimeout(a),p.ajax({type:"GET",url:ajaxurl,data:{action:"su_generator_get_preset",id:r,shortcode:t,nonce:p("#su_generator_presets_nonce").val()},beforeSend:function(){n.addClass("button-primary-disabled").attr("disabled",!0)},success:function(e){n.removeClass("button-primary-disabled").attr("disabled",!1),f.setSettings(e)},dataType:"json"}),e.preventDefault(),e.stopPropagation()}),p("#su-generator").on("click",".su-gp-list i",function(e){var t=p(this).parents(".su-gp-list"),r=p(this).parent("span"),n=r.data("id");r.remove(),t.find("span").length<1&&t.find("b").show(),f.removePreset(n),e.stopPropagation(),e.preventDefault()})},f.addPreset=function(e,t){var r=p(".su-generator-presets").data("shortcode"),n=f.getSettings();p.ajax({type:"POST",url:ajaxurl,data:{action:"su_generator_add_preset",id:e,name:t,shortcode:r,settings:n,nonce:p("#su_generator_presets_nonce").val()}})},f.removePreset=function(e){var t=p(".su-generator-presets").data("shortcode");p.ajax({type:"POST",url:ajaxurl,data:{action:"su_generator_remove_preset",id:e,shortcode:t,nonce:p("#su_generator_presets_nonce").val()}})},f.parseSettings=function(){var e="on"===p("#su-generator-option-skip").val()?"#su-generator-settings .su-generator-attr-container:not(.su-generator-skip) .su-generator-attr":"#su-generator-settings .su-generator-attr-container .su-generator-attr",t=d.val(),r=g.val(),e=p(e),n=p("textarea#su-generator-content"),n=n.length?n.val():"false",a=new String("");return a+="["+r+t,e.each(function(){var e=p(this),t="";null==(t=(e.is("select")?e.find("option:selected"):e).val())?t="":"array"==typeof t&&(t=t.join(",")),""!==t&&(a+=" "+p(this).attr("name")+'="'+p(this).val().toString().replace(/"/gi,"'")+'"')}),a+="]","false"!=n&&(a+=n+"[/"+r+t+"]"),a},f.getSettings=function(){d.val();var e=p("#su-generator-settings .su-generator-attr"),t=p("textarea#su-generator-content"),t=t.length?t.val():"false",a={};return e.each(function(e){var t=p(this),r="",n=t.attr("name"),r=(t.is("select")?t.find("option:selected"):t).val();a[n]=r=null==r?"":r}),a.content=t.toString(),a},f.setSettings=function(r){var e=p("#su-generator-settings .su-generator-attr"),t=p("#su-generator-content");e.each(function(){var e=p(this),t=e.attr("name");r.hasOwnProperty(t)&&(e.val(r[t]),e.trigger("keyup").trigger("change").trigger("blur"))}),r.hasOwnProperty("content")&&t.val(r.content).trigger("keyup").trigger("change").trigger("blur"),f.updatePreview()},f.updatePreview=function(e){var t=p("#su-generator-preview"),r=f.parseSettings(),n=a.text();e=e||!1,t.is(":visible")&&(r!==n||e)&&(window.clearTimeout(f.state.preview.timer),f.state.preview.timer=window.setTimeout(function(){f.state.preview.request=p.ajax({type:"POST",url:ajaxurl,cache:!1,data:{action:"su_generator_preview",shortcode:r},beforeSend:function(){f.state.preview.request&&f.state.preview.request.abort(),t.addClass("su-generator-loading").html("")},success:function(e){t.html(e).removeClass("su-generator-loading")},dataType:"html"})},300),a.text(r))},f.insert=function(e,t){var r;"string"==typeof e&&"object"==typeof t&&(f.state.context=e,r=(f.state.insertArgs=t).shortcode||"",(e={type:"inline",alignTop:!0,closeOnBgClick:!1,mainClass:"su-generator-mfp",items:{src:"#su-generator"},callbacks:{}}).callbacks.open=()=>{r?c.filter('[data-shortcode="'.concat(r,'"]')).trigger("click"):window.setTimeout(()=>s.focus(),200),"undefined"!=typeof tinyMCE&&null!=tinyMCE.activeEditor&&tinyMCE.activeEditor.hasOwnProperty("selection")&&(f.state.mceSelection=tinyMCE.activeEditor.selection.getContent({format:"text"}))},e.callbacks.close=()=>{s.val(""),l.html("").hide(),n.removeClass("su-generator-narrow"),o.show(),u.show(),c.show(),f.state.mceSelection=""},p.magnificPopup.open(e))},f.insertShortcode=function(){var e,t,r=f.parseSettings();f.addPreset("last_used",SUGL10n.last_used),p.magnificPopup.close(),a.text(r),"html"===f.state.context&&(e=document.getElementById(f.state.insertArgs.editorID),f.insertAtCaret(e,r)),"classic"===f.state.context&&window.wp.media.editor.insert(r),"block"===f.state.context&&((e=f.state.insertArgs.props).attributes.hasOwnProperty("content")?e.setAttributes({content:e.attributes.content+r}):"core/shortcode"===e.name&&(t=e.attributes.hasOwnProperty("text")?e.attributes.text:"",e.setAttributes({text:t+r})))},f.insertAtCaret=(e,t)=>{var r=e.selectionStart;e.value=e.value.substring(0,r)+t+e.value.substring(r),e.focus(),e.selectionStart=r+t.length},{init:f.init,insert:f.insert}),jQuery(document).ready(window.SUG.App.init)},{}]},{},[1]);
//# sourceMappingURL=index.js.map
