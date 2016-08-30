<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* E-mail Messages */

// Account verification
$lang['aauth_email_verification_subject'] = 'Verificación de Cuenta';
$lang['aauth_email_verification_code'] = 'Tu código de verificación es: ';
$lang['aauth_email_verification_text'] = " También puedes hacer click (o copia y pega en tu navegador) en el siguiente link. \n\n";

// Password reset
$lang['aauth_email_reset_subject'] = 'Reiniciar contraseña';
$lang['aauth_email_reset_text'] = "Para reiniciar la contraseña click (o copia y pega en tu navegador) el siguiente link:\n\n";

// Password reset success
$lang['aauth_email_reset_success_subject'] = 'Constraseña reiniciada exitosamente';
$lang['aauth_email_reset_success_new_password'] = 'Tu contraseña ha sido correctamente reiniciada. Tu nueva contraseña es : ';


/* Error Messages */

// Account creation errors
$lang['aauth_error_email_exists'] = 'El correo electrónico ya existe. Si olvidaste tu contraseña, puedes hacer click en el siguiente link.';
$lang['aauth_error_username_exists'] = "Ya existe una cuenta con ese nombre de usuario. Por favor ingrese un nombre de usuario diferente, o si olvidaste tu contraseña puedes hacer click en el siguiente link.";
$lang['aauth_error_email_invalid'] = 'Correo electrónico inválido';
$lang['aauth_error_password_invalid'] = 'Contraseña invalida';
$lang['aauth_error_username_invalid'] = 'Nombre de usuario invalido';
$lang['aauth_error_username_required'] = 'Nombre de usuario obligatorio';
$lang['aauth_error_totp_code_required'] = 'El código TOTP es obligatorio';
$lang['aauth_error_totp_code_invalid'] = 'Código TOTP obligatorio';


// Account update errors
$lang['aauth_error_update_email_exists'] = 'El correo electrónico ya existe, por favor ingresa un correo electrónico diferente.';
$lang['aauth_error_update_username_exists'] = "El nombre de usuario ya existe, por favor ingresa un nombre de usuario diferente.";


// Access errors
$lang['aauth_error_no_access'] = 'Ups, lo siento, no tienes permiso para ver el recurso solicitado.';
$lang['aauth_error_login_failed_email'] = 'El Correo electrónico y contraseña no coinciden.';
$lang['aauth_error_login_failed_name'] = 'El Nombre de usuario y contraseña no coinciden.';
$lang['aauth_error_login_failed_all'] = 'El Correo electrónico, nombre de usuario y contraseña no coinciden.';
$lang['aauth_error_login_attempts_exceeded'] = 'Has excedido el número de intentos de inicio de sesión, tu cuenta ha sido bloqueada.';
$lang['aauth_error_recaptcha_not_correct'] = 'Ups, El texto ingresado es incorrecto.';

// Misc. errors
$lang['aauth_error_no_user'] = 'El usuario no existe.';
$lang['aauth_error_account_not_verified'] = 'Tu cuenta aún no ha sido verificada, por favor revisa tu correo electrónico y verifica tu cuenta.';
$lang['aauth_error_no_group'] = 'El grupo no existe';
$lang['aauth_error_self_pm'] = 'No es posible enviarte un mensaje a ti mismo.';
$lang['aauth_error_no_pm'] = 'Mensaje privado no encontrado';


/* Info messages */
$lang['aauth_info_already_member'] = 'El usuario ya es miembro del grupo';
$lang['aauth_info_group_exists'] = 'El nombre del grupo ya existe';
$lang['aauth_info_perm_exists'] = 'El nombre del permiso ya existe';
