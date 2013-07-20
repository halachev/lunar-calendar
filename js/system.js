
var currentDate = []; //store main date
var markDays; // get all phase dates


var system = {

	activityUrl : function () {
		return "http://lunar.nh.zonebg.com/js/";
	},

	init : function () {

		// stop double blink
		$(document).bind("mobileinit", function () {
			$.mobile.defaultPageTransition = 'none';
			$.mobile.defaultDialogTransition = 'none';
			$.mobile.useFastClick = true;
		});

		//loading when page showing ...
		$('div').bind('pagebeforeshow', function (event, ui) {
			//$(".ui-loader").css({"display": "block", "top": "252px !important" });
			$('body').addClass('ui-loading');

		});

		$('div').bind('pageshow', function (event, ui) {
			//$(".ui-loader").css({ "display": "none" });
			$('body').removeClass('ui-loading');
		});

		//init phonegap
		document.addEventListener('deviceready', onDeviceReady, false);

		function onDeviceReady() {
			//alert("onDeviceReady");
		}

		system.initLanguage();

		var date = $.datepicker.formatDate('d.m.yy', new Date());
		system.currentDateTime(date);
		
		system.initTodayMoon();
		system.InitcalendarMarkdays();
		system.moon_without_course();
		system.InitActivities();

	},

	InitActivities : function () {

		var activities = $.getActivities();
		
		$('#curr-activities-id').html("Деня е благоприятен за:");
				
		for (var a in activities) {
			var a = activities[a];			
			$('#curr-activities-id').append('<p>' + a.title + '</p>');
		}

	},

	initLanguage : function () {

		$('#en-lng').click(function () {

			var data = {
				lang : "en",
				method : 'initLang',
			}

			setLng(data);
			window.history.back();
		});

		$('#bg-lng').click(function () {

			var data = {
				lang : "bg",
				method : 'initLang',

			}

			setLng(data);
			window.history.back();
		});

		var data = localStorage.getItem("currLng");
		if (data != null) {
			var data = JSON.parse(data);
			setLng(data);
		} else {
			var data = {
				lang : "en",
				method : 'initLang',
			}

			setLng(data);
		}

		function setLng(data) {

			myAjax("lang.php", data, function (_data) {

				$('.title_app').text(_data.title_app);
				$('.home-text').text(_data.home);
				$('.setting-text').text(_data.setting);

				$('#appText').text(_data.appText);
				$('#dateInfo').text(_data.dateInfo);

				$('#moon_in').text(_data.moon_in);
				$('#moon-first-part-data').text(_data.first_quarter);
				$('#moon_phase').text(_data.moon_phase);
				$('#category-id').text(_data.category);
				$('#moon_without_course-data').text(_data.moon_without_course);
				$('#moon_lng').text(_data.moon_lng);
			
				$('#about-id').text(_data.about);
				$('#contact-id').text(_data.contact);

				localStorage.setItem("currLng", JSON.stringify(data));

				if (data.lang == "bg")
					$('#bg-lng').attr('checked', true);

				if (data.lang == "en")
					$('#en-lng').attr('checked', true);

			});

		}

	},

	moon_without_course : function () {

		var data = {
			state : 0,
			date : currentDate[0].currDate,
			method : 'moon_without_course'
		};

		$('#moon_without_course').hide();
		myAjax("sign.php", data, function (_data) {

			var moon_without_course = [];

			for (var i in _data) {

				var data = _data[i];

				var time = data.date.split('-')[2]; // parse date get only time
				var time = time.split(' ')[1];

				if ((data.short_text == '<<<') && (currentDate[1].currTime <= time)) {

					moon_without_course.push(_data[i - 1]); //from
					moon_without_course.push(data); // to

					break;
				}
			}

			if (moon_without_course.length > 0) {
				$('#moon_without_course').show();
				$('#moon_without_course').append('<span>От: ' + moon_without_course[0].date + ' <br/> До: ' + moon_without_course[1].date + ' </span>');
			}
		})
	},

	InitcalendarMarkdays : function () {

		markDays = null;
		markDays = $.calendarMarkDays(currentDate[0].currDate);

		$('#datepicker').datepicker({
			showOn : "button",
			buttonImage : "http://jqueryui.com/resources/demos/datepicker/images/calendar.gif",
			dateFormat : 'd.m.yy',
			firstDay : '1',
			showOtherMonths : 'true',
			onSelect : function (_date) {
				selectedDate = true;
				system.currentDateTime(_date);				
				system.initTodayMoon();	
				system.InitActivities();				
				window.history.back();
			},
			beforeShow : changeDayText,
			beforeShowDay : daysToMark,
			onChangeMonthYear : function (y, m, i) {

				var d = i.selectedDay;
				newdate = (new Date(y, m - 1, d));
				$(this).datepicker('setDate', newdate);

				//calculate new phase days by current year and month ...
				date = $.datepicker.formatDate('yy-mm-dd', newdate);
				markDays = null;
				markDays = $.calendarMarkDays(date);
				changeDayText();
			}
		})

		function changeDayText() {

			setTimeout(function () {
				$("table.ui-datepicker-calendar a").each(function () {

					var newday = $(this).html();

					for (i in markDays) {
						var _data = markDays[i];

						var day = _data.date.split('-');
						day = day[2].split(' ');

						var _char = day[0][0];
						if (_char == 0)
							day = day[0][1];
						else
							day = day[0];

						if (day == newday) {
							////$('table.ui-datepicker-calendar .markedDay1').append('<span class="phase-text">' + _data.title + '</span>');
							$(this).html('<span class="phase-text">' + _data.title + '</span>' + newday);
						}
					}

				})
			}, 100); //allows calendar to render
		}

		function daysToMark(date) {

			date = $.datepicker.formatDate('yy-mm-dd', date);

			for (i in markDays) {
				var _data = markDays[i];

				var newdate = _data.date.split(' ');
				newdate = newdate[0];

				if (newdate == date) {
					return [true, 'markedDay1', ""];
				}

			}

			return [true, 'markedDay2', ""];

			/*var specialDays = {'08/13/2013': 'markedDay1', '08/14/2013': 'markedDay1'};

			date = $.datepicker.formatDate('mm/dd/yy', date);

			var special = specialDays[date];

			return [special == 'markedDay1', special];
			 */
		}

	},

	initTodayMoon : function () {

		var data = $.getTodayMoon();		
		var zodiac = data[0].zodiac;
		$('#moon-zodiac-data').html('<span style="color: rgb(190, 31, 159);">' + zodiac + '</span>')
		
	},

	currentDateTime : function (date) {

		//date
		currentDate = [];

		var currDate = {
			currDate : date
		};
		currentDate.push(currDate);

		//time
		var fullTime = new Date().toString().split(' ')[4];
		var currTime = {
			currTime : fullTime
		};
		currentDate.push(currTime);

		$('#current-data').html('<span style="color: red;">' + date + '<br/></span>');

	},

	LoadAjaxData : function (_file, data, _element) {
		myAjax(_file, data, function (_data) {

			for (var i in _data) {

				var moon = _data[i];

				var collapsible = $('<div data-role="collapsible">');
				collapsible.append('<h2>' + moon.title + '</h2>');
				collapsible.append('<p>' + moon.descr + '</p>');
				_element.append(collapsible);
				_element.trigger('create');

			}

		});
	}

}

