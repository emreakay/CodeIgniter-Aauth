<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* E-mail Messages */

// Account verification
$lang['aauth_email_verification_subject'] = 'Bekräfta konto';
$lang['aauth_email_verification_code'] = 'Din bekräftelsekod är: ';
$lang['aauth_email_verification_text'] = " Du kan även trycka på (eller kopiera och klistra in) följande länk\n\n";

// Password reset
$lang['aauth_email_reset_subject'] = 'Återställ lösenord';
$lang['aauth_email_reset_text'] = "För att återställa ditt lösenord, tryck på (eller kopiera och klistra in i din webbläsares adressfält) länken nedan:\n\n";

// Password reset success
$lang['aauth_email_reset_success_subject'] = 'Lösenordsåterställning skickad';
$lang['aauth_email_reset_success_new_password'] = 'Ditt lösenord har blivit återställt. Ditt nya lösenord är: ';


/* Error Messages */

// Account creation errors
$lang['aauth_error_email_exists'] = 'E-postadressen finns redan i systemet. Om du glömt ditt lösenord kan du trycka på länken nedan.';
$lang['aauth_error_username_exists'] = "Det finns redan ett konto i systemet med det användarnamnet. Var vänlig ange ett annat användarnamn. Om du lömt ditt lösenord var vänlig tryck på länken nedan.";
$lang['aauth_error_email_invalid'] = 'Ogiltig e-postadress';
$lang['aauth_error_password_invalid'] = 'Ogiltigt lösenord';
$lang['aauth_error_username_invalid'] = 'Ogiltigt användarnamn';
$lang['aauth_error_username_required'] = 'Användarnamn obligatoriskt';
$lang['aauth_error_totp_code_required'] = 'Bekräftelsekod behövs';
$lang['aauth_error_totp_code_invalid'] = 'Ogiltig bekräftelsekod';


// Account update errors
$lang['aauth_error_update_email_exists'] = 'E-postadressen finns redan i systemet. Var vänlig ange en annan e-postadress.';
$lang['aauth_error_update_username_exists'] = "Användarnamnet finns redan i systemet. Var vänlig ange ett annan användarnamn.";


// Access errors
$lang['aauth_error_no_access'] = 'Du har tyvärr inte rättighet att visa den här resursen.';
$lang['aauth_error_login_failed_email'] = 'E-postadressen och lösenordet stämmer inte överens.';
$lang['aauth_error_login_failed_name'] = 'Användarnamnet och lösenordet stämmer inte överens.';
$lang['aauth_error_login_failed_all'] = 'E-postadress, användarnamn och lösenord stämmer inte överens.';
$lang['aauth_error_login_attempts_exceeded'] = 'Du har förbrukat dina försök att logga in, ditt konto har blivit låst.';
$lang['aauth_error_recaptcha_not_correct'] = 'Tyvärr, reCAPTCHA-texten var felaktig.';

// Misc. errors
$lang['aauth_error_no_user'] = 'Användaren finns inte.';
$lang['aauth_error_account_not_verified'] = 'Ditt konto är inte bekräftat. Var vänlig kolla din e-post och bekräfta ditt konto.';
$lang['aauth_error_no_group'] = 'Gruppen finns inte.';
$lang['aauth_error_no_subgroup'] = 'Undergruppen finns inte.';
$lang['aauth_error_self_pm'] = 'Det är inte möjligt att skicka meddelanden till dig själv.';
$lang['aauth_error_no_pm'] = 'Meddelande hittades inte.';


/* Info messages */
$lang['aauth_info_already_member'] = 'Användaren är redan med i gruppen.';
$lang['aauth_info_already_subgroup'] = 'Undergruppen är redan med i gruppen.';
$lang['aauth_info_group_exists'] = 'Gruppnamnet finns redan.';
$lang['aauth_info_perm_exists'] = 'Rättighetsnamnet finns redan.';
