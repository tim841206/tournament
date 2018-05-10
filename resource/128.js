// layer 1
var bound = 64;
var times = 4;
var start = 1;
var layer = 1;
while (bound >= 1) {
	for (a = 1; a <= bound; a++) {
		for (b = start+1; b < 3*start-1; b++) {
			if (document.getElementById("p"+(a*times-b)+"_"+layer).classList.length == 0) {
				document.getElementById("p"+(a*times-b)+"_"+layer).classList.add("r");	
			}
		}
		if (document.getElementById("p"+(a*times-start)+"_"+layer).classList.length == 0) {
			document.getElementById("p"+(a*times-start)+"_"+layer).classList.add("b-r");	
		}
		if (document.getElementById("p"+(a*times-(3*start-1))+"_"+layer).classList.length == 0) {
			document.getElementById("p"+(a*times-(3*start-1))+"_"+layer).classList.add("t-r");	
		}
	}
	bound = bound / 2;
	times = times * 2;
	start = Math.pow(2, Math.log2(start)+1);
	layer = layer + 1;
}
// layer 8
var final_start = start/2 + 1;
var final_end = start/2*3;
for (c = final_start; c <= final_end; c++) {
	if (document.getElementById("p"+c+"_"+layer).classList.length == 0) {
		if (c == final_start) {
			document.getElementById("p"+c+"_"+layer).classList.add("t-r");	
		}
		else if (c == final_end) {
			document.getElementById("p"+c+"_"+layer).classList.add("b-r");	
		}
		else {
			document.getElementById("p"+c+"_"+layer).classList.add("r");
		}
	}
}
layer = layer + 1;
// layer 9
if (document.getElementById("p"+start+"_"+layer).classList.length == 0) {
	document.getElementById("p"+start+"_"+layer).classList.add("b");
}