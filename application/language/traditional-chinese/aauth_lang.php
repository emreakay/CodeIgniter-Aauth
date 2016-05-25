<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author Translated by Terry Lin (
 * @link https://github.com/terrylinooo)
 */ 
 
/* E-mail Messages */

// Account verification
$lang['aauth_email_verification_subject'] = '帳號驗證';
$lang['aauth_email_verification_code'] = '您的驗證碼：';
$lang['aauth_email_verification_text'] = "您可以點擊（或者複製貼上）以下連結\n\n";

// Password reset
$lang['aauth_email_reset_subject'] = '重設密碼';
$lang['aauth_email_reset_text'] = "欲重設你的密碼請點擊（或者複製貼上到瀏覽器網址列）下方連結:\n\n";

// Password reset success
$lang['aauth_email_reset_success_subject'] = '密碼重設成功';
$lang['aauth_email_reset_success_new_password'] = '您的密碼已寄出成功。您的新密碼是：';


/* Error Messages */

// Account creation errors
$lang['aauth_error_email_exists'] = '電郵地址已存在系統中。如果您忘了密碼，可以按下方連結。';
$lang['aauth_error_username_exists'] = "此用戶名的帳號已存在系統中，請輸入不同的用戶名。如果是忘了密碼，請按下方連結。";
$lang['aauth_error_email_invalid'] = '無效的電子郵件地址';
$lang['aauth_error_password_invalid'] = '無效的密碼';
$lang['aauth_error_username_invalid'] = '無效的用戶名';
$lang['aauth_error_username_required'] = '需要用戶名';
$lang['aauth_error_totp_code_required'] = '需要證認碼';
$lang['aauth_error_totp_code_invalid'] = '無效的證認碼';


// Account update errors
$lang['aauth_error_update_email_exists'] = '電郵地址已存在系統中。請輸入不同的電郵地址。';
$lang['aauth_error_update_username_exists'] = "用戶名已存在系統中，請輸入不同的用戶名。";


// Access errors
$lang['aauth_error_no_access'] = '對不起，您無法存取您需要的資源。';
$lang['aauth_error_login_failed_email'] = '電郵地址和密碼不符';
$lang['aauth_error_login_failed_name'] = '用戶名和密碼不符';
$lang['aauth_error_login_failed_all'] = '電郵地址、用戶名和或密碼不符';
$lang['aauth_error_login_attempts_exceeded'] = '您已達到登入嘗試限制數，您的帳號已被鎖住。';
$lang['aauth_error_recaptcha_not_correct'] = '對不起，reCAPTCHA 驗證碼輸入錯誤。';

// Misc. errors
$lang['aauth_error_no_user'] = '用戶不存在';
$lang['aauth_error_account_not_verified'] = '您的帳號尚未驗證，請檢查信箱並驗證帳號。';
$lang['aauth_error_no_group'] = '群組不存在';
$lang['aauth_error_no_subgroup'] = '子群組不存在';
$lang['aauth_error_self_pm'] = '傳訊息給您自己是不可能的。';
$lang['aauth_error_no_pm'] = '找不到私人訊息';


/* Info messages */
$lang['aauth_info_already_member'] = '用戶已是群組成員';
$lang['aauth_info_already_subgroup'] = '子群組已是群組成員';
$lang['aauth_info_group_exists'] = '群組名稱已存在';
$lang['aauth_info_perm_exists'] = '權限名稱已存在';
