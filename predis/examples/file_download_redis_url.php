
<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require __DIR__.'/shared.php';

use Predis\Collection\Iterator;

// Starting from Redis 2.8, clients can iterate incrementally over collections
// without blocking the server like it happens when a command such as KEYS is
// executed on a Redis instance storing millions of keys. These commands are:
//
//   - SCAN (iterates over the keyspace)
//   - SSCAN (iterates over members of a set)
//   - ZSCAN (iterates over members and ranks of a sorted set)
//   - HSCAN (iterates over fields and values of an hash).

// Predis provides a specialized abstraction for each command based on standard
// SPL iterators making it possible to easily consume SCAN-based iterations in
// your PHP code.
//
// See http://redis.io/commands/scan for more details.
//

// Create a client using `2.8` as a server profile (needs Redis 2.8!)
$client = new Predis\Client($single_server1, array('profile' => '2.8'));
$client1 = new Predis\Client($single_server2, array('profile' => '2.8'));


// Prepare some keys for our example

include('/var/www/html/db.php');
$conn = db_connect_100();

function fetchUrl($uri) {
    $handle = curl_init();
    curl_setopt($handle, CURLOPT_URL, $uri);
    curl_setopt($handle, CURLOPT_POST, false);
    curl_setopt($handle, CURLOPT_BINARYTRANSFER, false);
    curl_setopt($handle, CURLOPT_HEADER, true);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 10);
    $response = curl_exec($handle);
    $hlength  = curl_getinfo($handle, CURLINFO_HEADER_SIZE);
    $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
    $body     = substr($response, $hlength);
    // If HTTP response is not 200, throw exception
    return $body;
}

function namefile()
{
    return time() ."_". substr(md5(microtime()), 0, mt_rand(10, 10));
}

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

function get_extension($file,$length=-1)
{
	$p = strrpos($file,".");
	$p++;
		if($length!=-1)
		{
			$ext = substr($file,$p,$length);
		}
		if($length==-1)
		{
			$ext = substr($file,$p);
		}
	$ext = strtolower($ext);
	return $ext;
}

$d = 0;
do {
$d = $d + 1;
$name = namefile();
$response = $client1->executeRaw(["RANDOMKEY"]);
echo $response;
$url = $response;
//echo $url;
$urlnew = trim($url, "'");
echo $urlnew;
$red = "redis-cli -n 13 DEL ".$urlnew;
system($red);
echo $red;

$date = date("Y-m-d");
$file_folder_name = "/home/remote/file/".$date;
mkdir($file_folder_name, 0777);
chmod($file_folder_name, 0777);
$destination_file = "/home/remote/file/".$date."/".$name;
mkdir($destination_file, 0777);
chmod($destination_file, 0777);
$destination_file = "/home/remote/file/".$date."/".$name."/".$name;
$curl = "curl -L ".$urlnew." > ".$destination_file;
system($curl);

$path = $destination_file;

echo "File: ", $path, "\n";
$wrapper = new MimeStreamWrapper();
$wrapper->setPath($path);

$fInfo = new finfo(FILEINFO_MIME);

$file_mime = $fInfo->file($wrapper->getStreamPath(), FILEINFO_MIME_TYPE, $wrapper->getContext());
echo $file_mime;

//$filetype = pathinfo(parse_url($urlnew)['path'], PATHINFO_EXTENSION);

$filetype = get_extension($urlnew);

$file_size = "";
$mysqltime = date("Y-m-d H:i:s");
$file_mime_type = $file_mime;
$file_extension = $filetype;
$file_title = "";
$urlfixed = $urlnew;
$seoterm = "";
$short_file_name = "file";

if ($stmt = mysqli_prepare($conn, "INSERT INTO `docunator`.`file` (`system_file_name`,`file_size`,`file_timestamp`,`file_mime_type`,`file_extension`, `file_title`, `url`, `seoterm`, `short_name`) VALUES (?,?,?,?,?,?,?,?,?)")); {
mysqli_stmt_bind_param($stmt, "sssssssss", $name, $file_size, $mysqltime, $file_mime_type, $file_extension, $file_title, $urlfixed, $seoterm, $short_file_name);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
}


}  while ($d < 2);


/*
$query = "SELECT `counter`, `url` FROM `scraper`.`html_url` WHERE `counter` = '".$rand."' `checked` IS NULL limit 1;";

if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $count, $url);
    while (mysqli_stmt_fetch($stmt)) {
$client->set($count, $url); 
$value = $client->get($count);
//var_dump($value);
print_r($value);
    }
    mysqli_stmt_close($stmt);
}
*/

?>
