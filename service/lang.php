<?php
   

	define ('initLang', initLang);
	

	class Lang 
	{
				
		private $lang;
		private $method;
				
	    function __construct() {
		
			

			if (isset($_POST['lang']))
				$this->lang = $_POST['lang'];					
								
			if (isset($_POST['method']))
				$this->method = $_POST['method'];
			
			if (isset($_POST['method']))
			switch ($this->method) {
				
				case initLang:
					$this->initLang();  
				break;
				
				case moon_without_course:
					$this->moon_without_course();  
				break;
				
				break;
				default:
					throw new Exception('Invalid REQUEST_METHOD');
					break;
			}
			
		}
		
		
		function initLang()
		{
			if ($this->lang == "en")
				$data = array(
					"title_app"=>"Lunar Calendar", 
					"home"=>"Home", 
					"setting"=>"Options", 
					
					"appText"=>"Lucan calendar for everyday!",
					"dateInfo"=>"Information about:", 
					
					"moon_in"=>"Moon in:", 
					"first_quarter"=>"First quarter",
					"moon_phase"=>"Moon phases",
					"moon_without_course"=>"Мoon without course",
					"category"=>"Category",
					"moon_lng"=>"Language",
					"about"=>"About",
					"contact"=>"Contact",
					
					
				);
			
			else if ($this->lang == "bg")
				$data = array(
					"title_app"=>"Лунен календар", 
					"home"=>"Начало", 
					"setting"=>"Опции", 
					
					"appText"=>"Лунен календар за вашето ежедневие!",
					"dateInfo"=>"Информация за:",

					"moon_in"=>"Луна в:", 	
					"first_quarter"=>"Първа четвърт",
					"moon_phase"=>"Фази на луната",
					"moon_without_course"=>"Луна без курс",
					"category"=>"Категории",
					"moon_lng"=>"Език",
					
					
					"about"=>"За нас",
					"contact"=>"Контакти",
					
				);
				
			echo json_encode($data);
		}
				
	}
		
	$Lang = new Lang();
					
	
?>


