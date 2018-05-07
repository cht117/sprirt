<?php

namespace App\Exceptions;


use RuntimeException;

class ApiException extends RuntimeException
{
	protected $errorCodeMessage = [
		'-9999' => '请先验证手机再操作!',
	];
	
	/**
	 * EntityApiException constructor.
	 *
	 * @param int        $code
	 * @param string     $message
	 * @param \Throwable $previous
	 */
	public function __construct($code = -104010, $message = '', \Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
	
	
	/**
	 * 记录异常
	 *
	 */
	public function report()
	{
		Log::getLogger(request()->path())->error(json_encode([
			'errorCode' => $this->code,
			'errorMessage' => $this->errorCodeMessage(),
			'args' => $args
		], JSON_UNESCAPED_UNICODE));
	}
	
	
	/**
	 * 将异常渲染到 HTTP 响应中
	 *
	 */
	public function render($request)
	{
		return response()->json([
			'code' => $this->code,
			'msg' => $this->errorCodeMessage(),
			'data' => [],
		]);
	}
	
	
	/**
	 * 获取错误码提示
	 *
	 * @return string
	 */
	protected function errorCodeMessage()
	{
		if (!empty($this->message)) {
			return $this->message;
		}
		return isset($this->errorCodeMessage[$this->code]) ? $this->errorCodeMessage[$this->code] : '未知错误类型';
	}
}
