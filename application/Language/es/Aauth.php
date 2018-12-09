<?php
/**
 * CodeIgniter-Aauth
 *
 * Aauth is a User Authorization Library for CodeIgniter 4.x, which aims to make
 * easy some essential jobs such as login, permissions and access operations.
 * Despite ease of use, it has also very advanced features like groupping,
 * access management, public access etc..
 *
 * @package   CodeIgniter-Aauth
 * @author    Magefly Team
 * @copyright 2014-2017 Emre Akay
 * @copyright 2018 Magefly
 * @license   https://opensource.org/licenses/MIT	MIT License
 * @link      https://github.com/magefly/CodeIgniter-Aauth
 */

/**
 * Aauth language strings.
 *
 * Language Spanish
 *
 * @package CodeIgniter-Aauth
 *
 * @codeCoverageIgnore
 */
return [
   'subjectVerification'    => 'Verificación de Cuenta',
   'subjectReset'           => 'Reiniciar contraseña',
   'subjectResetSuccess'    => 'Constraseña reiniciada exitosamente',

   'textVerification'       => "Tu código de verificación es: {code}. También puedes hacer click (o copia y pega en tu navegador) en el siguiente link.\n\n {link}",
   'textReset'              => "Para reiniciar la contraseña click (o copia y pega en tu navegador) el siguiente link:\n\n {link}",
   'textResetSuccess'       => 'Tu contraseña ha sido correctamente reiniciada. Tu nueva contraseña es: {password}',

   'infoCreateSuccess'      => 'Your account has successfully been created. You can now login.',
   'infoCreateVerification' => 'Your account has successfully been created. A email has been sent to your email address with verification details..',
   'infoUpdateSuccess'      => 'Your account has successfully updated.',
   'infoRemindSuccess'      => 'A email has been sent to your email address with reset instructions.',
   'infoResetSuccess'       => 'A email has been sent to your email address with your new password has been sent.',
   'infoVerification'       => 'Your account has been verified successfully, you can now login.',

   'noAccess'               => 'Ups, lo siento, no tienes permiso para ver el recurso solicitado.',
   'notVerified'            => 'Tu cuenta aún no ha sido verificada, por favor revisa tu correo electrónico y verifica tu cuenta.',

   'loginFailedEmail'       => 'El Correo electrónico y contraseña no coinciden.',
   'loginFailedUsername'        => 'El Nombre de usuario y contraseña no coinciden.',
   'loginFailedAll'         => 'El Correo electrónico, nombre de usuario y contraseña no coinciden.',
   'loginAttemptsExceeded'  => 'Has excedido el número de intentos de inicio de sesión, tu cuenta ha sido bloqueada.',

   'invalidUserBanned'      => 'This user is banned, please contact the system administrator.',
   'invalidEmail'           => 'Correo electrónico inválido',
   'invalidPassword'        => 'Contraseña invalida',
   'invalidUsername'        => 'Nombre de usuario invalido',
   'invalidTOTPCode'        => 'Código TOTP obligatorio',
   'invalidRecaptcha'       => 'Ups, El texto ingresado es incorrecto.',
   'invalidVerficationCode' => 'Código de verificación invalido',

   'requiredUsername'       => 'Nombre de usuario obligatorio',
   'requiredTOTPCode'       => 'El código TOTP es obligatorio',
   'requiredGroupName'      => 'Group name required',
   'requiredPermName'       => 'Perm name required',

   'existsAlreadyEmail'     => 'El correo electrónico ya existe. Si olvidaste tu contraseña, puedes hacer click en el siguiente link.',
   'existsAlreadyUsername'  => 'Ya existe una cuenta con ese nombre de usuario. Por favor ingrese un nombre de usuario diferente, o si olvidaste tu contraseña puedes hacer click en el siguiente link.',
   'existsAlreadyGroup'     => 'El nombre del grupo ya existe',
   'existsAlreadyPerm'      => 'El nombre del permiso ya existe',

   'notFoundUser'           => 'El usuario no existe.',
   'notFoundGroup'          => 'El grupo no existe',
   'notFoundSubgroup'       => 'El subgrupo no existe',

   'alreadyMemberGroup'     => 'El usuario ya es miembro del grupo',
   'alreadyMemberSubgroup'  => 'El subgrupo ya es miembro del grupo',
];
