<?php
/**
 * PHPLock������
 * ���������������php�ڲ���ʱ���������
 * �������ļ�����ģ��������֮���������Ч�ʲ��Ƿǳ��ߡ�����ļ��������ڴ��У����Դ�����Ч�ʡ�
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
	 * ���캯��
	 *
	 * @param string $path ���Ĵ��Ŀ¼����"/"��β
	 * @param string $name �����ƣ�һ���ڶ���Դ������ʱ�򣬻�����һ�����֣�������ͬ����Դ���Բ����Ľ��С�
	 */
	public function __construct($path, $name) {
		$this->path = $path . md5 ( $name ) . '.txt';
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