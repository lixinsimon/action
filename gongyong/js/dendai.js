function dendai() {

	var rootElement = document.body;
	var newElement = document.createElement("div");
	newElement.id = "dengdai";

	var dia1 = document.createElement("div");
	var dia2 = document.createElement("div");
	var dia3 = document.createElement("div");
	dia1.classList.add("yuan", "yuan1");
	dia2.classList.add("yuan", "yuan2");
	dia3.classList.add("yuan", "yuan3");

	newElement.appendChild(dia1);
	newElement.appendChild(dia2);
	newElement.appendChild(dia3);

	rootElement.appendChild(newElement);
	

}

function gb_dendai() {
	var yichu = document.getElementById("dengdai");
	document.body.removeChild(yichu);
}