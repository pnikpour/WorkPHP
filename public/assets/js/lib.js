

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
