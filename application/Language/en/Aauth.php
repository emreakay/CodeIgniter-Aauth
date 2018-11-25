<?php
/**
 * CodeIgniter-Aauth
 *
 * Aauth is a User Authorization Library for CodeIgniter 4.x, which aims to make
 * easy some essential jobs such as login, permissions and access operations.
 * Despite ease of use, it has also very advanced features like groupping,
 * access management, public access etc..
 *
 * @package   CodeIgniter-Aauth
 * @author    Magefly Team
 * @copyright 2014-2017 Emre Akay
 * @copyright 2018 Magefly
 * @license   https://opensource.org/licenses/MIT	MIT License
 * @link      https://github.com/magefly/CodeIgniter-Aauth
 */

/**
 * Aauth language strings.
 *
 * Language English
 *
 * @package CodeIgniter-Aauth
 *
 * @codeCoverageIgnore
 */
return [
   'subjectVerification'    => 'Account Verification',
   'subjectReset'           => 'Reset Password',
   'subjectResetSuccess'    => 'Successful Pasword Reset',

   'textVerification'       => "Your verification code is: {code}. You can also click on (or copy and paste) the following link\n\n {link}",
   'textReset'              => "To reset your password click on (or copy and paste in your browser address bar) the link below:\n\n {link}",
   'textResetSuccess'       => 'Your password has successfully been reset. Your new password is: {password}',

   'infoCreateSuccess'      => 'Your account has successfully been created. You can now login.',
   'infoCreateVerification' => 'Your account has successfully been created. A email has been sent to your email address with verification details..',
   'infoRemindSuccess'      => 'A email has been sent to your email address with reset instructions.',
   'infoResetSuccess'       => 'A email has been sent to your email address with your new password has been sent.',

   'noAccess'               => 'Sorry, you do not have access to the resource you requested.',
   'notVerified'            => 'Your account has not been verified. Please check your email and verify your account.',

   'loginFailedEmail'       => 'Email Address and Password do not match.',
   'loginFailedName'        => 'Username and Password do not match.',
   'loginFailedAll'         => 'Email, Username or Password do not match.',
   'loginAttemptsExceeded'  => 'You have exceeded your login attempts, your account has now been locked.',

   'invalidUserBanned'      => 'This user is banned, please contact the system administrator.',
   'invalidEmail'           => 'Invalid Email address',
   'invalidPassword'        => 'Invalid Password',
   'invalidUsername'        => 'Invalid Username',
   'invalidTOTPCode'        => 'Invalid Authentication Code',
   'invalidRecaptcha'       => 'Sorry, the reCAPTCHA text entered was incorrect.',
   'invalidVerficationCode' => 'Invalid Verification Code',

   'requiredUsername'       => 'Username required',
   'requiredTOTPCode'       => 'Authentication Code required',
   'requiredGroupName'      => 'Group name required',
   'requiredPermName'       => 'Perm name required',

   'existsAlreadyEmail'     => 'Email address already exists on the system. Please enter a different email address.',
   'existsAlreadyUsername'  => 'Username already exists on the system. Please enter a different username.',
   'existsAlreadyGroup'     => 'Group name already exists',
   'existsAlreadyPerm'      => 'Permission name already exists',

   'notFoundUser'           => 'User does not exist',
   'notFoundGroup'          => 'Group does not exist',
   'notFoundSubgroup'       => 'Subgroup does not exist',

   'alreadyMemberGroup'     => 'User is already member of group',
   'alreadyMemberSubgroup'  => 'Subgroup is already member of group',
];
