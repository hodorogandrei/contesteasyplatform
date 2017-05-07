function countChar(val){
						var len = val.value.length;
						if (len >= 100) {
							val.value = val.value.substring(0, 100);
						}else {
							$('#charNum').text(100 - len + " caractere rămase");
						}
};

function countChar2(val){
						var len = val.value.length;
						if (len >= 100) {
							val.value = val.value.substring(0, 100);
						}else {
							$('#charNum2').text(100 - len + " caractere rămase");
						}
};

function countChar3(val){
						var len = val.value.length;
						if (len >= 15) {
							val.value = val.value.substring(0, 15);
						}else {
							$('#charNum3').text(15 - len + " caractere rămase");
						}
};

function countChar4(val){
						var len = val.value.length;
						if (len >= 35) {
							val.value = val.value.substring(0, 35);
						}else {
							$('#charNum4').text(35 - len + " caractere rămase");
						}
};

function countChar5(val){
						var len = val.value.length;
						if (len >= 100) {
							val.value = val.value.substring(0, 100);
						}else {
							$('#charNum5').text(100 - len + " caractere rămase");
						}
};