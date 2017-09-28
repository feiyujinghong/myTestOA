// JavaScript Document
/*
* Includes: jquery.js 10
*  万事屋的小孩 QQ675509308 修正*/
(function($) {
	var printAreaCount = 0;
	$.fn.printArea = function() {
		var ele = $(this);
		var idPrefix = "printArea_";
		removePrintArea(idPrefix + printAreaCount);
		printAreaCount++;
		var iframeId = idPrefix + printAreaCount;
		var iframeStyle = 'position:absolute;width:0px;height:0px;left:-500px;top:-500px;';
		iframe = document.createElement('IFRAME');
		$(iframe).attr({
			style : iframeStyle,
			id : iframeId
		});
		document.body.appendChild(iframe);
		var doc = iframe.contentWindow.document;
		$(document).find("link").filter(function() {
			return $(this).attr("rel").toLowerCase() == "stylesheet";
		}).each(
				function() {
					doc.write('<link type="text/css" rel="stylesheet" href="'
							+ $(this).attr("href") + '" >');
				});
		var div = $("<div></div>");
		div.css("display","none");
		div.append($(ele).clone());
		doc.write('<div class="' + $(ele).attr("class") + '">' + div.html()
				+ '</div>');
		div.remove();
		doc.close();
		var frameWindow = iframe.contentWindow;
		frameWindow.close();
		frameWindow.focus();
		frameWindow.print();
	};
	var removePrintArea = function(id) {
		$("iframe#" + id).remove();
	};
})(jQuery);