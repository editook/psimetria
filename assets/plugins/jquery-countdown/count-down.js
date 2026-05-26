$(function() {
	"use strict";
	const fecha = new Date();
	//Set your date
	$('#count-down').countDown({
		targetDate: {
			'day': fecha.getDate()+2,
			'month': fecha.getMonth() + 1,
			'year': fecha.getFullYear(),
			'hour': 0,
			'min': 0,
			'sec': 0
		},
		omitWeeks: false
	});

});