<?php
defined('BASEPATH') or exit('No direct script access allowed');

/* E-mail Messages */

// Account verification
$lang['aauth_email_verification_subject'] = 'Hesap Doğrulama';
$lang['aauth_email_verification_code']    = 'Doğrulama kodunuz: ';
$lang['aauth_email_verification_text']    = " Ayrıca aşağıdaki bağlantıya tıklayabilir (veya kopyalayıp yapıştırabilirsiniz)\n\n";

// Password reset
$lang['aauth_email_reset_subject'] = 'Şifreyi Sıfırla';
$lang['aauth_email_reset_text']    = "Parolanızı sıfırlamak için aşağıdaki bağlantıya tıklayın (veya tarayıcınızın adres çubuğuna kopyalayıp yapıştırın):\n\n";

// Password reset success
$lang['aauth_email_reset_success_subject']      = 'Başarılı Şifre Sıfırlama';
$lang['aauth_email_reset_success_new_password'] = 'Şifreniz başarıyla sıfırlandı. Yeni şifreniz:';

/* Error Messages */

// Account creation errors
$lang['aauth_error_email_exists']       = 'E-posta adresi sistemde zaten var. Eğer şifrenizi unuttuysanız, aşağıdaki linke tıklayabilirsiniz.';
$lang['aauth_error_username_exists']    = 'Bu kullanıcı adına sahip sistemde hesap zaten var. Lütfen farklı bir kullanıcı adı girin veya şifrenizi unuttuysanız, lütfen aşağıdaki bağlantıyı tıklayın.';
$lang['aauth_error_email_invalid']      = 'Geçersiz e-posta adresi';
$lang['aauth_error_password_invalid']   = 'Geçersiz şifre';
$lang['aauth_error_username_invalid']   = 'Geçersiz kullanıcı adı';
$lang['aauth_error_username_required']  = 'Kullanıcı adı gerekli';
$lang['aauth_error_totp_code_required'] = 'Kimlik Doğrulama Kodu gerekli';
$lang['aauth_error_totp_code_invalid']  = 'Geçersiz Kimlik Doğrulama Kodu';

// Account update errors
$lang['aauth_error_update_email_exists']    = 'E-posta adresi sistemde zaten var. Lütfen farklı bir e-posta adresi girin.';
$lang['aauth_error_update_username_exists'] = 'Kullanıcı adı zaten sistemde var. Lütfen farklı bir kullanıcı adı girin.';

// Access errors
$lang['aauth_error_no_access']               = 'Üzgünüz, istediğiniz kaynağa erişiminiz yok.';
$lang['aauth_error_login_failed_email']      = 'E-posta adresi ve şifre eşleşmiyor.';
$lang['aauth_error_login_failed_name']       = 'Kullanıcı adı ve şifre eşleşmiyor.';
$lang['aauth_error_login_failed_all']        = 'E-posta, Kullanıcı adı veya Şifre eşleşmiyor.';
$lang['aauth_error_login_attempts_exceeded'] = 'Giriş denemelerinizi aştınız, hesabınız kilitlendi.';
$lang['aauth_error_recaptcha_not_correct']   = 'Maalesef girilen reCAPTCHA metni hatalı.';

// Misc. errors
$lang['aauth_error_no_user']              = 'Kullanıcı yok';
$lang['aauth_error_vercode_invalid']      = 'Geçersiz Doğrulama Kodu';
$lang['aauth_error_account_not_verified'] = 'Hesabınız doğrulanmadı. Lütfen e-postanızı kontrol edin ve hesabınızı doğrulayın.';
$lang['aauth_error_no_group']             = 'Grup yok';
$lang['aauth_error_no_subgroup']          = 'Alt grup yok';
$lang['aauth_error_self_pm']              = 'Kendinize mesaj göndermeniz mümkün değildir.';
$lang['aauth_error_no_pm']                = 'Özel Mesaj bulunamadı';

/* Info messages */
$lang['aauth_info_already_member']   = 'Kullanıcı zaten gruba üye';
$lang['aauth_info_already_subgroup'] = 'Alt grup zaten grubun bir üyesi';
$lang['aauth_info_group_exists']     = 'Grup adı zaten var';
$lang['aauth_info_perm_exists']      = 'İzin adı zaten var';
