function enter() {
	var amount = Number(document.getElementById("amount").value);
	var gameno = document.getElementById("gameno").value;
	var type = document.getElementById("type");
	if (amount == NaN || amount > 64 || amount < 9) {
		alert("請輸入介於 9 ~ 64 之正整數參賽人數");
	}
	else {
		if (type[0].checked) {
			var request = new XMLHttpRequest();
			request.open("POST", "assign.php");
			var data = "gameno=" + gameno + "&amount=" + amount;
			request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			request.send(data);
			request.onreadystatechange = function() {
				if (request.readyState === 4 && request.status === 200) {
					var data = JSON.parse(request.responseText);
					if (data.message == 'Success') {
						location.assign(gameno + "/assign.html");
					}
					else {
						alert(data.message);
					}
				}
			}
		}
		else if (type[1].checked) {
			var content = '<table><tr><th>單位</th><th>名稱</th></tr>';
			for (i = 1; i <= amount; i++) {
				content += '<tr><td><input type="text" id="unit' + i + '"></td><td><input type="text" id="name' + i + '"></td></tr>';
			}
			content += '</table><button onclick="send()">確定送出</button>';
			document.getElementById("players").innerHTML = content;
			document.getElementById("players").style.display = null;
		}
		else {
			alert("請選擇賽程排列方式");
		}
	}
}

function send() {
	var amount = Number(document.getElementById("amount").value);
	var gameno = document.getElementById("gameno").value;
	var type = document.getElementById("type");
	if (amount == NaN || amount > 64 || amount < 9) {
		alert("請輸入介於 9 ~ 64 之正整數參賽人數");
	}
	else {
		if (type[0].checked) {
			var request = new XMLHttpRequest();
			request.open("POST", "assign.php");
			var data = "amount=" + amount;
			request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			request.send(data);
			request.onreadystatechange = function() {
				if (request.readyState === 4 && request.status === 200) {
					var data = JSON.parse(request.responseText);
					if (data.message == 'Success') {
						location.assign(gameno + "/assign.html");
					}
					else {
						alert(data.message);
					}
				}
			}
		}
		else if (type[1].checked) {
			var unit = [];
			var name = [];
			for (i = 1; i <= amount; i++) {
				unit.push(document.getElementById("unit" + i).value);
				name.push(document.getElementById("name" + i).value);
			}
			var request = new XMLHttpRequest();
			request.open("POST", "produce.php");
			var data = "mode=auto&gameno=" + gameno + "&amount=" + amount + "&unit=" + unit + "&name=" + name;
			request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			request.send(data);
			request.onreadystatechange = function() {
				if (request.readyState === 4 && request.status === 200) {
					var data = JSON.parse(request.responseText);
					if (data.message == 'Success') {
						location.assign(data.gameno + "/edit.html");
					}
					else {
						alert(data.message);
					}
				}
			}
		}
		else {
			alert("請選擇賽程排列方式");
		}
	}
}

function public(amount, gameno) {
	var unit = [];
	var name = [];
	if (amount > 8 && amount <= 16) {
		for (i = 1; i <= 16; i++) {
			if (document.getElementById("unit"+i) == null) {
				unit[i-1] = 'none';
				name[i-1] = 'none';
			}
			else {
				unit[i-1] = document.getElementById("unit"+i).value;
				name[i-1] = document.getElementById("name"+i).value;
			}
		}
	}
	else if (amount > 16 && amount <= 32) {
		for (i = 1; i <= 32; i++) {
			if (document.getElementById("unit"+i) == null) {
				unit[i-1] = 'none';
				name[i-1] = 'none';
			}
			else {
				unit[i-1] = document.getElementById("unit"+i).value;
				name[i-1] = document.getElementById("name"+i).value;
			}
		}
	}
	else if (amount > 32 && amount <= 64) {
		for (i = 1; i <= 64; i++) {
			if (document.getElementById("unit"+i) == null) {
				unit[i-1] = 'none';
				name[i-1] = 'none';
			}
			else {
				unit[i-1] = document.getElementById("unit"+i).value;
				name[i-1] = document.getElementById("name"+i).value;
			}
		}
	}
	var request = new XMLHttpRequest();
	request.open("POST", "../produce.php");
	var data = "mode=enter&gameno=" + gameno + "&amount=" + amount + "&unit=" + unit + "&name=" + name;
	request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	request.send(data);
	request.onreadystatechange = function() {
		if (request.readyState === 4 && request.status === 200) {
			var data = JSON.parse(request.responseText);
			if (data.message == 'Success') {
				location.assign("edit.html");
			}
			else {
				alert(data.message);
			}
		}
	}
}

function update(gameno) {
	var above = [];
	var below = [];
	var again = true;
	for (i = 1; again; i++) {
		var a = document.getElementById(i+"_above");
		var b = document.getElementById(i+"_below");
		if (a != null && b != null) {
			above[i] = a.value;
			below[i] = b.value;
		}
		else {
			again = false;
		}
	}
	var request = new XMLHttpRequest();
	request.open("POST", "../update.php");
	var data = "gameno=" + gameno + "&above=" + above + "&below=" + below;
	request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	request.send(data);
	request.onreadystatechange = function() {
		if (request.readyState === 4 && request.status === 200) {
			var data = JSON.parse(request.responseText);
			if (data.message == 'Success') {
				alert("成功更新");
				location.reload();
			}
			else {
				alert(data.message);
			}
		}
	}
}