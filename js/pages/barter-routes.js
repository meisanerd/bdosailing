var trade_id = 0;
var ignore_load_ids = [104];
var ignore_unload_ids = [50,55,93];
function calculate_parley() {
	$(".noparley").removeClass("noparley");
	var parley = $("#parley").val();
	$(".trade").each(function() {
		var parley_used = $(this).data("parley") * $(this).data("num");
		parley -= parley_used;
		$(".data .remaining_parley",$(this)).text(parley);
		if(parley < 0) {
			$(this).addClass("noparley");
		}
	});
}
function calculate_weight() {
	$(".overweight").removeClass("overweight");
	var weight = $("#weight").val()*100;
	$(".trade").each(function() {
		var weight_out = ($(".data .input",$(this)).data("weight") * parseInt($(".data .input",$(this)).data("qty")) * $(this).data("num"))*100;
		var weight_in = ($(".data .output",$(this)).data("weight") * parseInt($(".data .output",$(this)).data("qty")) * $(this).data("num"))*100;
		weight += weight_out;
		weight -= weight_in;
		$(".data .remaining_weight",$(this)).text((weight/100).toFixed(2));
		if(weight < 0) {
			$(this).addClass("overweight");
		}
	});
}
function close_trade() {
	$("#trade_dialog").hide();
	trade_id = 0;
}
function create_pos_select() {
	if($("#trade_insert_select").length) {
		var newselect = $("<SELECT>").attr("id","trade_insert_position");
		newselect.append($("<OPTION>").attr("value","0").text("Top"));
		$(".trade").each(function(x) {
			if(x) {
				newselect.append($("<OPTION>").attr("value",x).text("Above " + $(".input .name",$(this)).text() + " for " + $(".output .name",$(this)).text() + " at " + $(".location .name",$(this)).text()));
			}
		});
		newselect.append($("<OPTION>").attr("value","-1").text("Bottom"));
		newselect.val(-1);
		$("#trade_insert_position").replaceWith(newselect);
	}
}
function load_suggestions() {
	if($("#suggestions").length) {
		var location = $("#trade_location").length?$("#trade_location").val():0;
		var input = $(".data .output",$(".trade").last()).data("id");
		var output = $(".data .input",$(".trade").last()).data("id");
		$("#suggestions").load("/ajax/barter-suggestions.php", {location: location, input: input, output: output}, function() {
			$(".suggestion").click(function(e) {
				e.preventDefault();
				$("#trade_location").val($(this).data("location"));
				$("#trade_input").val($(this).data("input"));
				$("#trade_output").val($(this).data("output"));
			});
		});
	}
}
function open_trade(e) {
	e.preventDefault();
	trade_id = $(this).data("id");
	$("#trade_dialog").load("/ajax/barter-dialog.php", {barter: trade_id}, function() {
		$("#trade_save").click(function(e) {
			e.preventDefault();
			save_trade();
		});
		$("#trade_save_close").click(function(e) {
			e.preventDefault();
			save_trade(close_trade);
		});
		$("#trade_close").click(function(e) {
			e.preventDefault();
			close_trade();
		});
		$("#trade_complete").click(function(e) {
			e.preventDefault();
			$.post('/ajax/barter-delete.php', {barter: trade_id, complete: 1}, function(response) {
				$("#trade_" + trade_id).remove();
				if(typeof(response.error) != "undefined" && response.error.length) {
					alert(response.error);
				} else {
					$("#parley").val(response.parley);
					$("#weight").val(response.current_weight);
					calculate_parley();
					calculate_weight();
					close_trade();
				}
			}, "json");
		});
		$("#trade_cancel").click(function(e) {
			e.preventDefault();
			$.post('/ajax/barter-delete.php', {barter: trade_id, complete: 0}, function(response) {
				$("#trade_" + trade_id).remove();
				if(typeof(response.error) != "undefined" && response.error.length) {
					alert(response.error);
				} else {
					$("#parley").val(response.parley);
					$("#weight").val(response.current_weight);
					calculate_parley();
					calculate_weight();
					close_trade();
				}
			}, "json");
		});
		load_suggestions();
		create_pos_select();
		$("#trade_location").change(load_suggestions);
		$("#trade_dialog").show().css("display","flex");
	});
}
function sort_down(e) {
	e.preventDefault();
	e.stopPropagation();
	var trade = $(this).closest(".trade");
	$.post('/ajax/barter-move.php', {barter: trade.data("id"), direction: 'down'}, function(response) {
		if(response == "1") {
			trade.insertAfter(trade.next());
			calculate_parley();
			calculate_weight();
		} else {
			alert(response);
		}
	});
}
function sort_up(e) {
	e.preventDefault();
	e.stopPropagation();
	var trade = $(this).closest(".trade");
	$.post('/ajax/barter-move.php', {barter: trade.data("id"), direction: 'up'}, function(response) {
		if(response == "1") {
			trade.insertBefore(trade.prev());
			calculate_parley();
			calculate_weight();
		} else {
			alert(response);
		}
	});
}
function save_trade(after) {
	var location_id = parseInt($("#trade_location").val());
	var input_id = parseInt($("#trade_input").val());
	var input_qty = parseInt($("#trade_input_qty").val());
	var output_id = parseInt($("#trade_output").val());
	var output_qty = parseInt($("#trade_output_qty").val());
	var num = parseInt($("#trade_num").val());
	var parley = parseInt($("#trade_parley").val());
	var trade_insert_position = $("#trade_insert_position").length?parseInt($("#trade_insert_position").val()):0;
	$.post('/ajax/barter-update.php', {barter: trade_id, location_id: location_id, input_id: input_id, input_qty: input_qty, output_id: output_id, output_qty: output_qty, num: num, parley: parley, trade_insert_position: trade_insert_position}, function(response) {
		if(typeof(response.error) != "undefined" && response.error.length) {
			alert(response.error);
		} else {
			if(trade_id > 0) {
				$("#trade_" + trade_id).unbind("click").replaceWith(response.html);
				$("#trade_" + trade_id).click(open_trade);
				$(".sort_up",$("#trade_" + trade_id)).click(sort_up);
				$(".sort_down",$("#trade_" + trade_id)).click(sort_down);
			} else {
				var newtrade = $(response.html);
				if($("#trades .trade").eq(response.pos).length) {
					$("#trades .trade").eq(response.pos).before(newtrade);
				} else {
					$("#trades").append(newtrade);
				}
				trade_id = newtrade.data("id");
				newtrade.click(open_trade);
				$(".sort_up",newtrade).click(sort_up);
				$(".sort_down",newtrade).click(sort_down);
			}
			calculate_parley();
			calculate_weight();
			if(typeof(after) == 'function') {
				after();
			}
			create_pos_select();
		}
	}, "json");
}
$(document).ready(function() {
	$(".trade").click(open_trade);
	$("#add_trade").click(open_trade);
	$("#complete").click(function(e) {
		e.preventDefault();
		var complete_trade_id = $(".trade").first().data("id");
		$.post('/ajax/barter-delete.php', {barter: complete_trade_id, complete: 1}, function(response) {
			$("#trade_" + complete_trade_id).remove();
			if(typeof(response.error) != "undefined" && response.error.length) {
				alert(response.error);
			} else {
				$("#parley").val(response.parley);
				$("#weight").val(response.current_weight);
				calculate_parley();
				calculate_weight();
			}
		}, "json");
	});
	$(".sort_block").click(function(e) {
		e.stopPropagation();
	});
	$(".sort_up").click(sort_up);
	$(".sort_down").click(sort_down);
	$("#parley").change(function(e) {
		$.post("/ajax/parley-update.php", {parley: $(this).val()}, function(response) {
			calculate_parley();
		});
	});
	$("#weight").change(function(e) {
		$.post("/ajax/weight-update.php", {weight: $(this).val()}, function(response) {
			calculate_weight();
		});
	});
	$("#action_dialog_button").click(function(e) {
		e.preventDefault();
		$("#action_dialog").toggle();
	});
	$("#add_loads").click(function(e) {
		e.preventDefault();
		$("#action_dialog").hide();
		$("#trade_dialog").load("/ajax/barter-dialog.php", {mode: "add_loads"}, function() {
			$("#trade_save_close").click(function(e) {
				e.preventDefault();
				$("#missing_loads_list input").each(function() {
					if($(this).prop("checked")) {
						$("#trade_output").val($(this).data("id"));
						$("#trade_output_qty").val($(this).data("qty"));
						save_trade(function() {
							trade_id = 0;
						});
					}
				});
				close_trade();
			});
			$("#trade_close").click(function(e) {
				e.preventDefault();
				close_trade();
			});
			var loads = [];
			$(".trade").each(function() {
				var input_id = $(".data .input",$(this)).data("id");
				if(ignore_load_ids.indexOf(input_id) == -1) {
					if(typeof(loads[input_id]) == "undefined") {
						loads[input_id] = {
							name: $(".data .input .name",$(this)).text(),
							qty: 0
						};
					}
					loads[input_id].qty += ($(".data .input",$(this)).data("qty") * $(this).data("num"));
				}
				var output_id = $(".data .output",$(this)).data("id");
				if(typeof(loads[output_id]) == "undefined") {
					loads[output_id] = {
						name: $(".data .output .name",$(this)).text(),
						qty: 0
					};
				}
				loads[output_id].qty -= ($(".data .output",$(this)).data("qty") * $(this).data("num"));
			});
			for(var x in loads) {
				if(loads[x].qty > 0) {
					$("<DIV>").append(
						$("<LABEL>").append(
							$("<INPUT>").attr("type","checkbox").css("width","auto").data("id",x).data("qty",loads[x].qty).prop("checked",true),
							loads[x].qty + "x " + loads[x].name
						)
					).appendTo($("#missing_loads_list"));
				}
			}
			create_pos_select();
			$("#trade_insert_position").val(0);
			$("#trade_dialog").show().css("display","flex");
		});
	});
	$("#add_unloads").click(function(e) {
		e.preventDefault();
		$("#action_dialog").hide();
		$("#trade_dialog").load("/ajax/barter-dialog.php", {mode: "add_unloads"}, function() {
			$("#trade_save_close").click(function(e) {
				e.preventDefault();
				$("#missing_unloads_list input").each(function() {
					if($(this).prop("checked")) {
						$("#trade_input").val($(this).data("id"));
						$("#trade_input_qty").val($(this).data("qty"));
						save_trade(function() {
							trade_id = 0;
						});
					}
				});
				close_trade();
			});
			$("#trade_close").click(function(e) {
				e.preventDefault();
				close_trade();
			});
			var loads = [];
			$(".trade").each(function() {
				var input_id = $(".data .input",$(this)).data("id");
				if(typeof(loads[input_id]) == "undefined") {
					loads[input_id] = {
						name: $(".data .input .name",$(this)).text(),
						qty: 0
					};
				}
				loads[input_id].qty -= ($(".data .input",$(this)).data("qty") * $(this).data("num"));
				var output_id = $(".data .output",$(this)).data("id");
				if(ignore_unload_ids.indexOf(output_id) == -1) {
					if(typeof(loads[output_id]) == "undefined") {
						loads[output_id] = {
							name: $(".data .output .name",$(this)).text(),
							qty: 0
						};
					}
					loads[output_id].qty += ($(".data .output",$(this)).data("qty") * $(this).data("num"));
				}
			});
			for(var x in loads) {
				if(loads[x].qty > 0) {
					$("<DIV>").append(
						$("<LABEL>").append(
							$("<INPUT>").attr("type","checkbox").css("width","auto").data("id",x).data("qty",loads[x].qty).prop("checked",true),
							loads[x].qty + "x " + loads[x].name
						)
					).appendTo($("#missing_unloads_list"));
				}
			}
			create_pos_select();
			$("#trade_dialog").show().css("display","flex");
		});
	});
	calculate_parley();
	calculate_weight();
});
