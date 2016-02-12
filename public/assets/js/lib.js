

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

function addTaskRow() {
	var numRows = $('#taskTable tr').length;
	var table = $('#taskTable');

	var newRow = table.insertRow(numRows);
	var cell1 = newRow.insertCell(0);
	var cell2 = newRow.insertCell(1);
	var cell3 = newRow.insertCell(2);

	cell1.innerHTML = "<input type='text' name='taskName'" + numRows + "id='taskName'" + numRows + "/>";
	cell2.innerHTML = "<textarea rows='5' name='taskDescription'" + numRows + "id='taskDescription'" + numRows + "></textarea>";
	cell3.innerHTML = "<input type='checkbox' name='taskCompleted'" + numRows + "id='taskCompleted'" + numRows + "/>"

}
