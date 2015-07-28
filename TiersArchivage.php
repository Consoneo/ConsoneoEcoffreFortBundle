<?php

namespace Consoneo\Bundle\EcoffreFortBundle;

use Consoneo\Bundle\EcoffreFortBundle\Entity\LogQuery;
use Consoneo\Bundle\EcoffreFortBundle\Event\CertEvent;
use Consoneo\Bundle\EcoffreFortBundle\Event\DelEvent;
use Consoneo\Bundle\EcoffreFortBundle\Event\GetEvent;
use Consoneo\Bundle\EcoffreFortBundle\Event\GetPropEvent;
use Consoneo\Bundle\EcoffreFortBundle\Event\ListEvent;
use Consoneo\Bundle\EcoffreFortBundle\Event\PutEvent;
use Consoneo\Bundle\EcoffreFortBundle\Event\SafeGetPropEvent;

class TiersArchivage extends ECoffreFort
{
	const PUT_URI            =   'https://www.e-coffrefort.fr/ta/put.php';
	const GET_URI            =   'https://www.e-coffrefort.fr/ta/get.php';
	const CERT_URI           =   'https://www.e-coffrefort.fr/ta/get_cert.php';
	const LIST_URI           =   'https://www.e-coffrefort.fr/ta/list.php';
	const DEL_URI            =   'https://www.e-coffrefort.fr/ta/del.php';
	const GETPROP_URI        =   'https://www.e-coffrefort.fr/ta/getprop.php';
	const SAFEGETPROP_URI    =   'https://www.e-coffrefort.fr/ta/safegetprop.php';

	const HASH_MD5      =   'MD5';

	const RTNTYPE_TXT   =   'TXT';
	const RTNTYPE_XML   =   'XML';

	/**
	 * @var String
	 */
	private $safe_room;

	/**
	 * @var String
	 */
	private $user_login;

	/**
	 * @var String
	 */
	private $user_password;

	/**
	 * @param $safe_room
	 * @param $safe_id
	 * @param $user_login
	 * @param $user_password
	 */
	public function __construct($safe_room, $safe_id, $user_login, $user_password)
	{
		$this->safe_room        =   $safe_room;
		$this->safe_id          =   $safe_id;
		$this->user_login       =   $user_login;
		$this->user_password    =   $user_password;
	}

	/**
	 * API de Dépôt
	 *
	 * @param String $fileName Nom du fichier
	 * @param String $path chemin du document source
	 * @return mixed
	 */
	public function putFile($fileName, $path)
	{
		$post = [
			'SAFE_ROOM'         =>  $this->safe_room,
			'SAFE_ID'           =>  $this->safe_id,
			'USER_LOGIN'        =>  $this->user_login,
			'USER_PASSWD'       =>  $this->user_password,
			'FILE_NAME'         =>  $fileName,
			'FILE_HASH'         =>  md5_file($path),
			'FILE_HASH_TYPE'    =>  self::HASH_MD5,
			'DOCATTACH'         =>  curl_file_create($path),
			'RTNTYPE'           =>  self::RTNTYPE_TXT,
		];

		$c = curl_init();
		curl_setopt($c, CURLOPT_URL, self::PUT_URI);
		curl_setopt($c, CURLOPT_TIMEOUT, 30);
		curl_setopt($c, CURLOPT_POST, true);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($c, CURLOPT_POSTFIELDS, $post);
		$response = curl_exec($c);

		if (curl_error($c)) {
			$response = curl_error($c);
		} else {
			$this->dispatcher->dispatch(PutEvent::NAME, new PutEvent(LogQuery::TA, $this->safe_room, $fileName, $this->safe_id, null, $response));
		}

		return $response;
	}

	/**
	 * API de Consultation
	 *
	 * @param String $iua Identifiant Archive Unique
	 * @return mixed
	 */
	public function getFile($iua)
	{
		$post = [
			'SAFE_ROOM'         =>  $this->safe_room,
			'SAFE_ID'           =>  $this->safe_id,
			'USER_LOGIN'        =>  $this->user_login,
			'USER_PASSWD'       =>  $this->user_password,
			'FILE_IUA'          =>  $iua,
			'RTNTYPE'           =>  self::RTNTYPE_TXT,
		];

		$c = curl_init();
		curl_setopt($c, CURLOPT_URL, self::GET_URI);
		curl_setopt($c, CURLOPT_TIMEOUT, 30);
		curl_setopt($c, CURLOPT_POST, true);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($c, CURLOPT_POSTFIELDS, $post);
		$response = curl_exec($c);

		if (curl_error($c)) {
			$response = curl_error($c);
		} else {
			$this->dispatcher->dispatch(GetEvent::NAME, new GetEvent(LogQuery::TA, $this->safe_room, $this->safe_id, $iua, $response));
		}

		return $response;
	}

	/**
	 * API de Récupération du Certificat de conformité
	 *
	 * @param String $iua Identifiant Archive Unique
	 * @return mixed
	 */
	public function getCert($iua)
	{
		$post = [
			'SAFE_ROOM'         =>  $this->safe_room,
			'SAFE_ID'           =>  $this->safe_id,
			'USER_LOGIN'        =>  $this->user_login,
			'USER_PASSWD'       =>  $this->user_password,
			'FILE_IUA'          =>  $iua,
			'RTNTYPE'           =>  self::RTNTYPE_TXT,
		];

		$c = curl_init();
		curl_setopt($c, CURLOPT_URL, self::CERT_URI);
		curl_setopt($c, CURLOPT_TIMEOUT, 30);
		curl_setopt($c, CURLOPT_POST, true);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($c, CURLOPT_POSTFIELDS, $post);
		$response = curl_exec($c);

		if (curl_error($c)) {
			$response = curl_error($c);
		} else {
			$this->dispatcher->dispatch(CertEvent::NAME, new CertEvent(LogQuery::TA, $this->safe_room, $this->safe_id, $iua, $response));
		}

		return $response;
	}

