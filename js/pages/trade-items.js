var trade_level = 0;
var trade_name = "";
var trade_item_id = 0;
function apply_filters() {
	$(".trade_item").each(function() {
		var hide = false;
		if(trade_level > 0 && !$(this).hasClass("level_" + trade_level)) {
			hide = true;
		}
		if(trade_name.length && $(".data .name",$(this)).text().toLowerCase().indexOf(trade_name) == -1) {
			hide = true;
		}
		if(hide) {
			$(this).hide();
		} else {
			$(this).show();
		}
	});
}
function close_trade_item() {
	$("#trade_item_dialog").hide();
	trade_item_id = 0;
}
function save_trade_item(after) {
	var item_count = parseInt($("#item_count").text());
	var item_notes = $("#item_notes").val();
	$.post('/ajax/item-update.php', {item: trade_item_id, num: item_count, notes: item_notes}, function(response) {
		if(typeof(response.error) != "undefined" && response.error.length) {
			alert(response.error);
		} else {
			$("#item_count").text(response.num);
			$(".count", $("#trade_item_" + trade_item_id)).text(response.num);
			$(".notes", $("#trade_item_" + trade_item_id)).text(response.notes);
			if(typeof(after) == 'function') {
				after();
			}
		}
	}, "json");
}
$(document).ready(function() {
	$("#level").change(function(e) {
		trade_level = $(this).val();
		apply_filters();
	});
	$("#name").keyup(function(e) {
		trade_name = $(this).val().toLowerCase();
		apply_filters();
	});
	$(".trade_item").click(function(e) {
		e.preventDefault();
		$("#item_name").text($(".data .name",$(this)).text());
		$("#item_count").text($(".data .count",$(this)).text());
		$("#item_notes").val($(".data .notes",$(this)).text());
		trade_item_id = $(this).attr("id").substr(11);
		$("#trade_item_dialog").show().css("display","flex");
	});
	$("#item_count_decrease").click(function(e) {
		e.stopPropagation();
		var item_count = parseInt($("#item_count").text());
		if(item_count > 0) {
			item_count -= 1;
			$("#item_count").text(item_count);
		}
	});
	$("#item_count_increase").click(function(e) {
		e.stopPropagation();
		var item_count = parseInt($("#item_count").text());
		item_count += 1;
		$("#item_count").text(item_count);
	});
	$("#trade_item_save").click(function(e) {
		e.preventDefault();
		save_trade_item();
	});
	$("#trade_item_save_close").click(function(e) {
		e.preventDefault();
		save_trade_item(close_trade_item);
	});
	$("#trade_item_close").click(function(e) {
		e.preventDefault();
		close_trade_item();
	});
});