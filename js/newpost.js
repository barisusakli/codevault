define({
	init: function() {

		// Capture tabs in the textarea and stop the browser from executing the default event
		jQuery('#post-code').keydown(function(e) {
			if (e.keyCode === 9) {
				e.preventDefault();
				
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
		});
	}
});