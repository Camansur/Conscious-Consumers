//Image credits from Unsplash Abby Anaday https://unsplash.com/photos/Nnn2Dc6niVU, Jeremy Bezanger https://unsplash.com/photos/k8HniqcdYS4, and Gustavo Quepón https://unsplash.com/photos/pF_2lrjWiJE

//This variable holds the path to the images to rotate through in the slideshow. 
var imagesPath = ["images/slideshow1.jpg", "images/slideshow2.jpg", "images/slideshow3.jpg"]; //array to hold paths to images for the slide

//Incremental value to select the correct image in the array by index.
var i = 0;

//This function iterates through the imagesPath array to change the image in the slideshow after a specific amount of time (4000ms = 4 seconds in this case)
function slideshow() {

	//Get element of the slideshow to change the image according to the path from the array and index.
	document.getElementById("slideShowImage").src = imagesPath[i];

	//Timeout to set the delay between increments
	setTimeout(slideshow, 4000);

	//increment slide
	i++;

	//Check if the index is equal to the length of the array, if true reset to 0 to start the slide show from the beginning of the array.
	if (i == imagesPath.length) {

		//Set i to 0.
		i = 0;

	}
}

//Ensures that the element exists prior to executing the function slideshow.
if (document.getElementById("slideShowImage") != null) {
	slideshow();
}