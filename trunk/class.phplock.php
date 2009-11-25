<?php
/**
 * PHPLock������
 * ���������������php�ڲ���ʱ���������
 * �������ļ�����ģ��������֮���������Ч�ʲ��Ƿǳ��ߡ�����ļ��������ڴ��У����Դ�����Ч�ʡ�
 * PHPLOCK��ʹ�ù����У�����ָ����Ŀ¼����$hashNum���ļ�����������Ӧ���ȵ�������ͬ��֮����Բ���ִ�С�
 * ���е�����mysql��innodb���м�������ͬ�еĸ��¿��Բ�����ִ�С�
 * @link http://code.google.com/p/phplock/
 * @author sunli
 * @blog http://sunli.cnblogs.com
 * @svnversion  $Id$
 * @version v1.0 beta1
 * @license Apache License Version 2.0
 * @copyright  sunli1223@gmail.com
 */

class PHPLock {
	/**
	 * ���ļ�·��
	 *
	 * @var String
	 */
	private $path = null;
	/**
	 * �ļ����
	 *
	 * @var resource 
	 */
	private $fp = null;
	/**
	 * �������ȿ��ƣ����õ�Խ������ԽС
	 *
	 * @var int
	 */
	private $hashNum = 100;
	/**
	 * ���캯��
	 *
	 * @param string $path ���Ĵ��Ŀ¼����"/"��β
	 * @param string $name �����ƣ�һ���ڶ���Դ������ʱ�򣬻�����һ�����֣�������ͬ����Դ���Բ����Ľ��С�
	 */
	public function __construct($path, $name) {
		$this->path = $path . ($this->mycrc32 ( $name ) % $this->hashNum) . '.txt';
	}
	/**
	 * crc32�ķ�װ
	 *
	 * @param string $string
	 * @return int
	 */
	private function mycrc32($string) {
		$crc = abs ( crc32 ( $string ) );
		if ($crc & 0x80000000) {
			$crc ^= 0xffffffff;
			$crc += 1;
		}
		return $crc;
	}
	/**
	 * ��ʼ�������Ǽ���ǰ�ı��벽��
	 * ��һ���ļ�
	 *
	 */
	public function startLock() {
		$this->fp = fopen ( $this->path, "w+" );
	}
	/**
	 * ��ʼ����
	 *
	 * @return bool �����ɹ�����true,ʧ�ܷ���false
	 */
	public function lock() {
		if ($this->fp === false) {
			return false;
		}
		return flock ( $this->fp, LOCK_EX );
	}
	/**
	 * �ͷ���
	 *
	 */
	public function unlock() {
		if ($this->fp !== false) {
			flock ( $this->fp, LOCK_UN );
			clearstatcache ();
		}
	}
	/**
	 * ����������
	 *
	 */
	public function endLock() {
		fclose ( $this->fp );
	}
}

?>