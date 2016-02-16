

function readyDateClosed() {
	if ($("#status").val() == "OPEN") {
		$("#dateClosed").val(""); $("#dateClosed").attr("readonly", true);
	} else {
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1;
		mm = (mm < 10 ? "0" : "") + mm;
		var yyyy = today.getFullYear();
		document.getElementById("dateClosed").value = yyyy + "-" + mm + "-" + dd; $("#dateClosed").attr("readonly", false);
	}
}

function addTaskRow() {
	var numRows = $('#taskTable tr').length;
	var table = $('#taskTable');

	var row = $('<tr>');
	row.append($("<td><input type='text' name='taskName'" + numRows + "id='taskName'" + numRows + "/></td>"));
	row.append($("<td><textarea rows='5' name='taskDescription'" + numRows + "id='taskDescription'" + numRows + "></textarea></td>"));
	row.append($("<td><input type='checkbox' name='taskCompleted'" + numRows + "id='taskCompleted'" + numRows + "/></td>"));

	$('#taskTable').append(row);

}
