<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Response as HttpResponse;

trait Response{

	private $statusCode = HttpResponse::HTTP_OK;

	/**
	 * @return int
	 */
	private function getStatusCode()
	{
		return $this->statusCode;
	}

	/**
	 * @param int $statusCode
	 * @return this
	 */
	private function setStatusCode($statusCode)
	{
		$this->statusCode = $statusCode;

		return $this;
	}	

	/**
	 * @param mixed $message
	 * @return array
	 */
	private function respondWithSuccess($message)
	{
		return $this->respondOutcome($message);
	}

	/**
	 * @param $data
	 * @param array $headers
	 * @return mixed
	 */
	private function respond($data, $headers = [])
	{
		return response()->json($data, $this->getStatusCode(), $headers);
	}

	/**
	 * @param string $message
	 * @return array
	 */
	private function respondOutcome($message) 
	{
		return $this->respond([
			'api' => [
				'message' => $message,
				'status_code' => $this->getStatusCode()
			]
		]);
	}

	/**
	 * @param string $message
	 * @return array 
	 */
	private function respondWithError($message, $statusCode)
	{
		return $this->setStatusCode($statusCode)->respondOutcome($message);
	}	

	/**
	 * @param string $message
	 * @return mixed
	 */
	public function respondUnauthorizedRequest($message = "Unable to access resource")
	{
		return $this->respondWithError($message, HttpResponse::HTTP_UNAUTHORIZED);
	}

	/**
	 * @param string $message
	 * @return mixed
	 */
	public function respondInternalError($message = 'Internal Error, please try again later')
	{
		return $this->respondWithError($message, HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
	}

	/**
	 * @param string $message
	 * @return mixed
	 */
	public function respondNotFoundRequest($message = 'Not Found')
	{
		return $this->respondWithError($message, HttpResponse::HTTP_NOT_FOUND);
	}

	/**
	 * @param string $message
	 * @return mixed
	 */
	public function respondBadRequest($message = 'Bad Request')
	{
		return $this->respondWithError($message, HttpResponse::HTTP_BAD_REQUEST);
	}

	/**
	 * @param string $message
	 * @return mixed
	 */
	public function respondNoRange($message = 'Range not satisfiable')
	{
		return $this->respondWithError($message, HttpResponse::HTTP_REQUESTED_RANGE_NOT_SATISFIABLE);
	}

	/**
	 * @param array $array
	 * @return mixed
	 */
	public function respondSuccessWithArray($array)
	{
		return $this->respondWithSuccess($array);
	}

	/**
	 * @param string $message
	 * @return array
	 */
	public function respondWithUserError($message)
	{
		return $this->respondWithError($message, HttpResponse::HTTP_NOT_ACCEPTABLE);	
	}
	
	/**
	 * @param bool $result
	 * @result array
	 */
	public function databaseSave($result)
	{
		if(!$result) return $this->respondWithError("Unable to save, please try again later", HttpResponse::HTTP_SERVICE_UNAVAILABLE);
		return $this->respondWithSuccess($result);
	}
}