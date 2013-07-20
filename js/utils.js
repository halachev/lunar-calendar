
var serviceURL = "http://lunar.nh.zonebg.com/service";

//public functions out of objects
function myAjax(_file, _data, results) {
		
	$.ajax({
		url : serviceURL + '/' + _file,
		type : 'POST',
		dataType : "json",
		data : _data,
		async: false,
		success : function (data) {
			results(data);
		},

		error : function (err) {
			alert("error");
		}

	});

}