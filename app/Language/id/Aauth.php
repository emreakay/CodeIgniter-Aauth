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
 * Language Indonesian
 *
 * @package CodeIgniter-Aauth
 *
 * @codeCoverageIgnore
 */
return [
   'subjectVerification'    => 'Verifikasi Akun',
   'subjectReset'           => 'Ganti Kata Sandi',
   'subjectResetSuccess'    => 'Berhasil mengubah kata sandi',

   'textVerification'       => "Kode verifikasi anda adalah: {code}. Anda juga bisa klik (atau salin dan tempel) tautan berikut ini\n\n {link}",
   'textReset'              => "Untuk mengganti kata sandi klik (atau salin dan tempel) tautan dibawah ini:\n\n {link}",
   'textResetSuccess'       => 'Kata sandi anda berhasil diubah. Kata sandi baru anda adalah: {password}',

   'infoCreateSuccess'      => 'Your account has successfully been created. You can now login.',
   'infoCreateVerification' => 'Your account has successfully been created. A email has been sent to your email address with verification details..',
   'infoUpdateSuccess'      => 'Your account has successfully updated.',
   'infoRemindSuccess'      => 'A email has been sent to your email address with reset instructions.',
   'infoResetSuccess'       => 'A email has been sent to your email address with your new password has been sent.',
   'infoVerification'       => 'Your account has been verified successfully, you can now login.',

   'noAccess'               => 'Maaf, Anda tidak memiliki akses ke sumber daya yang Anda minta.',
   'notVerified'            => 'Akun anda belum diverifikasi. Silakan cek email anda dan verifikasi akun anda.',

   'loginFailedEmail'       => 'Email dan sandi yang anda masukkan tidak cocok.',
   'loginFailedUsername'    => 'Username dan sandi yang Anda masukkan tidak cocok.',
   'loginFailedAll'         => 'Email, username dan sandi yang Anda masukkan tidak cocok.',
   'loginAttemptsExceeded'  => 'Anda telah melebihi upaya login anda, akun anda telah diblokir.',

   'invalidUserBanned'      => 'This user is banned, please contact the system administrator.',
   'invalidEmail'           => 'Alamat email tidak valid',
   'invalidPassword'        => 'kata sandi tidak valid',
   'invalidUsername'        => 'Username tidak valid',
   'invalidVerficationCode' => 'Invalid Verification Code',

   'requiredUsername'       => 'Username tidak boleh kosong',
   'requiredGroupName'      => 'Group name required',
   'requiredPermName'       => 'Perm name required',

   'existsAlreadyEmail'     => 'Email sudah digunakan di sistem. Jika anda lupa kata sandi, silahkan klik tautan dibawah ini.',
   'existsAlreadyUsername'  => 'Username telah digunakan oleh akun lain pada sistem.  Silahkan masukan username lain, atau jika anda lupa kata sandi, silahkan klik tautan dibawah ini.',
   'existsAlreadyGroup'     => 'Nama grup sudah ada',
   'existsAlreadyPerm'      => 'Nama izin sudah ada',

   'notFoundUser'           => 'Pengguna tidak ada',
   'notFoundGroup'          => 'Grup tidak ada',
   'notFoundSubgroup'       => 'Sub-grup tidak ada',

   'alreadyMemberGroup'     => 'Pengguna sudah menjadi anggota grup',
   'alreadyMemberSubgroup'  => 'Sub-grup sudah menjadi anggota grup',
];
