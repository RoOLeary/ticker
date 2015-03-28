jQuery(document).ready(function(){
	console.log( ticker_vars.date + ' ' + ticker_vars.time);

		if ((ticker_vars.date) == ''){
			ticker_vars.date = '2015-12-31';
			//console.log(ticker_vars.date);
		};

		if ((ticker_vars.time) == ''){
			ticker_vars.time = '23:59';
			//console.log(ticker_vars.time);
		};
	
		if ((ticker_vars.enddate) == ''){
			ticker_vars.enddate = '2015-12-31';
			//console.log(ticker_vars.date);
		};

		if ((ticker_vars.endtime) == ''){
			ticker_vars.endtime = '23:59';
			//console.log(ticker_vars.time);
		};


		var targetElements = '.ticker';
		var now = new Date();
		var endtarget = new Date(ticker_vars.enddate + ' ' + ticker_vars.endtime + ' ' + "UTC");	
		var nowISO = now.toISOString();
		var target0 = new Date(ticker_vars.date + ' ' + ticker_vars.time + ' ' + "UTC");	
		var targetISO0 = target0.toISOString();

		function restart() { 
       		console.log('Timed out');     
       		jQuery('.ticker').countdown('destroy');
	    	jQuery('.ticker').countdown({until: endtarget, layout:'{d<}{dn} {dl} and {d>}'+ '{hn} {hl}, {mn} {ml}, {sn} {sl}'});
    	    console.log('Executed');
    	}

		if ( nowISO < targetISO0 ) {

			jQuery(targetElements).countdown({until: target0, format: "dHMS", compact: true, onExpiry: restart});

		} else {
			jQuery(targetElements).countdown({until: endtarget, layout:'{d<}{dn} {dl} and {d>}'+ '{hn} {hl}, {mn} {ml}, {sn} {sl}', onExpiry: restart})
		}
			
});



		

