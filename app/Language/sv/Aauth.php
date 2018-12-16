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
 * Language Swedish
 *
 * @package CodeIgniter-Aauth
 *
 * @codeCoverageIgnore
 */
return [
   'subjectVerification'    => 'Bekräfta konto',
   'subjectReset'           => 'Återställ lösenord',
   'subjectResetSuccess'    => 'Lösenordsåterställning skickad',

   'textVerification'       => "Din bekräftelsekod är: {code}. Du kan även trycka på (eller kopiera och klistra in) följande länk\n\n {link}",
   'textReset'              => "För att återställa ditt lösenord, tryck på (eller kopiera och klistra in i din webbläsares adressfält) länken nedan:\n\n {link}",
   'textResetSuccess'       => 'Ditt lösenord har blivit återställt. Ditt nya lösenord är: {password}',

   'infoCreateSuccess'      => 'Your account has successfully been created. You can now login.',
   'infoCreateVerification' => 'Your account has successfully been created. A email has been sent to your email address with verification details..',
   'infoUpdateSuccess'      => 'Your account has successfully updated.',
   'infoRemindSuccess'      => 'A email has been sent to your email address with reset instructions.',
   'infoResetSuccess'       => 'A email has been sent to your email address with your new password has been sent.',
   'infoVerification'       => 'Your account has been verified successfully, you can now login.',

   'noAccess'               => 'Du har tyvärr inte rättighet att visa den här resursen.',
   'notVerified'            => 'Ditt konto är inte bekräftat. Var vänlig kolla din e-post och bekräfta ditt konto.',

   'loginFailedEmail'       => 'E-postadressen och lösenordet stämmer inte överens.',
   'loginFailedUsername'        => 'Användarnamnet och lösenordet stämmer inte överens.',
   'loginFailedAll'         => 'E-postadress, användarnamn och lösenord stämmer inte överens.',
   'loginAttemptsExceeded'  => 'Du har förbrukat dina försök att logga in, ditt konto har blivit låst.',

   'invalidUserBanned'      => 'This user is banned, please contact the system administrator.',
   'invalidEmail'           => 'Ogiltig e-postadress',
   'invalidPassword'        => 'Ogiltigt lösenord',
   'invalidUsername'        => 'Ogiltigt användarnamn',
   'invalidTOTPCode'        => 'Ogiltig bekräftelsekod',
   'invalidRecaptcha'       => 'Tyvärr, reCAPTCHA-texten var felaktig.',
   'invalidVerficationCode' => 'Invalid Verification Code',

   'requiredUsername'       => 'Användarnamn obligatoriskt',
   'requiredTOTPCode'       => 'Bekräftelsekod behövs',
   'requiredGroupName'      => 'Group name required',
   'requiredPermName'       => 'Perm name required',

   'existsAlreadyEmail'     => 'E-postadressen finns redan i systemet. Om du glömt ditt lösenord kan du trycka på länken nedan.',
   'existsAlreadyUsername'  => 'Det finns redan ett konto i systemet med det användarnamnet. Var vänlig ange ett annat användarnamn. Om du lömt ditt lösenord var vänlig tryck på länken nedan.',
   'existsAlreadyGroup'     => 'Gruppnamnet finns redan.',
   'existsAlreadyPerm'      => 'Rättighetsnamnet finns redan.',

   'notFoundUser'           => 'Användaren finns inte',
   'notFoundGroup'          => 'Gruppen finns inte',
   'notFoundSubgroup'       => 'Undergruppen finns inte',

   'alreadyMemberGroup'     => 'Användaren är redan med i gruppen.',
   'alreadyMemberSubgroup'  => 'Undergruppen är redan med i gruppen.',
];
