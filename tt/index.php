<?php
include("inc.php");

//CODIGO DO AUTODJ
$fp2 = fsockopen($host, $port, $errno, $errstr);
if(!$fp2)
{
	$success2 = 2;
}
if($success2 != 2)
{
	fputs($fp2,"GET /7.html HTTP/1.0\r\nUser-Agent: XML Getter (Mozilla Compatible)\r\n\r\n");
	while(!feof($fp2))
	{
		$pg2 .= fgets($fp2, 1000);
	}
	fclose($fp2);
	$pag = ereg_replace(".*<body>", "", $pg2);
	$pag = ereg_replace("</body>.*", ",", $pag); 
	$numbers = explode(",",$pag);
	// Música
	$currentlisteners = $numbers[0];
	$musica = $numbers[6];
}

//CODIGO DO TWITTER
class tweet_bot
{
    function oauth()
    {
        require_once("twitteroauth.php");
        $con = new TwitterOAuth($this->api_key, $this->api_secret, $this->access_token, $this->access_token_secret);
        return $con;
    }
    function tweet($text)
    {
        $con = $this->oauth();
        $status = $con->post('statuses/update', array('status' => $text));
        return $status;
    }
    function setKey($api_key,$api_secret,$access_token,$access_token_secret)
    {
        $this->api_key = $api_key;
        $this->api_secret = $api_secret;
        $this->access_token = $access_token;
        $this->access_token_secret = $access_token_secret;
    }
}

//CODIGO FINAL
$tweet= new tweet_bot;
$tweet->setKey($api_key, $api_secret,$access_token , $access_token_key);
$result = $tweet->tweet("Tocando Agora na The Hits: ".$musica.", Ouça em: https://goo.gl/xzbtMi");
Print_r($result);
?>