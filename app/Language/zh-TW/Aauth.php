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

/**
 * Aauth language strings.
 *
 * Language Chinese Traditional
 *
 * @author Terry Lin (https://github.com/terrylinooo)
 *
 * @package CodeIgniter-Aauth
 *
 * @codeCoverageIgnore
 */
return [
   'subjectVerification'    => '帳號驗證',
   'subjectReset'           => '重設密碼',
   'subjectResetSuccess'    => '密碼重設成功',

   'textVerification'       => "您的驗證碼：{code}. 您可以點擊（或者複製貼上）以下連結\n\n {link}",
   'textReset'              => "欲重設你的密碼請點擊（或者複製貼上到瀏覽器網址列）下方連結：\n\n {link}",
   'textResetSuccess'       => '您的密碼已寄出成功。您的新密碼是：{password}',

   'infoCreateSuccess'      => 'Your account has successfully been created. You can now login.',
   'infoCreateVerification' => 'Your account has successfully been created. A email has been sent to your email address with verification details..',
   'infoUpdateSuccess'      => 'Your account has successfully updated.',
   'infoRemindSuccess'      => 'A email has been sent to your email address with reset instructions.',
   'infoResetSuccess'       => 'A email has been sent to your email address with your new password has been sent.',
   'infoVerification'       => 'Your account has been verified successfully, you can now login.',

   'noAccess'               => '對不起，您無法存取您需要的資源。',
   'notVerified'            => '您的帳號尚未驗證，請檢查信箱並驗證帳號。',

   'loginFailedEmail'       => '電郵地址和密碼不符',
   'loginFailedUsername'    => '用戶名和密碼不符',
   'loginFailedAll'         => '電郵地址、用戶名和或密碼不符',
   'loginAttemptsExceeded'  => '您已達到登入嘗試限制數，您的帳號已被鎖住。',

   'invalidUserBanned'      => 'This user is banned, please contact the system administrator.',
   'invalidEmail'           => '無效的電子郵件地址',
   'invalidPassword'        => '無效的密碼',
   'invalidUsername'        => '無效的用戶名',
   'invalidTOTPCode'        => '無效的證認碼',
   'invalidRecaptcha'       => '對不起，reCAPTCHA 驗證碼輸入錯誤。',
   'invalidVerficationCode' => 'Invalid Verification Code',

   'requiredUsername'       => '需要用戶名',
   'requiredTOTPCode'       => '需要證認碼',
   'requiredGroupName'      => 'Group name required',
   'requiredPermName'       => 'Perm name required',

   'existsAlreadyEmail'     => '電郵地址已存在系統中。如果您忘了密碼，可以按下方連結。',
   'existsAlreadyUsername'  => '此用戶名的帳號已存在系統中，請輸入不同的用戶名。如果是忘了密碼，請按下方連結。',
   'existsAlreadyGroup'     => '群組名稱已存在',
   'existsAlreadyPerm'      => '權限名稱已存在',

   'notFoundUser'           => '用戶不存在',
   'notFoundGroup'          => '群組不存在',
   'notFoundSubgroup'       => '子群組不存在',

   'alreadyMemberGroup'     => '用戶已是群組成員',
   'alreadyMemberSubgroup'  => '子群組已是群組成員',
];
