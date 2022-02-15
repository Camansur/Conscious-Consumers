//Image credits from Unsplash Abby Anaday https://unsplash.com/photos/Nnn2Dc6niVU, Jeremy Bezanger https://unsplash.com/photos/k8HniqcdYS4, and Gustavo Quepón https://unsplash.com/photos/pF_2lrjWiJE

//Code references: w3schools.com

//This variable holds the path to the images to rotate through in the slideshow. 
var imagesPath = ["images/slideshow1.jpg", "images/slideshow2.jpg", "images/slideshow3.jpg"]; //array to hold paths to images for the slide

//Incremental value to select the correct image in the array by index.
var i = 0;
var collapsible = document.getElementsByClassName("collapsible");

//Incremental value for collapsible
var j;

var gasPrice = 0.00;

//This function iterates through the imagesPath array to change the image in the slideshow after a specific amount of time (4000ms = 4 seconds in this case)
function slideshow() {

	//Get element of the slideshow to change the image according to the path from the array and index.
	document.getElementById("slideShowImage").src = imagesPath[i];

	//Timeout to set the delay between increments
	setTimeout(slideshow, 4000);

	//increment slide
	i++;

	//Check if the index is equal to the length of the array, if true reset to 0 to start the slide show from the beginning of the array.
	if(i == imagesPath.length) {
		//Set i to 0.
		i = 0;
	}
}

//Ensures that the element exists prior to executing the function slideshow.
if(document.getElementById("slideShowImage") !== null) {
	slideshow();
}

//Resources page button collapsible
for(j = 0; j < collapsible.length; j++) {

	collapsible[j].addEventListener("click", function() {

		this.classList.toggle("active");

		var content = this.nextElementSibling;

		if(content.style.display === "block") {
			content.style.display = "none";
		} else {
			content.style.display = "block";
		}
	});
}

function getGasPrice(){
	fetch("https://api.collectapi.com/gasPrice/stateUsaPrice?state=AZ", {
	"method": "GET",
	"headers": {
		"authorization": "apikey 7HHE7brl02AG6tMXcFzny4:1tw6EZ7jIIwRYbnm6LJWXB - disabled"
	}
})
.then(response => {
	return response.json();
})
.then(
	(response) => {
		gasPrice = response.result.state.gasoline;
		//console.log(gasPrice);
		document.getElementById("gascost").value = gasPrice;
		}
)
.catch(err => {
	console.error(err);
	document.getElementById("gascost").value = 3.60;
});
}

function mpgCalculate(){

	var costOutput = 0.00;
	var elecOutput = 0.00;
	var savings = 0.00;

	
	if (document.getElementById("gallons").value == 0 || document.getElementById("fillup").value == 0 || document.getElementById("gascost").value == 0){
		document.getElementById("gasOutput").innerHTML = "Please fill out all boxes!";
	}else{
		costOutput = (document.getElementById("gallons").value * document.getElementById("fillup").value * document.getElementById("gascost").value).toFixed(2);
		document.getElementById("gasOutput").innerHTML = "We estimate that you pay about $" + costOutput + " in gas every month!";
		elecOutput = (12.30 * document.getElementById("fillup").value).toFixed(2);
		document.getElementById("gasOutput2").innerHTML = "If you were to own an electric vehicle, such as a Tesla Model S, you would pay $" + elecOutput + " in electricity every month";
		
		costOutput = parseFloat(costOutput);
		elecOutput = parseFloat(elecOutput);

		if (costOutput >= elecOutput){
			savings = (costOutput - elecOutput);
		}else if (elecOutput < costOutput){
			savings = (elecOutput - costOutput);
		}

		document.getElementById("gasOutput3").innerHTML = "That is a total savings of $" + savings.toFixed(2) + " in gas every month";
	}
	
}