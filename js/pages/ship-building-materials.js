function show_items() {
	if($(this).prop("checked")) {
		$(".item",$(this).closest("fieldset")).show();
	} else {
		$(".item",$(this).closest("fieldset")).hide();
	}
}
function calc_items_needed(items, node, level) {
	$(".itemdatalevel_" + level, node).each(function() {
		if(typeof(items[$(this).data("partid")]) == "undefined") {
			items[$(this).data("partid")] = {
				"name": $(".name",$(this)).text(),
				"needed": 0,
				"have": 0
			}
		}
		items[$(this).data("partid")].needed += parseInt($(this).data("qty"));
		items[$(this).data("partid")].have += parseInt($(".haveqty",$(this)).first().val());
		if(parseInt($(".haveqty",$(this)).first().val()) < parseInt($(this).data("qty"))) {
			var nextlevel = level + 1;
			if($(".itemdatalevel_" + nextlevel, $(this).closest(".item")).length) {
				items = calc_items_needed(items, $(this).closest(".item"), nextlevel);
			}
		}
	});
	return items;
}
function update_items_needed(items, node, level) {
	$(".itemdatalevel_" + level, node).each(function() {
		if(typeof(items[$(this).data("partid")]) != "undefined") {
			var needed = parseInt($(this).data("qty"));
			if(items[$(this).data("partid")] > needed) {
				$("input",this).first().val(needed);
				items[$(this).data("partid")] -= needed;
			} else if(items[$(this).data("partid")] > 0) {
				$("input",this).first().val(items[$(this).data("partid")]);
				items[$(this).data("partid")] -= items[$(this).data("partid")];
			} else {
				$("input",this).first().val(0);
			}
			if(parseInt($(".haveqty",$(this)).first().val()) < parseInt($(this).data("qty"))) {
				var nextlevel = level + 1;
				if($(".itemdatalevel_" + nextlevel, $(this).closest(".item")).length) {
					items = update_items_needed(items, $(this).closest(".item"), nextlevel);
				}
			}
		}
	});
	return items;
}
$(document).ready(function() {
	$(".build").each(show_items).click(show_items);
	$(".making").click(function(e) {
		e.preventDefault();
		$("#item_name").html($(".name",$(this).closest("label")).html());
		var steps = $(this).data("steps");
		$("#making_steps").empty();
		for(var x in steps) {
			$("#making_steps").append(
				$("<DIV>").html(steps[x])
			);
		}
		$("#making_dialog").show().css("display","flex");
	});
	$("#making_close").click(function(e) {
		e.preventDefault();
		$("#making_dialog").hide();
	});
	$("#save").click(function(e) {
		e.preventDefault();
		$.post('/ajax/ship-building-materials.php', {params: $("#ship-building-materials").serializeArray()}, function(response) {
			if(typeof(response.error) != "undefined" && response.error.length) {
				alert(response.error);
			} else {
				alert("Saved Successfully");
			}
		}, "json");
	});
	$("#summary").click(function(e) {
		e.preventDefault();
		var dlg = $("<DIV>");
		var items = [];
		$(".build").each(function() {
			if($(this).prop("checked")) {
				items = calc_items_needed(items, $(this).closest("fieldset"), 0);
			}
		});
		for(x in items) {
			var item = items[x];
			dlg.append(
				$("<DIV>").append(
					$("<STRONG>").text(item.name + ": "),
					$("<INPUT>").attr("type","number").val(item.have),
					" / " + item.needed
				).data("partid", x)
			);
		}
		$("#summary_items").empty().append(dlg);
		$("#summary_dialog").show().css("display","flex");
	});
	$("#summary_update").click(function(e) {
		e.preventDefault();
		var items = [];
		$("#summary_items div").each(function() {
			items[$(this).data("partid")] = $("input", this).val();
		});
		$(".build").each(function() {
			if($(this).prop("checked")) {
				update_items_needed(items, $(this).closest("fieldset"), 0);
			}
		});
		$("#summary_dialog").hide();
	});
	$("#summary_close").click(function(e) {
		e.preventDefault();
		$("#summary_dialog").hide();
	});
});