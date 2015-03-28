jQuery(document).ready(function(){

	//alert(social_vars.alert);
	// console.log( social_vars.alert );
	console.log( ticker_vars.date + ' ' + ticker_vars.time);
	// console.log( social_vars.time );

	var targetElements = '.ticker-plugin';


	var now = new Date();

	var nowISO = now.toISOString();

	var fallback = new Date(now.getTime() + 24 * 60 * 60 * 1000);
	fallback.setHours(12);
	fallback.setMinutes(59);
	fallback.setSeconds(59);
	fallback.getTimezoneOffset();



	var target0 = new Date(ticker_vars.date + ' ' + ticker_vars.time + ' ' + "UTC");
	var targetISO0 = target0.toISOString();

	// var target1 = new Date("24 October 2014 17:00 UTC");
	// var targetISO1 = target1.toISOString();

	if ( nowISO < targetISO0 ) {

		jQuery(targetElements).countdown({until: target0, format: "dHMS", compact: true, onExpiry: textUpdate});

	} 

	function textUpdate(){
		return 'Expired';

	}

});



		