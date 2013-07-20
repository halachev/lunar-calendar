var markDays = [];
$(document).ready(function () {


	system.init();
	

	$("a[href=#moon-zodiac]").click(function () {			
		system.init();		
		location = 'index.html';
	});

	//diets
	$('#menu-diet').click(function () {

		var data = {
			state : "0",
			method : 'moons'
		};
		$('#add-moon-diet').html("");
		system.LoadAjaxData("moon.php", data, $('#add-moon-diet'));

	});

	//massages
	$('#menu-massage').click(function () {

		var data = {
			state : "1",
			method : 'moons'
		};
		$('#add-moon-massage').html("");
		system.LoadAjaxData("moon.php", data, $('#add-moon-massage'));
	});

	//skins
	$('#menu-skin').click(function () {

		var data = {
			state : "1",
			method : 'moons'
		};
		$('#add-moon-skin').html("");
		system.LoadAjaxData("moon.php", data, $('#add-moon-skin'));
	});

});

