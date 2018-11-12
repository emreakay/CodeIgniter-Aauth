<?php

/**
 * Aauth language strings.
 *
 * @package      Aauth
 * @author       REJack <info@rejack.de>
 * @copyright    2018 Magefly (https://github.com/magefly/)
 * @license      https://opensource.org/licenses/MIT	MIT License
 * @link         https://github.com/magefly/CodeIgniter-Aauth
 * @since        Version 3.0.0
 * @filesource
 *
 * @codeCoverageIgnore
 */
return [
	'subjectVerification'   => 'Account Verification',
	'subjectReset'          => 'Reset Password',
	'subjectResetSuccess'   => 'Successful Pasword Reset',

	'textVerification'      => "Your verification code is: {0}. You can also click on (or copy and paste) the following link\n\n {1}",
	'textReset'             => "To reset your password click on (or copy and paste in your browser address bar) the link below:\n\n {0}",
	'textResetSuccess'      => 'Your password has successfully been reset. Your new password is: {0}',

	'noAccess'              => 'Sorry, you do not have access to the resource you requested.',
	'notVerified'           => 'Your account has not been verified. Please check your e-mail and verify your account.',

	'loginFailedEmail'      => 'E-mail Address and Password do not match.',
	'loginFailedName'       => 'Username and Password do not match.',
	'loginFailedAll'        => 'E-mail, Username or Password do not match.',
	'loginAttemptsExceeded' => 'You have exceeded your login attempts, your account has now been locked.',

	'invalidUserBanned'     => 'This user is banned, please contact the system administrator.',
	'invalidEmail'          => 'Invalid e-mail address',
	'invalidPassword'       => 'Invalid password',
	'invalidUsername'       => 'Invalid Username',
	'invalidTOTPCode'       => 'Invalid Authentication Code',
	'invalidRecaptcha'      => 'Sorry, the reCAPTCHA text entered was incorrect.',
	'invalidVercode'        => 'Invalid Verification Code',

	'requiredUsername'      => 'Username required',
	'requiredTOTPCode'      => 'Authentication Code required',

	'existsAlreadyEmail'    => 'Email address already exists on the system. Please enter a different email address.',
	'existsAlreadyUsername' => "Username already exists on the system. Please enter a different username.",
	'existsAlreadyGroup'    => 'Group name already exists',
	'existsAlreadyPerm'     => 'Permission name already exists',

	'notFoundUser'          => 'User does not exist',
	'notFoundGroup'         => 'Group does not exist',
	'notFoundSubgroup'      => 'Subgroup does not exist',

	'alreadyMemberGroup'    => 'User is already member of group',
	'alreadyMemberSubgroup' => 'Subgroup is already member of group',
];
