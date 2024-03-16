<?php
	//$telegrambot='5095382938:AAECcojC-dHtdTp-duwdMRblwOBI9cOkAtE';
	//$telegramchatid=5095382938;
	
	// Telegram function which you can call
	function telegram($msg, $file) {
			global $telegrambot,$telegramchatid;
			/*$url='https://api.telegram.org/bot'.$telegrambot.'/sendMessage';$data=array('chat_id'=>$telegramchatid,'text'=>$msg);
			$options=array('http'=>array('method'=>'POST','header'=>"Content-Type:application/x-www-form-urlencoded\r\n",'content'=>http_build_query($data),),);
			$context=stream_context_create($options);
			$result=file_get_contents($url,false,$context);
			return $result;*/
			
			$bot_url    = "https://api.telegram.org/bot5095382938:AAECcojC-dHtdTp-duwdMRblwOBI9cOkAtE/";
			$url        = $bot_url . "sendPhoto?chat_id=" . $telegramchatid ;

			$post_fields = array('chat_id'   => $telegramchatid,
				'photo'     => new CURLFile(realpath($file)),
				'caption' => $msg
			);

			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				"Content-Type:multipart/form-data"
			));
			curl_setopt($ch, CURLOPT_URL, $url); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields); 
			$output = curl_exec($ch);
	}

	// Set your Bot ID and Chat ID.
	$telegrambot='5095382938:AAECcojC-dHtdTp-duwdMRblwOBI9cOkAtE';
	$telegramchatid=-1001665130713;

	// Function call with your own text or variable
	//telegram ("Hello World!");
?>