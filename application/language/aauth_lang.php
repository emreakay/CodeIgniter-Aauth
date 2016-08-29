<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* E-mail Messages */

// Account verification
$lang['aauth_email_verification_subject'] = 'تایید حساب کاربری';
$lang['aauth_email_verification_code'] = 'کد تایید شما: ';
$lang['aauth_email_verification_text'] = "شما همچنین میتوانید بر روی لینک زیر کلیک کنید و یا آن را در نوار آدرس مرورگر وارد کنید\n\n";

// Password reset
$lang['aauth_email_reset_subject'] = 'بازنشانی کلمه عبور';
$lang['aauth_email_reset_text'] = "برای تغییر کلمه عبور خود بر روی لینک زیر کلیک کنید و یا آن را در نوار آدرس مرورگر وارد کنید\n\n";

// Password reset success
$lang['aauth_email_reset_success_subject'] = 'کلمه عبور با موفقیت بازنشانی شد';
$lang['aauth_email_reset_success_new_password'] = 'کلمه عبور شما با موفقیت تغییر کرد. کلمه عبور جدید شما: ';


/* Error Messages */

// Account creation errors
$lang['aauth_error_email_exists'] = 'آدرس ایمیل در سیستم موجود است. در صورتی که کلمه عبور خود را فراموش کردید، میتوانید بر روی لینک زیر کلیک کنید.';
$lang['aauth_error_username_exists'] = "نام کاربری وارد شده در سیستم موجود هست. لطفا یک نام کاربری دیگر انتخاب کنید، و یا اگر کلمه عبور خود را فراموش کرده اید بر روی لینک زیر کلیک کنید.";
$lang['aauth_error_email_invalid'] = 'آدرس ایمیل نامعتبر است';
$lang['aauth_error_password_invalid'] = 'کلمه عبور نامعتبر است';
$lang['aauth_error_username_invalid'] = 'نام کاربری نامعتبر است';
$lang['aauth_error_username_required'] = 'ورود نام کاربری الزامی است';
$lang['aauth_error_totp_code_required'] = 'ورود کد احراز هویت الزامی است';
$lang['aauth_error_totp_code_invalid'] = 'کد احراز هویت نامعتبر است';


// Account update errors
$lang['aauth_error_update_email_exists'] = 'ایمیل وارد شده در سیستم موجود می باشد. لطفا ایمیل دیگری انتخاب کنید.';
$lang['aauth_error_update_username_exists'] = "نام کاربری وارد شده در سیستم موجود می باشد. لطفا نام کاربری دیگری انتخاب کنید.";


// Access errors
$lang['aauth_error_no_access'] = 'متاسفانه شما به منبع درخواست شده دسترسی ندارید.';
$lang['aauth_error_login_failed_email'] = 'ایمیل و کلمه عبور همخوانی ندارند.';
$lang['aauth_error_login_failed_name'] = 'نام کاربری و کلمه عبور همخوانی ندارند.';
$lang['aauth_error_login_failed_all'] = 'ایمیل یا نام کاربری با کلمه عبور همخوانی ندارد.';
$lang['aauth_error_login_attempts_exceeded'] = 'شما بیش از حد مجاز برای ورود به سایت تلاش کردید. حساب کاربری شما موقتا غیر فعال شد.';
$lang['aauth_error_recaptcha_not_correct'] = 'کد کپتچا به درستی وارد نشده.';

// Misc. errors
$lang['aauth_error_no_user'] = 'نام کاربری وجود ندارد';
$lang['aauth_error_account_not_verified'] = 'حساب کاربری شما تایید نشده است. لطفا ایمیل خود را برای تایید حسا کاربری بررسی کنید.';
$lang['aauth_error_no_group'] = 'گروه موجود نیست';
$lang['aauth_error_no_subgroup'] = 'زیرگروه موجود نیست';
$lang['aauth_error_self_pm'] = 'شما نمیتوانید به خودتان پیام ارسال کنید.';
$lang['aauth_error_no_pm'] = 'پیامی یافت نشد';


/* Info messages */
$lang['aauth_info_already_member'] = 'کاربر از قبل عضو این گروه می باشد';
$lang['aauth_info_already_subgroup'] = 'زیرگروه از قبل شامل این گروه می باشد';
$lang['aauth_info_group_exists'] = 'نام گروه از قبل موجود است';
$lang['aauth_info_perm_exists'] = 'سطح دسترسی از قبل موجود است';