// my ex jquery
jQuery.extend({

	calendarMarkDays : function (_date) {
		
		if (markDays != null)
			return markDays;

		var result;

		var data = {
			date : _date,
			method : "intiPhase"
		}

		
		myAjax("phase.php", data, function (_data) {

			result = _data;
			
		})
		
		markDays = result;

		return markDays;
	},

	baseActivity : function () {

		var result;
			
		var data = {
			date: currentDate[0].currDate,
			method : "do_phase"
		}

		myAjax('calc_phase.php', data, function (_data) {
				
			result = _data;

		});

		return result;

	},

	makeActivities : function (data) {

		var activities = [];
		var result;
		var currActivity = $.baseActivity();

		//check for current sign
		function findInSigns(_signs) {

			var hasSign = false;
			var data = $.getTodayMoon();
			var zodiac = data[0].zodiac;

			var parsed_signs = _signs.split(',');
		
			for (var s in parsed_signs) {
				var sign = parsed_signs[s];

				if ($.trim(sign) == $.trim(zodiac)) {
					hasSign = true;
				}
			}

			return hasSign;
		}
		
		//get all activities
		for (var i in data) {
			var myActivities = data[i];

			for (var j in myActivities) {
				var a = myActivities[j];

				var hasSign = findInSigns(a.signs);
				
				if ((a.waning == currActivity.phase)

					 && (
						(a.percent_start <= currActivity.percent)
						 || (a.percent_end >= currActivity.percent)
						 || (hasSign))) {

					activities.push(a);

				}
			}
		}
		
		return activities;

	},

	getActivities : function () {
		var result;
		
		$.ajax({
			url : system.activityUrl() + 'activities.js',
			dataType : "json",
			async : false,
			success : function (data) {
				
				result = $.makeActivities(data);
				
			},

			error : function (err) {
				alert("error method getActivities");
			}

		});
		
		return result;
	},

	getTodayMoon : function () {
		
		var result;
		var data = {
			state : 0,
			date : currentDate[0].currDate,
			time : currentDate[1].currTime,
			method : 'Todaysign'
		};

		myAjax("sign.php", data, function (_data) {

			result = _data;
		});

		return result;
	},
	
	showLoading: function (){
		$('div').bind('pagebeforeshow', function (event, ui) {
			//$(".ui-loader").css({"display": "block", "top": "252px !important" });
			$('body').addClass('ui-loading');

		});
	},
	
	hideLoading: function() {
		$('div').bind('pageshow', function (event, ui) {
			//$(".ui-loader").css({ "display": "none" });
			$('body').removeClass('ui-loading');
		});

	}

});
