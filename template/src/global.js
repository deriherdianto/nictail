$(document).ready(function(){
	$('.dropdown-button').dropdown({
		inDuration: 300,
		outDuration: 225,
		constrain_width: false, // Does not change width of dropdown to that of the activator
		hover: false, // Activate on hover
		gutter: -15, // Spacing from edge
		belowOrigin: true, // Displays dropdown below the button
		alignment: 'right' // Displays dropdown with edge aligned to the left of button
    });
});
