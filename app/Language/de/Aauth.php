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
 * Language German
 *
 * @package CodeIgniter-Aauth
 *
 * @codeCoverageIgnore
 */
return [
   'subjectVerification'    => 'Account Bestätigung',
   'subjectReset'           => 'Passwort zurücksetzen',
   'subjectResetSuccess'    => 'Passwort zurückgesetzt',

   'textVerification'       => "Dein Bestätigungscode lautet: {code}.  Du kannst auch den Link anklicken (oder deinem Browser aufrufen) \n\n {link}",
   'textReset'              => "Um dein Passwort zurückzusetzen folge (oder ruf ihn im Browser auf) diesem Link:\n\n {link}",
   'textResetSuccess'       => 'Du hast dein Passwort erfolgreich zurückgesetzt. Dein neues Passwort lautet: {password}',

   'infoCreateSuccess'      => 'Dein Benutzerkonto wurde erfolgreich erstellt, du kannst dich jetzt einloggen.',
   'infoCreateVerification' => 'Dein Benutzerkonto wurde erfolgreich erstellt. Eine E-Mail mit Informationen zur Bestätigung wurde an deine E-Mail-Adresse versendet. ',
   'infoUpdateSuccess'      => 'Dein Benutzerkonto wurde erfolgreich geändert.',
   'infoRemindSuccess'      => 'Eine E-Mail mit Informationen zum zurückzusetzen wurde an deine E-Mail-Adresse versendet.',
   'infoResetSuccess'       => 'Eine E-Mail mit deinem neuem Passwort wurde an deine E-Mail-Adresse versendet.',
   'infoVerification'       => 'Dein Benutzerkonto wurde erfolgreich bestätigt, du kannst dich jetzt einloggen.',

   'noAccess'               => 'Entschuldige, aber du hast kein Zugriffsrecht auf die angeforderte Seite.',
   'notVerified'            => 'Dein Account wurde bisher nicht bestätigt. Bitte prüfe deine E-Mails und bestätige deine Registrierung.',

   'loginFailedEmail'       => 'E-Mail-Adresse oder Passwort falsch.',
   'loginFailedUsername'    => 'Benutzername oder Passwort falsch.',
   'loginFailedAll'         => 'E-Mail-Adresse, Benutzername oder Passwort falsch.',
   'loginAttemptsExceeded'  => 'Du hast die maximale Anzahl Login versuche erreicht, dein Account wurde gesperrt.',

   'invalidUserBanned'      => 'Dieser Benutzer ist gesperrt, bitte kontaktierre den Webmaster.',
   'invalidEmail'           => 'Ungültige E-Mail-Adresse',
   'invalidPassword'        => 'Ungültiges Passwort',
   'invalidUsername'        => 'Ungültiger Benutzername',
   'invalidTOTPCode'        => 'Ungültiger Bestätigungscode',
   'invalidRecaptcha'       => 'Hupps, der eingegebene reCAPTCHA Text war falsch.',
   'invalidVerficationCode' => 'Ungültiger Überprüfungs-Code',

   'requiredUsername'       => 'Benutzername wird benötigt',
   'requiredTOTPCode'       => 'Bestätigungscode wird benötigt',
   'requiredGroupName'      => 'Gruppen-Name wird benötigt',
   'requiredPermName'       => 'Berechtigungs-Regel-Name wird benötigt',

   'existsAlreadyEmail'     => 'Diese E-Mail-Adresse ist bereits registriert. Wenn du dein Passwort vergessen hast,
											folge dem Link unten.',
   'existsAlreadyUsername'  => 'Der Benutzername wird bereits verwendet. Bitte wähle einen anderen Benutzernamen.
											Wenn du dein Passwort vergessen hast, folge dem Link unten.',
   'existsAlreadyGroup'     => 'Diese Gruppe existiert bereits',
   'existsAlreadyPerm'      => 'Der Berechtigungs-Regel-Name wurde bereits verwendet',

   'notFoundUser'           => 'Der Benutzer existiert nicht',
   'notFoundGroup'          => 'Die Gruppe existiert nicht',
   'notFoundSubgroup'       => 'Die Untergruppe existiert nicht',

   'alreadyMemberGroup'     => 'Der Benutzer ist bereits in dieser Gruppe',
   'alreadyMemberSubgroup'  => 'Diese Untergruppe ist bereits dieser gruppe zugeordnet',
];
