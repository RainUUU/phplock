<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
<title>�򵥲���</title>
</head>

<body>
<?php

/**
 * �������ӣ�ͬʱ������ҳ�棬���Է�������ͬʱֻ��һ��ҳ����뵽������Ĵ���
 * @link http://code.google.com/p/phplock/
 * @author sunli
 * @blog http://sunli.cnblogs.com
 * @svnversion  $Id$
 * @version v1.0 beta1
 * @license Apache License Version 2.0
 * @copyright  sunli1223@gmail.com
 */

require 'class.phplock.php';

$lock = new PHPLock ( 'lock/', 'lockname' );
$lock->startLock ();
$status = $lock->Lock ();
if (! $status) {
	echo "����ʧ��";
	exit ();
}
//process code
echo "<span>������</span><br />\r\n";
ob_end_flush ();
flush ();
ob_flush ();
sleep ( 10 ); //����20�룬ģ�Ⲣ������
echo "ִ�����<br />\r\n";
$lock->unlock ();
$lock->endLock ();
echo "�ͷ������<br />\r\n";
/**
 * cache����
 *
 * @return $array
 */
function getCache($key) {
	return $cache;
}
/**
 * ���û���
 *
 * @param string $key
 * @param array $value
 */
function setCache($key, $value) {

}
$key = 'cachekey';
$cache = getCache ( $key );
if (! $cache) {
	//���治���ڣ���ʼ����
	$lock = new PHPLock ( 'lock/', $key );
	$lock->startLock ();
	$lock->startLock ();
	//�����жϻ����Ƿ������ݣ������Ѿ��з����ؽ������ˣ��Ͳ���Ҫ�ٴβ�ѯ���ݿ�
	$cache = getCache ( $key );
	if (! $cache) {
		//���ݿ��ѯ����,����ʡ����
		$data = $dbdata;
		setCache ( $key, $data );
	}
	//�ͷ���
	$lock->unlock ();
	$lock->endLock ();
}

?>
</body>
</html>