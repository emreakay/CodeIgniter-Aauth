<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* E-mail Messages */

// Account verification
$lang['aauth_email_verification_subject'] = 'Verifikasi Akun';
$lang['aauth_email_verification_code'] = 'Kode verifikasi anda adalah: ';
$lang['aauth_email_verification_text'] = "Anda juga bisa klik (atau salin dan tempel) tautan berikut ini\n\n";

// Password reset
$lang['aauth_email_reset_subject'] = 'Ganti Kata Sandi';
$lang['aauth_email_reset_text'] = "Untuk mengganti kata sandi klik (atau salin dan tempel) tautan dibawah ini:\n\n";

// Password reset success
$lang['aauth_email_reset_success_subject'] = 'Berhasil mengubah kata sandi';
$lang['aauth_email_reset_success_new_password'] = 'Kata sandi anda berhasil diubah. Kata sandi baru anda adalah : ';


/* Error Messages */

// Account creation errors
$lang['aauth_error_email_exists'] = 'Email sudah digunakan di sistem. Jika anda lupa kata sandi, silahkan klik tautan dibawah ini.';
$lang['aauth_error_username_exists'] = "Username telah digunakan oleh akun lain pada sistem.  Silahkan masukan username lain, atau jika anda lupa kata sandi, silahkan klik tautan dibawah ini.";
$lang['aauth_error_email_invalid'] = 'Alamat email tidak valid';
$lang['aauth_error_password_invalid'] = 'kata sandi tidak valid';
$lang['aauth_error_username_invalid'] = 'Username tidak valid';
$lang['aauth_error_username_required'] = 'Username tidak boleh kosong';
$lang['aauth_error_totp_code_required'] = 'Kode autentikasi tidak boleh kosong';
$lang['aauth_error_totp_code_invalid'] = 'Kode autentikasi tidak valid';


// Account update errors
$lang['aauth_error_update_email_exists'] = 'Alamat email telah digunakan pada sistem.  Silahkan masukan alamat email lainya.';
$lang['aauth_error_update_username_exists'] = "Username telah digunakan pada sistem.  Silahkan masukan username lainya.";


// Access errors
$lang['aauth_error_no_access'] = 'Maaf, Anda tidak memiliki akses ke sumber daya yang Anda minta.';
$lang['aauth_error_login_failed_email'] = 'Email dan sandi yang anda masukkan tidak cocok.';
$lang['aauth_error_login_failed_name'] = 'Username dan sandi yang Anda masukkan tidak cocok.';
$lang['aauth_error_login_failed_all'] = 'Email, username dan sandi yang Anda masukkan tidak cocok.';
$lang['aauth_error_login_attempts_exceeded'] = 'Anda telah melebihi upaya login anda, akun anda telah diblokir.';
$lang['aauth_error_recaptcha_not_correct'] = 'Maaf, teks reCAPTCHA yang anda dimasukkan salah.';

// Misc. errors
$lang['aauth_error_no_user'] = 'Pengguna tidak ada';
$lang['aauth_error_account_not_verified'] = 'Akun anda belum diverifikasi. Silakan cek email anda dan verifikasi akun anda .';
$lang['aauth_error_no_group'] = 'Grup tidak ada';
$lang['aauth_error_self_pm'] = 'Tidak dapat mengirim pesan kepada diri sendiri.';
$lang['aauth_error_no_pm'] = 'Pesan Pribadi tidak ditemukan';


/* Info messages */
$lang['aauth_info_already_member'] = 'Pengguna sudah anggota grup';
$lang['aauth_info_group_exists'] = 'Nama grup sudah ada';
$lang['aauth_info_perm_exists'] = 'Nama izin sudah ada';
