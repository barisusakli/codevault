

var codespaz = (function (my) {
	"use strict";
	var languages = {
			"Bison":"sh_bison",
			"C":"sh_c",
			"C++":"sh_cpp",
			"C#":"sh_csharp",
			"ChangeLog":"sh_changelog",
			"CSS":"sh_css",
			"Desktop files":"sh_desktop",
			"Diff":"sh_diff",
			"Flex":"sh_flex",
			"GLSL":"sh_glsl",
			"Haxe":"sh_haxe",
			"HTML":"sh_html",
			"Java":"sh_java",
			"Java properties files":"sh_properties",
			"JavaScript":"sh_javascript",
			"JavaScript with DOM":"sh_javascript_dom",
			"LaTeX":"sh_latex",
			"LDAP files":"sh_ldap",
			"Log files":"sh_log",
			"LSM (Linux Software Map) files":"sh_lsm",
			"M4":"sh_m4",
			"Makefile":"sh_makefile",
			"Objective Caml":"sh_caml",
			"Oracle SQL":"sh_oracle",
			"Pascal":"sh_pascal",
			"Perl":"sh_perl",
			"PHP":"sh_php",
			"Prolog":"sh_prolog",
			"Python":"sh_python",
			"RPM spec files":"sh_spec",
			"Ruby":"sh_ruby",
			"S-Lang":"sh_slang",
			"Scala":"sh_scala",
			"Shell":"sh_sh",
			"SQL":"sh_sql",
			"Standard ML":"sh_sml",
			"Tcl":"sh_tcl",
			"XML":"sh_xml",
			"Xorg configuration files":"sh_xorg"
		};
	
	function escapeHtml(unsafe) {
		return unsafe
		  .replace(/&/g, "&amp;")
		  .replace(/</g, "&lt;")
		  .replace(/>/g, "&gt;")
		  .replace(/"/g, "&quot;")
		  .replace(/'/g, "&#039;");

	}
	
	function createErrorMsg(message) {
		return jQuery('<div class="ui-widget">\
			<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"> \
				<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span> \
				<strong>Alert:</strong>'+message+'</p>\
			</div>\
		</div>');
	}
	
	function callback(){
	
	
	}
	
	my.getPostDate = function (timestamp) {
		return new Date(timestamp*1000).toLocaleString();
	}
	
	my.renderPost = function (container,postData) {
		var titleElement = jQuery("<span class='ui-widget'>"+postData.title+"</span>");
			
		var containerDiv = jQuery("<div class='code-background'></div>");
		var codeDiv = jQuery("<pre id='resultDiv' class='code-snippet'>"+escapeHtml(postData.code)+"</pre>");

		var languageClass = languages[postData.language];
		codeDiv.addClass(languageClass);
			
		container.empty();
		container.append(titleElement);
		container.append(codeDiv);
		sh_highlightDocument('js/libs/shjs-0.6/lang/', '.js');
	}
	
	function createPostLink(ul, index, postData) {
		var title = postData[index].title;
		if(title === "")
			title = "Empty Title";
		var li = jQuery("<li><a href='?post="+postData[index].postID+"'>"+title+"</a></li>");
		
		/*li.click(function(){
			my.loadPost(postData[index].postID);
		});*/
		ul.append(li);
	}
	
	my.renderLatest = function(container) {
		$.ajax({
		  type: "POST",
		  url: "php/api.php",
		  data: { call:'Post.getLatestPosts',params:{ }}
		}).done(function( result ) {
					  
			var parsedResult = JSON.parse(result);
			if(parsedResult.status === 1) {
				
				var ul = jQuery('<ul class="latestPosts"></ul>');
				var postData = parsedResult.data;
				for(var index in parsedResult.data)	{
					createPostLink(ul,index,postData);
				}
				container.append(ul);
			}
				
		});
	}
	
	my.loadPost = function(postID) {
		$.ajax({
		  type: "POST",
		  url: "php/api.php",
		  data: { call:'Post.getPost',params:{ postID: postID }}
		}).done(function( result ) {
					  
			var parsedResult = JSON.parse(result);
			if(parsedResult.status === 1)
				my.renderPost(jQuery("#page-wrapper"),parsedResult.data);
		});
	}
	
	my.init = function() {		
		
		var selectElement = jQuery("#post-language");
		for(var key in languages) {
			selectElement.append("<option>"+key+"</option>");
		}
		selectElement.val("JavaScript");
		
		
		jQuery("#search").click(function(){
			if(this.value === 'search')
				this.value = '';
		});
		
		jQuery("#search").blur(function(){
			if(this.value === '')
				this.value = 'search';
		});
		
		my.renderLatest(jQuery("#side-bar"));
		
		$("#formSubmitButton").click(function(){
			var title = jQuery("#post-title")[0].value;
			var languageName = jQuery("#post-language")[0].value;
			var languageClass = languages[languageName];
			var code = jQuery("#post-code")[0].value;
			jQuery("#form-errors").empty();
			jQuery("#form-errors").hide();
			
			if(title === ""){
				var errorMsg = createErrorMsg('Please enter a title');
				jQuery("#form-errors").append(errorMsg);
				jQuery("#form-errors").show( "bounce", {}, 100, callback);
				return;
			}
			if(code === ""){
				var errorMsg = createErrorMsg('Please enter code');
				jQuery("#form-errors").append(errorMsg);
				jQuery("#form-errors").show( "bounce", {}, 100, callback);
				return;
			}

			var postData = { title: title, language: languageName,code:code };
			
			$.ajax({
			  type: "POST",
			  url: "php/api.php",
			  data: { call:'Post.createNew',params:postData}
			}).done(function( result ) {
			  var parsedResult = JSON.parse(result);
			  if(parsedResult.status === 1)
				my.renderPost(jQuery("#page-wrapper"),postData);
				window.location.href = '?post='+parsedResult.data.postID;
			});
			
		});
		
		
		console.log("init done");
	}
	
	return my;

}(codespaz || {}));

requirejs.config({
	baseUrl: 'js'
});

$(document).ready(codespaz.init);