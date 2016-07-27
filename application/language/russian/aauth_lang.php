<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* E-mail Messages */

// Account verification
$lang['aauth_email_verification_subject'] = 'Подтверждение аккаунта';
$lang['aauth_email_verification_code'] = 'Ваш код подтверждения: ';
$lang['aauth_email_verification_text'] = " Так же вы можете нажать (или скопировать/вставить в адресную строку браузера) следующую ссылку\n\n";

// Password reset
$lang['aauth_email_reset_subject'] = 'Сброс пароля';
$lang['aauth_email_reset_text'] = "Для сброса пароля нажмите (или скопируйте/вставьте в адресную строку браузера) ссылку:\n\n";

// Password reset success
$lang['aauth_email_reset_success_subject'] = 'Сброс пароля выполнен';
$lang['aauth_email_reset_success_new_password'] = 'Ваш пароль сброшен. Ваш новый пароль : ';


/* Error Messages */

// Account creation errors
$lang['aauth_error_email_exists'] = 'Email уже зарегистрирован в системе. Если вы забыли ваш пароль, нажмите на ссылку ниже.';
$lang['aauth_error_username_exists'] = "Аккаунт с этим именен пользователя уже есть в системе.  Введите другое имя пользователя, или если вы забыли ваш пароль, нажмите на ссылку ниже.";
$lang['aauth_error_email_invalid'] = 'Некорректный адрес e-mail';
$lang['aauth_error_password_invalid'] = 'Некорректный пароль';
$lang['aauth_error_username_invalid'] = 'Некорректное имя пользователя';
$lang['aauth_error_username_required'] = 'Логин обязателен';
$lang['aauth_error_totp_code_required'] = 'Требуется код аутентификации';
$lang['aauth_error_totp_code_invalid'] = 'Неверный код аутентификации';


// Account update errors
$lang['aauth_error_update_email_exists'] = 'Указанный Email уже есть в системе.  Введите другой адрес.';
$lang['aauth_error_update_username_exists'] = "Указаное имя пользователя уже есть в системе.  Введите другое имя пользователя.";


// Access errors
$lang['aauth_error_no_access'] = 'Извините, у вас нет доступа к запрашиваемому ресурсу.';
$lang['aauth_error_login_failed_email'] = 'Неверный email или пароль.';
$lang['aauth_error_login_failed_name'] = 'Неверное имя пользователя или пароль.';
$lang['aauth_error_login_failed_all'] = 'Неверный E-mail, имя пользователя или пароль.';
$lang['aauth_error_login_attempts_exceeded'] = 'Количество попыток входа превышено, ваш аккаунт временно заблокирован.';
$lang['aauth_error_recaptcha_not_correct'] = 'Извините, текст с reCAPTCHA введен неверно.';

// Misc. errors
$lang['aauth_error_no_user'] = 'Пользователь не существует';
$lang['aauth_error_account_not_verified'] = 'Ваш акккаунт не подтвержден. Проверьте ваш ящик e-mail и подтвердите аккаунт.';
$lang['aauth_error_no_group'] = 'Группа не существует';
$lang['aauth_error_no_subgroup'] = 'Подгруппа не существует';
$lang['aauth_error_self_pm'] = 'Нельзя отправить сообщение самому себе.';
$lang['aauth_error_no_pm'] = 'Личное сообщение не найдено';


/* Info messages */
$lang['aauth_info_already_member'] = 'Пользователь уже состоит в группе';
$lang['aauth_info_already_subgroup'] = 'Подгруппа состоит в группе';
$lang['aauth_info_group_exists'] = 'Такое имя группы уже есть';
$lang['aauth_info_perm_exists'] = 'Такое имя разрешений уже есть';
