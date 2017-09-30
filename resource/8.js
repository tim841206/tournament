// layer 1
var bound = 4;
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
// layer 4
if (document.getElementById("p8_4").classList.length == 0) {
	document.getElementById("p8_4").classList.add("b");
}