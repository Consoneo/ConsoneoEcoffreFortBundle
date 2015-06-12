<?php

namespace Consoneo\Bundle\EcoffreFortBundle;

use Consoneo\Bundle\EcoffreFortBundle\Entity\LogQuery;
use Consoneo\Bundle\EcoffreFortBundle\Event\CertEvent;
use Consoneo\Bundle\EcoffreFortBundle\Event\DelEvent;
use Consoneo\Bundle\EcoffreFortBundle\Event\GetEvent;
use Consoneo\Bundle\EcoffreFortBundle\Event\MoveEvent;
use Consoneo\Bundle\EcoffreFortBundle\Event\PutEvent;

class Coffre extends ECoffreFort
{
	const PUT_URI   =   'https://www.e-coffrefort.fr/httpapi/loadsafe.php';
	const GET_URI   =   'https://www.e-coffrefort.fr/httpapi/getfile.php';
	const DEL_URI   =   'https://www.e-coffrefort.fr/httpapi/delfile.php';
	const CERT_URI  =   'https://www.e-coffrefort.fr/httpapi/getfilecert.php';
	const MOVE_URI  =   'https://www.e-coffrefort.fr/httpapi/mvfile.php';

	const EXTENDED  =   'Y';
	const CHARSET   =   'UTF8';
	const HDAU      =   'N';

	/**
	 * @var String
	 */
	private $email_origin;

	/**
	 * @var String
	 */
	private $part_id;

	/**
	 * @var String
	 */
	private $password;

	/**
	 * @param $email_origin
	 * @param $safe_id
	 * @param $part_id
	 * @param $password
	 */
	public function __construct($email_origin, $safe_id, $part_id, $password)
	{
		$this->email_origin =   $email_origin;
		$this->safe_id      =   $safe_id;
		$this->part_id      =   $part_id;
		$this->password     =   $password;
	}

	/**
	 * API de Dépôt
	 *
	 * @param String $docName Nom du document
	 * @param String $targetDir Repertoire de stockage du document
	 * @param String $path chemin du document source
	 * @param String $docComment Commentaire sur le document
	 * @param string $extended Demande de réponse en format étendue (Y ou N) Necessaire pour récupérer l'iua du document
	 * @param string $charset
	 * @param string $hdau Héritage Directories All Users
	 * @return mixed
	 */
	public function putFile($docName, $targetDir, $path, $docComment = null, $extended = self::EXTENDED,
	                        $charset = self::CHARSET, $hdau = self::HDAU)
	{
		$post = [
			'EMAILORIGIN'   =>  $this->email_origin,
			'SAFE_ID'       =>  $this->safe_id,
			'PART_ID'       =>  $this->part_id,
			'DOCNAME'       =>  $docName,
			'TARGETDIR'     =>  $targetDir,
			'DOCMD5'        =>  md5_file($path),
			'DOCCOMMNT'     =>  $docComment,
			'DOCATTACH'     =>  curl_file_create($path),
			'EXTENDED'      =>  $extended,
			'CHARSET'       =>  $charset,
			'HDAU'          =>  $hdau,
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
			$this->dispatcher->dispatch(PutEvent::NAME, new PutEvent(LogQuery::COFFRE, null, $docName, $this->safe_id, $targetDir, $response));
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
		$yy     = rand(0,99);

		$key    = sprintf('%s%s)', $yy, base64_encode(sprintf('%s|%s|%s|%s|%s',
			$this->safe_id, $this->password, $this->part_id, $iua, $yy)));
		$url    = sprintf('%s?P=%s&MODE=RAW', self::GET_URI, $key);

		$c = curl_init();
		curl_setopt($c, CURLOPT_URL, $url);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($c);

		if (curl_error($c)) {
			$response = curl_error($c);
		} else {
			$this->dispatcher->dispatch(GetEvent::NAME, new GetEvent(LogQuery::COFFRE, null, $this->safe_id, $iua, $response));
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
		$yy     = rand(0,99);
		$key    = sprintf('%s%s)', $yy, base64_encode(sprintf('%s|%s|%s|%s|%s',
			$this->safe_id, $this->password, $this->part_id, $iua, $yy)));
		$url    = sprintf('%s?P=%s', self::DEL_URI, $key);

		$c = curl_init();
		curl_setopt($c, CURLOPT_URL, $url);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);

		$response = curl_exec($c);

		if (curl_error($c)) {
			$response = curl_error($c);
		} else {
			$this->dispatcher->dispatch(DelEvent::NAME, new DelEvent(LogQuery::COFFRE, null, $this->safe_id, $iua, $response));
		}

		return $response;
	}

	/**
	 * API de récupération du certificat de conformité
	 *
	 * @param String $iua Identifiant Archive Unique
	 * @return mixed
	 */
	public function getCert($iua)
	{
		$yy     = rand(0,99);
		$key    = sprintf('%s%s)', $yy, base64_encode(sprintf('%s|%s|%s|%s|%s',
			$this->safe_id, $this->password, $this->part_id, $iua, $yy)));
		$url    = sprintf('%s?P=%s&MODE=RAW', self::CERT_URI, $key);

		$c = curl_init();
		curl_setopt($c, CURLOPT_URL, $url);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($c);

		if (curl_error($c)) {
			$response = curl_error($c);
		} else {
			$this->dispatcher->dispatch(CertEvent::NAME, new CertEvent(LogQuery::COFFRE, null, $this->safe_id, $iua, $response));
		}

		return $response;
	}

	/**
	 * API de déplacement d'un document
	 *
	 * @param $iua
	 * @param $target
	 * @param string $charset
	 * @return mixed|string
	 */
	public function moveFile($iua, $target, $charset = self::CHARSET)
	{
		$yy     = rand(0,99);
		$key    = sprintf('%s%s)', $yy, base64_encode(sprintf('%s|%s|%s|%s|%s',
			$this->safe_id, $this->password, $this->part_id, $iua, $yy)));
		$url    = sprintf('%s?P=%s&DEST=%s&CHARSET=%s', self::MOVE_URI, $key, $target, $charset);

		$c = curl_init();
		curl_setopt($c, CURLOPT_URL, $url);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($c);

		if (curl_error($c)) {
			$response = curl_error($c);
		} else {
			$this->dispatcher->dispatch(MoveEvent::NAME, new MoveEvent($this->safe_id, $iua, $response, $target));
		}

		return $response;
	}
}
