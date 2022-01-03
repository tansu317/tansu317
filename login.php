<?php
    require_once "../utility/connect.php";


if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $nrp = $_POST['nrp'];
        $password = $_POST['password'];

        $url = "https://www.google.com/recaptcha/api/siteverify";
		$data = [
			'secret' => "6Lfp8ZEbAAAAABmzQsY-NtXq4nA5vxfXMJocBvDY",
			'response' => $_POST['token'],
			'remoteip' => $_SERVER['REMOTE_ADDR']
		];

		$options = array(
		    'http' => array(
		      'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		      'method'  => 'POST',
		      'content' => http_build_query($data)
		    )
		  );

		$context  = stream_context_create($options);
  		$response = file_get_contents($url, false, $context);

		$res = json_decode($response, true);
		if($res['success'] != true || $res['score'] < 0.5) {
            header("location: ../index.php?status=1");
            //echo $response;
            exit();
		}
        
        $imap = false;
        // $user=$conn->real_escape_string($_POST['nrp']);
        // $pass=$conn->real_escape_string($_POST['password']);
        // $user = strtolower($user);
        // $imap=false;
        // $timeout=30;
        // $fp = fsockopen ($host='john.petra.ac.id',$port=110,$errno,$errstr,$timeout);
        // $errstr = fgets ($fp);
        // if (substr ($errstr,0,1) == '+'){
        //     fputs ($fp,"USER ".$user."\n");
        //     $errstr = fgets ($fp);
        //     if (substr ($errstr,0,1) == '+'){
        //         fputs ($fp,"PASS ".$pass."\n");
        //         $errstr = fgets ($fp);
        //         if (substr ($errstr,0,1) == '+'){
        //             $imap=true;
        //         }
        //     }
        // }

        if ($nrp == $password) {
            $imap = true;            
        } else {
            $imap = false;            
        }

        if(!$imap)
        {
            header("location: ../index.php?status=2");
            exit();
        }

        $_SESSION['nrp'] = $nrp;
        header("location: ../index.php");
    }
    else
    {
        header("location: ../index.php?status=0");
        exit();
    }
?>