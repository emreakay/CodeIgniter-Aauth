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
 * Language Chinese Simplified
 *
 * @author Terry Lin (https://github.com/terrylinooo)
 *
 * @package CodeIgniter-Aauth
 *
 * @codeCoverageIgnore
 */
return [
   'subjectVerification'    => '帐户验证',
   'subjectReset'           => '重设密码',
   'subjectResetSuccess'    => '密码重设成功',

   'textVerification'       => "您的验证码：{code}. 您可以点击（或者复制贴上）以下链接\n\n {link}",
   'textReset'              => "欲重设你的密码请点击（或者复制贴上到浏览器网址列）下方链接：\n\n {link}",
   'textResetSuccess'       => '您的密码已寄出成功。您的新密码是：{password}',

   'infoCreateSuccess'      => 'Your account has successfully been created. You can now login.',
   'infoCreateVerification' => 'Your account has successfully been created. A email has been sent to your email address with verification details..',

   'noAccess'               => '对不起，您无法存取您需要的资源。',
   'notVerified'            => '您的帐户尚未验证，请检查信箱并验证帐户。',

   'loginFailedEmail'       => '电邮地址和密码不符',
   'loginFailedName'        => '用户名和密码不符',
   'loginFailedAll'         => '电邮地址、用户名和或密码不符',
   'loginAttemptsExceeded'  => '您已达到登入尝试限制数，您的帐户已被锁住。',

   'invalidUserBanned'      => 'This user is banned, please contact the system administrator.',
   'invalidEmail'           => '无效的电子邮件地址',
   'invalidPassword'        => '无效的密码',
   'invalidUsername'        => '无效的用户名',
   'invalidTOTPCode'        => '无效的证认码',
   'invalidRecaptcha'       => '对不起，reCAPTCHA 验证码输入错误。',
   'invalidVerficationCode' => 'Invalid Verification Code',

   'requiredUsername'       => 'Username required',
   'requiredTOTPCode'       => '需要证认码',
   'requiredGroupName'      => 'Group name required',
   'requiredPermName'       => 'Perm name required',

   'existsAlreadyEmail'     => '电邮地址已存在系统中。如果您忘了密码，可以按下方链接。',
   'existsAlreadyUsername'  => '此用户名的帐户已存在系统中，请输入不同的用户名。如果是忘了密码，请按下方链接。',
   'existsAlreadyGroup'     => '群组名称已存在',
   'existsAlreadyPerm'      => '权限名称已存在',

   'notFoundUser'           => '用户不存在',
   'notFoundGroup'          => '群组不存在',
   'notFoundSubgroup'       => '子群组不存在',

   'alreadyMemberGroup'     => '用户已是群组成员',
   'alreadyMemberSubgroup'  => '子群组已是群组成员',
];
