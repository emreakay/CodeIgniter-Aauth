<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* E-mail Messages */

// Account verification
$lang['aauth_email_verification_subject'] = 'Account Bestätigung';
$lang['aauth_email_verification_code'] = 'Dein Bestätigungscode lautet: ';
$lang['aauth_email_verification_text'] = " Du kannst auch den Link anklicken (oder deinem Browser aufrufen) \n\n";

// Password reset
$lang['aauth_email_reset_subject'] = 'Passwort zurücksetzen';
$lang['aauth_email_reset_text'] = "Um dein Passwort zurückzusetzen folge (oder ruf ihn im Browser auf) diesem Link:\n\n";

// Password reset success
$lang['aauth_email_reset_success_subject'] = 'Passwort zurückgesetzt';
$lang['aauth_email_reset_success_new_password'] = 'Du hast dein Passwort erfolgreich zurückgesetzt. Dein neues Passwort lautet: ';


/* Error Messages */

// Account creation errors
$lang['aauth_error_email_exists'] = 'Diese E-Mail-Adresse ist bereits registriert. Wenn du dein Passwort vergessen hast, folge dem Link unten.';
$lang['aauth_error_username_exists'] = "Der Benutzername wird bereits verwendet.  Bitte wähle einen anderen Benutzernamen. Wenn du dein Passwort vergessen hast, folge dem Link unten.";
$lang['aauth_error_email_invalid'] = 'Ungültige E-Mail-Adresse';
$lang['aauth_error_password_invalid'] = 'Ungültiges Passwort';
$lang['aauth_error_username_invalid'] = 'Ungültiger Benutzername';
$lang['aauth_error_username_required'] = 'Benutzername wird benötigt';
$lang['aauth_error_totp_code_required'] = 'Bestätigungscode wird benötigt';
$lang['aauth_error_totp_code_invalid'] = 'Ungültiger Bestätigungscode';


// Account update errors
$lang['aauth_error_update_email_exists'] = 'Diese E-Mail-Adresse ist bereits registriert.  Bitte gib eine andere E-Mail-Adresse ein.';
$lang['aauth_error_update_username_exists'] = "Der Benutzername wird bereits verwendet.  Bitte gib einen anderen Benutzernamen ein.";


// Access errors
$lang['aauth_error_no_access'] = 'Entschuldige, aber du hast kein Zugriffsrecht auf die angeforderte Seite.';
$lang['aauth_error_login_failed_email'] = 'E-Mail-Adresse oder Passwort falsch.';
$lang['aauth_error_login_failed_name'] = 'Benutzername oder Passwort falsch.';
$lang['aauth_error_login_failed_all'] = 'E-Mail-Adresse, Benutzername oder Passwort falsch.';
$lang['aauth_error_login_attempts_exceeded'] = 'Du hast die maximale Anzahl Login versuche erreicht, dein Account wurde gesperrt.';
$lang['aauth_error_recaptcha_not_correct'] = 'Hupps, der eingegebene reCAPTCHA Text war falsch.';

// Misc. errors
$lang['aauth_error_no_user'] = 'Der Benutzer existiert nicht';
$lang['aauth_error_account_not_verified'] = 'Dein Account wurde bisher nicht bestätigt. Bitte prüfe deine E-Mails und bestätige deine Registrierung.';
$lang['aauth_error_no_group'] = 'Die Gruppe existiert nicht';
$lang['aauth_error_no_subgroup'] = 'Die Untergruppe existiert nicht';
$lang['aauth_error_self_pm'] = 'Du kannst keine Nachrichten an dich selbst senden.';
$lang['aauth_error_no_pm'] = 'Du hast keine privaten Nachrichten';


/* Info messages */
$lang['aauth_info_already_member'] = 'Der Benutzer ist bereits in dieser Gruppe';
$lang['aauth_info_already_subgroup'] = 'Diese Untergruppe ist bereits dieser gruppe zugeordnet';
$lang['aauth_info_group_exists'] = 'Diese Gruppe existiert bereits';
$lang['aauth_info_perm_exists'] = 'Der Berechtigungs-Regel-Name wurde bereits verwendet';
