var parentElement = document.getElementById('image-holder');
var firstChild = parentElement.childNodes[0];

function loadImage() {
	var old_img = document.getElementById("loaded-img");
	var line_br = document.getElementById("loaded-br");
	if (old_img != null && line_br != null) {
		old_img.parentNode.removeChild(old_img)
		line_br.parentNode.removeChild(line_br)
	}

	var val = document.getElementById('image-url').value,
	src = val,

	img = document.createElement('img');
	img.id = "loaded-img";
	img.src = src;
	img.style.width = '20em';
	img.alt = "Image loaded from URL";

	line_break = document.createElement("br");
	line_break.id = "loaded-br"
	parentElement.insertBefore(line_break, firstChild);
	parentElement.insertBefore(img, firstChild);
};