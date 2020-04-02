<?php

//include('/var/www/html/db.php');
//$conn = db_connect_100();

function error_msg($text) {
     $hello_var = 'Problem: '; //example of addon to beginning
     $goodbye_var = ' goodbye'; //example of addon to end
     die($hello_var.'<br />'.$text.'<br />'.$goodbye_var);
} 


$url = "http://www.mdr.de/mdr1-radio-sachsen-anhalt/podcast/angedacht/audiogalerie200-podcast.xml";

class MimeStreamWrapper
{
    const WRAPPER_NAME = 'mime';
    public $context;
    private static $isRegistered = false;
    private $callBackFunction;
    private $eof = false;
    private $fp;
    private $path;
    private $fileStat;
    private function getStat()
    {
        if ($fStat = fstat($this->fp)) {
            return $fStat;
        }

        $size = 100;
        if ($headers = get_headers($this->path, true)) {
            $head = array_change_key_case($headers, CASE_LOWER);
            $size = (int)$head['content-length'];
        }
        $blocks = ceil($size / 512);
        return array(
            'dev' => 16777220,
            'ino' => 15764,
            'mode' => 33188,
            'nlink' => 1,
            'uid' => 10000,
            'gid' => 80,
            'rdev' => 0,
            'size' => $size,
            'atime' => 0,
            'mtime' => 0,
            'ctime' => 0,
            'blksize' => 4096,
            'blocks' => $blocks,
        );
    }
    public function setPath($path)
    {
        $this->path = $path;
        $this->fp = fopen($this->path, 'rb') or die('Cannot open file:  ' . $this->path);
        $this->fileStat = $this->getStat();
    }
    public function read($count) {
        return fread($this->fp, $count);
    }
    public function getStreamPath()
    {
        return str_replace(array('ftp://', 'http://', 'https://'), self::WRAPPER_NAME . '://', $this->path);
    }
    public function getContext()
    {
        if (!self::$isRegistered) {
            stream_wrapper_register(self::WRAPPER_NAME, get_class());
            self::$isRegistered = true;
        }
        return stream_context_create(
            array(
                self::WRAPPER_NAME => array(
                    'cb' => array($this, 'read'),
                    'fileStat' => $this->fileStat,
                )
            )
        );
    }
    public function stream_open($path, $mode, $options, &$opened_path)
    {
        if (!preg_match('/^r[bt]?$/', $mode) || !$this->context) {
            return false;
        }
        $opt = stream_context_get_options($this->context);
        if (!is_array($opt[self::WRAPPER_NAME]) ||
            !isset($opt[self::WRAPPER_NAME]['cb']) ||
            !is_callable($opt[self::WRAPPER_NAME]['cb'])
        ) {
            return false;
        }
        $this->callBackFunction = $opt[self::WRAPPER_NAME]['cb'];
        $this->fileStat = $opt[self::WRAPPER_NAME]['fileStat'];

        return true;
    }
    public function stream_read($count)
    {
        if ($this->eof || !$count) {
            return '';
        }
        if (($s = call_user_func($this->callBackFunction, $count)) == '') {
            $this->eof = true;
        }
        return $s;
    }
    public function stream_eof()
    {
        return $this->eof;
    }
    public function stream_stat()
    {
        return $this->fileStat;
    }
    public function stream_cast($castAs)
    {
        $read = null;
        $write  = null;
        $except = null;
        return @stream_select($read, $write, $except, $castAs);
    }
}

$path = $url;
echo "File: ", $path, "\n";
$wrapper = new MimeStreamWrapper();
$wrapper->setPath($path);
$fInfo = new finfo(FILEINFO_MIME);
$file_mime = $fInfo->file($wrapper->getStreamPath(), FILEINFO_MIME_TYPE, $wrapper->getContext());
echo $file_mime;

/*
$remoteFile = $value;
$ch = curl_init($remoteFile);
curl_setopt($ch, CURLOPT_NOBODY, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); //not necessary unless the file redirects (like the PHP example we're using here)
$data = curl_exec($ch);
$contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
curl_close($ch);
    if ($data === false) {
      echo 'cURL failed';
      exit;
    }
$status = 'unknown';
echo $contentType;
if(($contentType != "application/rss+xml") || ($contentType != "application/rdf+xml") || ($contentType != "application/atom+xml") || ($contentType != "application/xml") || ($contentType != "text/xml") || ($contentType != "text/rss+xml")) {
$red = "redis-cli -n 14 DEL ".$value;  
system($red);
}

preg_match_all('!(http)(s)?:\/\/[a-zA-Z0-9.?%=&_/]+!', $page_contents, $match);
//preg_match_all($regex_2, $page_contents, $match);
//print_r($match);
$match = array_unique($match);
foreach($match[0] as $value2) {
	$value2 = str_replace("%%", "", $value2);
    $value2 = urldecode($value2);
    $value2 = str_replace("%", "", $value2);
    $result = $value2;
    $title = $value2;
    $keyurl = substr($value2, 0, 200);
    $host = "";
    $search_string = "";
    $mysqltime = "";
	//echo $result;
	$mystring = $result;
	$findme   = '.png';
	$pos = strpos($mystring, $findme);
}
*/

?>