	/**
	 * API de Suppression
	 *
	 * @param String $iua Identifiant Archive Unique
	 * @return mixed
	 */
	public function removeFile($iua)
	{
		$post = [
			'SAFE_ROOM'         =>  $this->safe_room,
			'SAFE_ID'           =>  $this->safe_id,
			'USER_LOGIN'        =>  $this->user_login,
			'USER_PASSWD'       =>  $this->user_password,
			'FILE_IUA'          =>  $iua,
			'RTNTYPE'           =>  self::RTNTYPE_TXT,
		];

		$c = curl_init();
		curl_setopt($c, CURLOPT_URL, self::DEL_URI);
		curl_setopt($c, CURLOPT_TIMEOUT, 30);
		curl_setopt($c, CURLOPT_POST, true);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($c, CURLOPT_POSTFIELDS, $post);
		$response = curl_exec($c);

		if (curl_error($c)) {
			$response = curl_error($c);
		} else {
			$this->dispatcher->dispatch(DelEvent::NAME, new DelEvent(LogQuery::TA, $this->safe_room, $this->safe_id, $iua, $response));
		}

		return $response;
	}

	/**
	 * API de Listage des archives
	 * @param null $rtnType
	 * @param null $fileName
	 * @param null $fileHash
	 * @param null $fileSizeMin
	 * @param null $fileSizeMax
	 * @param null $filesTampBeg
	 * @param null $filesTampEnd
	 * @param null $maxList
	 * @return mixed|string
	 */
	public function listFiles($rtnType = null, $fileName = null, $fileHash = null, $fileSizeMin = null, $fileSizeMax = null, $filesTampBeg = null, $filesTampEnd = null, $maxList = null)
	{
		$post = [
			'SAFE_ROOM'         =>  $this->safe_room,
			'SAFE_ID'           =>  $this->safe_id,
			'USER_LOGIN'        =>  $this->user_login,
			'USER_PASSWD'       =>  $this->user_password,
			'RTNTYPE'           =>  $rtnType ? $rtnType : self::RTNTYPE_TXT,
		];
		if ($fileName) {
			$post['FILE_NAME'] =   $fileName;
		}
		if ($fileHash) {
			$post['FILE_HASH'] =   $fileHash;
		}
		if ($fileSizeMin) {
			$post['FILESIZE_MIN'] =   $fileSizeMin;
		}
		if ($fileSizeMax) {
			$post['FILESIZE_MAX'] =   $fileSizeMax;
		}
		if ($filesTampBeg) {
			$post['FILESTAMP_BEG'] =   $filesTampBeg;
		}
		if ($filesTampEnd) {
			$post['FILESTAMP_END'] =   $filesTampEnd;
		}
		if ($maxList) {
			$post['MAXLIST'] =   $maxList;
		}

		$c = curl_init();
		curl_setopt($c, CURLOPT_URL, self::LIST_URI);
		curl_setopt($c, CURLOPT_TIMEOUT, 30);
		curl_setopt($c, CURLOPT_POST, true);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($c, CURLOPT_POSTFIELDS, $post);
		$response = curl_exec($c);

		if (curl_error($c)) {
			$response = curl_error($c);
		} else {
			$this->dispatcher->dispatch(ListEvent::NAME, new ListEvent(LogQuery::TA, $this->safe_room, $this->safe_id, null, $response));
		}

		return $response;
	}

	/**
	 * API de récupération des propriétés d'une archive
	 * @param $iua
	 * @return mixed|string
	 */
	public function getProp($iua)
	{
		$post = [
			'SAFE_ROOM'         =>  $this->safe_room,
			'SAFE_ID'           =>  $this->safe_id,
			'USER_LOGIN'        =>  $this->user_login,
			'USER_PASSWD'       =>  $this->user_password,
			'FILE_IUA'          =>  $iua,
			'RTNTYPE'           =>  self::RTNTYPE_TXT,
		];

		$c = curl_init();
		curl_setopt($c, CURLOPT_URL, self::GETPROP_URI);
		curl_setopt($c, CURLOPT_TIMEOUT, 30);
		curl_setopt($c, CURLOPT_POST, true);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($c, CURLOPT_POSTFIELDS, $post);
		$response = curl_exec($c);

		if (curl_error($c)) {
			$response = curl_error($c);
		} else {
			$this->dispatcher->dispatch(GetPropEvent::NAME, new GetPropEvent(LogQuery::TA, $this->safe_room, $this->safe_id, $iua, $response));
		}

		return $response;
	}

	/**
	 * API de récupération des propriétés d'un coffre
	 */
	public function safeGetProp()
	{
		$post = [
			'SAFE_ROOM'         =>  $this->safe_room,
			'SAFE_ID'           =>  $this->safe_id,
			'USER_LOGIN'        =>  $this->user_login,
			'USER_PASSWD'       =>  $this->user_password,
			'RTNTYPE'           =>  self::RTNTYPE_TXT,
		];

		$c = curl_init();
		curl_setopt($c, CURLOPT_URL, self::SAFEGETPROP_URI);
		curl_setopt($c, CURLOPT_TIMEOUT, 30);
		curl_setopt($c, CURLOPT_POST, true);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($c, CURLOPT_POSTFIELDS, $post);
		$response = curl_exec($c);

		if (curl_error($c)) {
			$response = curl_error($c);
		} else {
			$this->dispatcher->dispatch(SafeGetPropEvent::NAME, new SafeGetPropEvent(LogQuery::TA, $this->safe_room, $this->safe_id, null, $response));
		}

		return $response;
	}
}
