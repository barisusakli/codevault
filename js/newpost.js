define({
	init: function() {
		console.log('Ahh After 10,000 years I\'m free! Time to conquer Earth!');

		// Capture tabs in the textarea and stop the browser from executing the default event
		tabIndent.render(document.getElementById('post-code'));
	}
});