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

use \App\Models\Aauth\UserVariableModel;

use OTPHP\TOTP as OTPHP_TOTP;

/**
 * Aauth TOTP
 *
 * Class for handling 2-factor authentication
 *
 * @package CodeIgniter-Aauth
 */
class TOTP extends \App\Libraries\Aauth
{
	/**
	 * Update User TOTP Secret
	 *
	 * @param integer $userId User Id
	 * @param string  $secret Secret Key
	 *
	 * @return boolean
	 */
	public function updateUserTotpSecret(int $userId = null, string $secret)
	{
		if (! $userId)
		{
			$userId = (int) @$this->session->user['id'];
		}

		$userVariableModel = new UserVariableModel();

		return $userVariableModel->save($userId, 'totp_secret', $secret, true);
	}

	/**
	 * Generate Unique TOTP Secret
	 *
	 * @return string
	 */
	public function generateUniqueTotpSecret()
	{
		$stop = false;

		while (! $stop)
		{
			$secret = OTPHP_TOTP::create();

			if ($userVariable !== $userVariableModel->where(['data_key' => 'totp_secret', 'data_value' => $secret, 'system' => 1])->getFirstRow('array'))
			{
				$stop = true;

				return $secret;
			}
		}
	}

	/**
	 * Generate TOTP QR Code
	 *
	 * Generate TOTP QR Code URI by Secret
	 *
	 * @param string $secret Secret Key
	 *
	 * @return string
	 */
	public function generateTotpQrCode(string $secret)
	{
		$totp = OTPHP_TOTP::create($secret);

		return $totp->getQrCodeUri();
	}

	/**
	 * Verify user TOTP Code
	 *
	 * @param integer $totpCode TOTP Code
	 * @param string  $userId   User Id
	 *
	 * @return boolean
	 */
	public function verifyUserTotpCode(int $totpCode, string $userId = null)
	{
		if (! $this->isTotpRequired())
		{
			return true;
		}

		if (! $userId)
		{
			$userId = (int) @$this->session->user['id'];
		}

		if (empty($totpCode))
		{
			$this->error(lang('Aauth.requiredTOTPCode'));

			return false;
		}

		$userVariableModel = new UserVariableModel();

		$totpSecret = $userVariableModel->find($userId, 'totp_secret', true);
		$totp       = OTPHP_TOTP::create($totpSecret);

		if (! $totp->verify($totpCode))
		{
			$this->error(lang('Aauth.invalidTOTPCode'));

			return false;
		}
		else
		{
			unset($_SESSION['user']['totp_required']);

			return true;
		}
	}

	/**
	 * IS TOTP Required
	 *
	 * Checks if User need TOTP verification.
	 *
	 * @return boolean
	 */
	public function isTotpRequired()
	{
		if (@$this->session->user['totp_required'])
		{
			return true;
		}

		return false;
	}
}
