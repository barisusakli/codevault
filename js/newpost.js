define({
	init: function() {
		console.log('Ahh After 10,000 years I\'m free! Time to conquer Earth!');

		// Capture tabs in the textarea and stop the browser from executing the default event
		document.getElementById('post-code').addEventListener('keydown', function(e) {
			if (e.keyCode === 9) {
				e.preventDefault();
				// this.value += "\t";
				// console.log(this, e, this.selectionStart);
				// this.selectionStart = 0;
				// this.selectionEnd = 1;
				if (this.selectionEnd >= this.selectionStart) {
					// Add tab before selection, maintain highlighted text selection
					var	currentStart = this.selectionStart,
						currentEnd = this.selectionEnd;

					this.value = this.value.slice(0, currentStart) + "\t" + this.value.slice(currentStart);
					this.selectionStart = currentStart + 1;
					this.selectionEnd = currentEnd + 1;
				} else {
					console.log('How are you selecting negative characters?');
				}
			}
		}, false);
	}
});