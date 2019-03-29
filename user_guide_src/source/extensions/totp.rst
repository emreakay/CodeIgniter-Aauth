####
TOTP
####

***************
Class Reference
***************

.. php:class:: TOTP

  .. php:method:: updateUserTotpSecret(int $userId = null, string $secret)

    Update User TOTP Secret

    :param  integer $userId: User Id
    :param  string  $secret: Secret Key
    :returns: TRUE if success, FALSE if failed
    :rtype: boolean

   .. php:method:: generateUniqueTotpSecret()

    Generate unique TOTP Secret

    :returns: TOTP Secret
    :rtype: string

  .. php:method:: generateTotpQrCode(string $secret[, string $label = '')

    Generate TOTP QR Code URL

    :param  string  $secret: Secret Key
    :param  string  $label: Label
    :returns: QR Code URL
    :rtype: string

  .. php:method:: verifyUserTotpCode(int $totpCode[, int $userId = null])

    Verify user TOTP Code

    :param  integer $totpCode: TOTP Code
    :param  integer $userId: User Id
    :returns: CAPTCHA HTML Code
    :rtype: string

  .. php:method:: isTotpRequired()

    Checks if TOTP is required

    :returns: TRUE if required, FALSE if not required
    :rtype: boolean
