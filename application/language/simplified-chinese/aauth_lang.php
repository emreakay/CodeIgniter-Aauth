<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author Translated by Terry Lin (
 * @link https://github.com/terrylinooo)
 */ 
 
/* E-mail Messages */

// Account verification
$lang['aauth_email_verification_subject'] = '帐户验证';
$lang['aauth_email_verification_code'] = '您的验证码：';
$lang['aauth_email_verification_text'] = "您可以点击（或者复制贴上）以下链接\n\n";

// Password reset
$lang['aauth_email_reset_subject'] = '重设密码';
$lang['aauth_email_reset_text'] = "欲重设你的密码请点击（或者复制贴上到浏览器网址列）下方链接:\n\n";

// Password reset success
$lang['aauth_email_reset_success_subject'] = '密码重设成功';
$lang['aauth_email_reset_success_new_password'] = '您的密码已寄出成功。您的新密码是：';


/* Error Messages */

// Account creation errors
$lang['aauth_error_email_exists'] = '电邮地址已存在系统中。如果您忘了密码，可以按下方链接。 ';
$lang['aauth_error_username_exists'] = "此用户名的帐户已存在系统中，请输入不同的用户名。如果是忘了密码，请按下方链接。";
$lang['aauth_error_email_invalid'] = '无效的电子邮件地址';
$lang['aauth_error_password_invalid'] = '无效的密码';
$lang['aauth_error_username_invalid'] = '无效的用户名';
$lang['aauth_error_username_required'] = '需要用户名';
$lang['aauth_error_totp_code_required'] = '需要证认码';
$lang['aauth_error_totp_code_invalid'] = '无效的证认码';


// Account update errors
$lang['aauth_error_update_email_exists'] = '电邮地址已存在系统中。请输入不同的电邮地址。 ';
$lang['aauth_error_update_username_exists'] = "用户名已存在系统中，请输入不同的用户名。";


// Access errors
$lang['aauth_error_no_access'] = '对不起，您无法存取您需要的资源。 ';
$lang['aauth_error_login_failed_email'] = '电邮地址和密码不符';
$lang['aauth_error_login_failed_name'] = '用户名和密码不符';
$lang['aauth_error_login_failed_all'] = '电邮地址、用户名和或密码不符';
$lang['aauth_error_login_attempts_exceeded'] = '您已达到登入尝试限制数，您的帐户已被锁住。 ';
$lang['aauth_error_recaptcha_not_correct'] = '对不起，reCAPTCHA 验证码输入错误。 ';

// Misc. errors
$lang['aauth_error_no_user'] = '用户不存在';
$lang['aauth_error_account_not_verified'] = '您的帐户尚未验证，请检查信箱并验证帐户。 ';
$lang['aauth_error_no_group'] = '群组不存在';
$lang['aauth_error_no_subgroup'] = '子群组不存在';
$lang['aauth_error_self_pm'] = '传信息给您自己是不可能的。 ';
$lang['aauth_error_no_pm'] = '找不到私人信息';


/* Info messages */
$lang['aauth_info_already_member'] = '用户已是群组成员';
$lang['aauth_info_already_subgroup'] = '子群组已是群组成员';
$lang['aauth_info_group_exists'] = '群组名称已存在';
$lang['aauth_info_perm_exists'] = '权限名称已存在';
