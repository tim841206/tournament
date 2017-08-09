function enter() {
	var amount = Number(document.getElementById("amount").value);
	var gameno = document.getElementById("gameno").value;
	var gamenm = document.getElementById("gamenm").value;
	var type = document.getElementById("type");
	if (gameno.length == 0) {
		alert("請輸入競賽編號");
	}
	else if (gamenm.length == 0) {
		alert("請輸入競賽名稱");
	}
	else if (amount == NaN || amount > 128 || amount < 9) {
		alert("請輸入介於 9 ~ 128 之正整數參賽人數");
	}
	else {
		if (type[0].checked) {
			var request = new XMLHttpRequest();
			request.open("POST", "assign.php");
			var data = "gameno=" + gameno + "&gamenm=" + gamenm + "&amount=" + amount;
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
	var gamenm = document.getElementById("gamenm").value;
	var type = document.getElementById("type");
	if (gameno.length == 0) {
		alert("請輸入競賽編號");
	}
	else if (gamenm.length == 0) {
		alert("請輸入競賽名稱");
	}
	else if (amount == NaN || amount > 128 || amount < 9) {
		alert("請輸入介於 9 ~ 128 之正整數參賽人數");
	}
	else {
		if (type[0].checked) {
			var request = new XMLHttpRequest();
			request.open("POST", "assign.php");
			var data = "gameno=" + gameno + "&gamenm=" + gamenm + "&amount=" + amount;
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
			var data = "mode=auto&gameno=" + gameno + "&gamenm=" + gamenm + "&amount=" + amount + "&unit=" + unit + "&name=" + name;
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

function public(amount, gameno, gamenm) {
	var unit = [];
	var name = [];
	var roundAmount = Math.pow(2, Math.ceil(Math.log2(amount)));
	for (i = 1; i <= roundAmount; i++) {
		if (document.getElementById("unit"+i) == null) {
			unit[i-1] = 'none';
			name[i-1] = 'none';
		}
		else {
			unit[i-1] = document.getElementById("unit"+i).value;
			name[i-1] = document.getElementById("name"+i).value;
		}
	}
	var request = new XMLHttpRequest();
	request.open("POST", "../produce.php");
	var data = "mode=enter&gameno=" + gameno + "&gamenm=" + gamenm + "&amount=" + amount + "&unit=" + unit + "&name=" + name;
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

function games() {
	var request = new XMLHttpRequest();
	request.open("GET", "search.php?type=view");
	request.send();
	request.onreadystatechange = function() {
		if (request.readyState === 4 && request.status === 200) {
			var data = JSON.parse(request.responseText);
			if (data.message == 'Success') {
				document.getElementById("games").innerHTML = data.content;
			}
			else {
				alert(data.message);
			}
		}
	}
}