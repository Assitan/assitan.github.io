'use strict';

$(document).ready(function() {

	/*
	 * @breadcrumb
	 */
	 $('.localisation_nav ul').addClass('col-md-10').addClass('col-md-offset-1');

	/*
	 * @flashbag message
	 */
	 $('.flashbag')
	 .animate({'height':'37px','opacity':1})
	 .delay(3200)
	 .animate({'height':'0','opacity':0});

	/*
	 * @tooltip Admin
	 */
	 $('.info_tip').tooltip();
	
});