<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author Translated by ibrahimuslu 
 * @link https://github.com/ibrahimuslu
 */ 

/* E-mail Messages */

// Account verification
$lang['aauth_email_verification_subject'] = 'Hesap Onayı';
$lang['aauth_email_verification_code'] = 'Onay kodunuz: ';
$lang['aauth_email_verification_text'] = " Hesap onayı için aşağıdaki linke tıklayabilirsiniz yada ( kopyalayıp tarayıcınızın adres çubuğuna yapıştırarak gidebilirsiniz) :  \n\n";

// Password reset
$lang['aauth_email_reset_subject'] = 'Şifre Sıfırla';
$lang['aauth_email_reset_text'] = " Şifrenizi sıfırlamak için aşağıdaki bağlantıya tıklayabilir ( yada kopyalayıp tarayıcınızın adres çubuğuna yapıştırarak gidebilirsiniz) :\n\n";

// Password reset success
$lang['aauth_email_reset_success_subject'] = 'Şifre Sıfırlama Başarılı';
$lang['aauth_email_reset_success_new_password'] = 'Şifreniz başarıyla sıfırlanmıştır. Yeni şifreniz : ';


/* Error Messages */

// Account creation errors
$lang['aauth_error_email_exists'] = 'E-posta adresi sistemde kayıtlıdır. Şifrenizi unuttuysanız, aşağıdaki linke tıklayabilirsiniz.';
$lang['aauth_error_username_exists'] = "Bu kullanıcı adı ile tanımlı bir hesap bulunmaktadır. Lütfen farklı bir kullanıcı adı giriniz veya şifrenizi unuttuysanız, lütfen aşağıdaki linke tıklayınız.";
$lang['aauth_error_email_invalid'] = 'Geçersiz e-posta adresi';
$lang['aauth_error_password_invalid'] = 'Geçersiz şifre';
$lang['aauth_error_username_invalid'] = 'Geçersiz kullanıcı adı';
$lang['aauth_error_username_required'] = 'Kullanıcı adı zorunlu';
$lang['aauth_error_totp_code_required'] = 'Giriş kodu zorunlu';
$lang['aauth_error_totp_code_invalid'] = 'Geçersiz giriş kodu';


// Account update errors
$lang['aauth_error_update_email_exists'] = 'E-posta adresi sistemde kayıtlıdır.  Lütfen farklı bir e-posta adresi giriniz.';
$lang['aauth_error_update_username_exists'] = "Kullanıcı adresi sistemde kayıtlıdır. Lütfen farklı bir kullanıcı adı giriniz.";


// Access errors
$lang['aauth_error_no_access'] = 'Üzgünüz, ulaşmak istediğiniz adrese erişim yetkiniz yok. ';
$lang['aauth_error_login_failed_email'] = 'E-posta adresi ve şifre uyumsuz.';
$lang['aauth_error_login_failed_name'] = 'Kullanıcı adı ve şifre uyumsuz.';
$lang['aauth_error_login_failed_all'] = 'E-posta adresi, kullanıcı adı veya şifre uyumsuz.';
$lang['aauth_error_login_attempts_exceeded'] = 'Giriş deneme sayısını aştınız, hesabınız kilitlenmiştir.';
$lang['aauth_error_recaptcha_not_correct'] = 'Üzgünüz, girdiğiniz reCAPTCHA kelime(leri) yanlıştır.';

// Misc. errors
$lang['aauth_error_no_user'] = 'Kullanıcı yok';
$lang['aauth_error_account_not_verified'] = 'Hesabınız henüz onaylanmamıştır. Lütfen e-posta adresinizi kontrol edip, onaylayınız. (Bazı durumlarda spam klasörüne düşmesi sözkonusu olabilmektedir. Lütfen spam klasörünü de kontrol ediniz).';
$lang['aauth_error_no_group'] = 'Grup yok';
$lang['aauth_error_no_subgroup'] = 'Alt grup yok';
$lang['aauth_error_self_pm'] = 'Kendinize mesaj göndermeniz mümkün değildir. ';
$lang['aauth_error_no_pm'] = 'Özel mesaj yok';


/* Info messages */
$lang['aauth_info_already_member'] = 'Kullanıcı zaten grup üyesidir';
$lang['aauth_info_already_subgroup'] = 'Alt grup zaten grup üyesidir';
$lang['aauth_info_group_exists'] = 'Grup adı zaten mevcuttur';
$lang['aauth_info_perm_exists'] = 'İzin adı zaten mevcuttur';
