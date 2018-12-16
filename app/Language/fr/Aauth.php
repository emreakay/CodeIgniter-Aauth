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
 * Language French
 *
 * @package CodeIgniter-Aauth
 *
 * @codeCoverageIgnore
 */
return [
   'subjectVerification'    => 'Vérification de Compte',
   'subjectReset'           => 'Réinitialiser le mot de passe',
   'subjectResetSuccess'    => 'Réinitialisation de mot de passe réussie',

   'textVerification'       => "VPour réinitialiser votre mot de passe cliquez sur (ou copiez collez dans la barre d'adresse de votre navigateur) le lien ci-dessous:\n\n {link}",
   'textReset'              => "To reset your password click on (or copy and paste in your browser address bar) the link below:\n\n {link}",
   'textResetSuccess'       => 'Votre mot de passe a été réinitialisé avec succès. Votre nouveau mot de passe est: {password}',

   'infoCreateSuccess'      => 'Your account has successfully been created. You can now login.',
   'infoCreateVerification' => 'Your account has successfully been created. A email has been sent to your email address with verification details..',
   'infoUpdateSuccess'      => 'Your account has successfully updated.',
   'infoRemindSuccess'      => 'A email has been sent to your email address with reset instructions.',
   'infoResetSuccess'       => 'A email has been sent to your email address with your new password has been sent.',
   'infoVerification'       => 'Your account has been verified successfully, you can now login.',

   'noAccess'               => 'Désolé, vous n\'avez pas accès à cette ressource.',
   'notVerified'            => 'Votre compte n\'a pas été confirmé. Merci de vérifier vos email et de confirmer votre compte.',

   'loginFailedEmail'       => 'L\'adresse email et le mot de passe ne correspondent pas.',
   'loginFailedUsername'        => 'Le nom d\'utilisateur et le mot de passe ne correspondent pas.',
   'loginFailedAll'         => 'L\'adresse email, le nom d\'utilisateur ou le mot de passe ne correspondent pas.',
   'loginAttemptsExceeded'  => 'Vous avez dépassé le nombre de tentatives de connexion autorisées, votre compte a été bloqué.',

   'invalidUserBanned'      => 'This user is banned, please contact the system administrator.',
   'invalidEmail'           => 'Adresse email invalide',
   'invalidPassword'        => 'Mot de passe invalide',
   'invalidUsername'        => 'Nom d\'utilisateur invalide',
   'invalidTOTPCode'        => 'Code TOTP invalide',
   'invalidRecaptcha'       => 'Désolé, le texte renseigné pour le reCAPTCHA est incorrect.',
   'invalidVerficationCode' => 'Invalid Verification Code',

   'requiredUsername'       => 'Nom d\'utilisateur requis',
   'requiredTOTPCode'       => 'Code TOTP requis',
   'requiredGroupName'      => 'Group name required',
   'requiredPermName'       => 'Perm name required',

   'existsAlreadyEmail'     => 'Cette adresse email est déjà utilisée. Si vous avez oublié votre mot de passe cliquez sur le lien ci-dessous.',
   'existsAlreadyUsername'  => 'Un compte avec ce nom d\'utilisateur existe déjà. Merci de renseigner un nom d\'utilisateur différent. Si vous avez oublié votre mot de passe cliquez sur le lien ci-dessous.',
   'existsAlreadyGroup'     => 'Ce nom de groupe existe déjà',
   'existsAlreadyPerm'      => 'Ce nom de permission existe déjà',

   'notFoundUser'           => 'L\'utilisateur n\'existe pas',
   'notFoundGroup'          => 'Le groupe n\'existe pas',
   'notFoundSubgroup'       => 'Le groupe n\'existe pas',

   'alreadyMemberGroup'     => 'L\'utilisateur est déjà membre de ce groupe',
   'alreadyMemberSubgroup'  => 'Subgroup is already member of group',
];
