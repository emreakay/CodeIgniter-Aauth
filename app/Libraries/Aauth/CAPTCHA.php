<?php
/**
 * CodeIgniter-Aauth
 *
 * Aauth is a User Authorization Library for CodeIgniter 4.x, which aims to make
 * easy some essential jobs such as login, permissions and access operations.
 * Despite ease of use, it has also very advanced features like grouping,
 * access management, public access etc..
 *
 * @package   CodeIgniter-Aauth
 * @author    Emre Akay
 * @author    Raphael "REJack" Jackstadt
 * @copyright 2014-2019 Emre Akay
 * @license   https://opensource.org/licenses/MIT   MIT License
 * @link      https://github.com/emreakay/CodeIgniter-Aauth
 */

namespace App\Libraries\Aauth;

use \App\Models\Aauth\LoginAttemptModel;

/**
 * Aauth CAPTCHA
 *
 * Class for handling CAPTCHA (reCAPTCHA & hCAPTCHA)
 *
 * @package CodeIgniter-Aauth
 */
class CAPTCHA extends \App\Libraries\Aauth
{

	/**
	 * Verify Response
	 *
	 * Calls the CAPTCHA site verify API to verify whether the user passes
	 * CAPTCHA test.
	 *
	 * @param string $response Response string from CAPTCHA verification.
	 *
	 * @return array
	 */
	public function verifyResponse($response)
	{
		if ($response === null || strlen($response) === 0)
		{
			return [
				'success'    => false,
				'errorCodes' => 'missing-input',
			];
		}

		$request  = \Config\Services::request();
		$remoteIp = $request->getIPAddress();

		if ($this->config->captchaType === 'recaptcha')
		{
			$siteUrl = 'https://www.google.com/recaptcha/api/siteverify';
			$request = $this->_submitGet(
				$siteUrl,
				[
					'secret'   => $this->config->captchaSecret,
					'remoteip' => $remoteIp,
					'response' => $response,
					'version'  => 'php_1.0.0',
				]);
		}
		else if ($this->config->captchaType === 'hcaptcha')
		{
			$siteUrl = 'https://hcaptcha.com/siteverify';
			$request = $this->_submitPost(
				$siteUrl,
				[
					'secret'   => $this->config->captchaSecret,
					'response' => $response,
					'remoteip' => $remoteIp,
				]);
		}

		$answer = json_decode($request, true);

		if (trim($answer['success']) === true)
		{
			return ['success' => true];
		}
		else
		{
			return [
				'success'    => false,
				'errorCodes' => $answer['error-codes'],
			];
		}
	}

	/**
	 * Generate CAPTCHA HTML
	 *
	 * @return string
	 */
	public function generateCaptchaHtml()
	{
		$content = '';

		if ($this->config->loginProtection && $this->config->captchaEnabled)
		{
			$loginAttemptModel = new LoginAttemptModel();

			if ($loginAttemptModel->find() >= $this->config->captchaLoginAttempts)
			{
				$siteKey = $this->config->captchaSiteKey;

				if ($this->config->captchaType === 'recaptcha')
				{
					$content .= "<div class='g-recaptcha' data-sitekey='{$siteKey}'></div>";
					$content  = '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
				}
				else if ($this->config->captchaType === 'hcaptcha')
				{
					$content  = "<div class='h-captcha' data-sitekey='{$siteKey}'></div>";
					$content .= '<script src="https://hcaptcha.com/1/api.js" async defer></script>';
				}
			}
		}

		return $content;
	}

	/**
	 * Submit GET
	 *
	 * Submits an HTTP GET to a CAPTCHA server.
	 *
	 * @param string $url  URL path to CAPTCHA server.
	 * @param array  $data Array of parameters to be sent.
	 *
	 * @return array response
	 */
	private function _submitGet($url, $data)
	{
		$client   = \Config\Services::curlrequest();
		$response = $client->request('GET', $url, [
			'query' => $data,
		]);

		return $response->getBody();
	}

	/**
	 * Submit POST
	 *
	 * Submits an HTTP POST to a CAPTCHA server.
	 *
	 * @param string $url  URL path to CAPTCHA server.
	 * @param array  $data Array of parameters to be sent.
	 *
	 * @return array response
	 */
	private function _submitPost($url, $data)
	{
		$client   = \Config\Services::curlrequest();
		$response = $client->request('POST', $url, [
			'query' => $data,
		]);

		return $response->getBody();
	}
}
