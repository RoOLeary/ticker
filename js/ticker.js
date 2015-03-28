jQuery(document).ready(function(){
	console.log( ticker_vars.date + ' ' + ticker_vars.time);

		if ((ticker_vars.date) == ''){
			ticker_vars.date = '2015-12-31';
			console.log('null' + ticker_vars.date);
		};

		if ((ticker_vars.time) == ''){
			ticker_vars.time = '23:59';
			console.log('null' + ticker_vars.date);
		};
	
		var targetElements = '.ticker';
		var now = new Date();
		var nowISO = now.toISOString();
		var target0 = new Date(ticker_vars.date + ' ' + ticker_vars.time + ' ' + "UTC");	
		var targetISO0 = target0.toISOString();


		if ( nowISO < targetISO0 ) {

			jQuery(targetElements).countdown({until: target0, format: "dHMS", compact: true, onExpiry: textUpdate});

		} 
		
	function textUpdate(){
		return 'Expired';

	}

});



		