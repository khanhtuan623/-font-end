<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="description" content="Xử Lý Tìm Kiếm Bất Động Sản">
  <meta name="author" content="NewAI [VN]">
  <script src='https://www.google.com/recaptcha/api.js'></script>
  <link rel="icon" href="../../favicon.png" type="image/x-icon" />
  <link rel="shortcut icon" href="../../favicon.png" type="image/x-icon" />
  <title>Xử Lý Tìm Kiếm Bất Động Sản :: DEMO :: NewAI [VN]</title>
  <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js?lang=xml&amp;skin=sunburst"></script>
  <style>
    body {
      font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;
      font-size: 125%;
    }
    .button {
        background-color: #4CAF50;
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
    }

    .text-xs-center {
        text-align: center;
    }

    .g-recaptcha {
        display: inline-block;
    }
  </style>
</head>

<body>
  <?php date_default_timezone_set('Asia/Ho_Chi_Minh'); ?>
  
  <?php
    $response = '';
    $captcha;
		
		if(isset($_POST['g-recaptcha-response']))
		{
      $captcha = $_POST['g-recaptcha-response'];
      
      if(!$captcha)
			{
        //echo '<script language="javascript">';
        //echo 'alert("Please complete the captcha!")';
        //echo '</script>';
        header("Refresh:0");
        exit;
			}
			
			$secretKey = "6LfG9FwUAAAAAExMgmU1EcOU6QjhK84y9i93Olp7";
			$ip = $_SERVER['REMOTE_ADDR'];
			$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
			$responseKeys = json_decode($response,true);
			
      if($captcha == true && intval($responseKeys["success"]) == 1)
      {
        if (isset($_POST['input']))
        {
          //$url = 'http://localhost:8080/real-estate/rest/query/parser/';
          $url = 'http://171.244.40.73:1997/real-estate/rest/query/parser';
          //$url = 'http://api-1.newai.vn:3618/real-estate/rest/query/parser';
          $query = $_POST['input'];
          $key = 'b54152f22343da2dba4023ce5a4e22296c4f7cc4';

          $data = array('query'=>$query,'key'=>$key);
          $data_json = json_encode($data);

          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          $response  = curl_exec($ch);
          curl_close($ch);
        }
      }
    }
	?>

  <h1 style="text-align:center;">Xử Lý Tìm Kiếm Bất Động Sản</h1>

  <div id="InputForm" style="margin-top:100px; text-align:center;">
    <form id="InputForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <p style="text-align:center;">
        <textarea required style="font-size: 24px;resize: none;" name="input" cols="75" rows="1" placeholder="Vui lòng nhập câu truy vấn ..."></textarea>
      </p>

      <div class="text-xs-center">
        <div class="g-recaptcha" data-sitekey="6LfG9FwUAAAAAMgx5OrmgKgj2xTKegxgUw5CKwTA"></div>
      </div>

      <p style="text-align:center;">
        <button id="submitBtn" type="submit" class="button">Phân tích</button>
      </p>
    </form>
  </div>

  <div style="margin-top:100px;">
      <p>
      <pre class="prettyprint">
        <?php
          if($response != '')
            var_dump(json_decode($response, true));
        ?>
      </pre>
      </p>
  </div>
  

</body>
