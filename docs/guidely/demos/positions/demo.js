$(function () {
	
	var anchors = ['top-left', 'top-middle', 'top-right', 'middle-left', 'middle-middle', 'middle-right', 'bottom-left', 'bottom-middle', 'bottom-right'];
	
	for (var i=0, l=anchors.length; i<l; i++) {
		guidely.add ({
			attachTo: '#demo'
			, title: 'Title'
			, text: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolo.'
			, anchor: anchors[i]
		});		
	}
	
	guidely.init ({ showOnStart: true, welcome: false, overlay: true, startTrigger: true });	
	//guidely.hideGuides ();
	//guidely.hideOverlay ();
});