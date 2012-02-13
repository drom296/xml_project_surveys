/**
 * @author Charles
 */

$(document).ready(function(){
	
	// testing to see if jquery was loaded
	// alert("test");
	
	// that was a success
	
	
	// TODO: Jquery, add the delete image in front of every input, except for name
	
	
});


function createQuestion(){
	var result = "";
	
	// create the question container
	result += "<div>";
	
	// add the question input
	result += "<label>question</label><br />";
	result += "<input></input><br />";
			
	// add the choice input
	result += createChoice();
	result += "<br />";
	
	// add the more choices link
	result += "<a>+Add Choice</a>";
	
	// add the more questions link
	result += "<a>+Add Question</a>";
	
	// close the container
	result = "</div>";
	
	return result;
}


// creates a choice
function createChoice(){
	var result = "";

	// build the input element
	result += "<label>choice</label><br />";
	result += "<input></input>";

	return result;
}
