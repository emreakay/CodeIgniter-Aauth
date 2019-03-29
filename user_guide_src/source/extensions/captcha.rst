#######
CAPTCHA
#######

***************
Class Reference
***************

.. php:class:: CAPTCHA

  .. php:method:: verifyCaptchaResponse(string $response)

    Verify CAPTCHA Response

    :param  string  $response: Response string from CAPTCHA verification.
    :returns: Array with response informations.
    :rtype: array

  .. php:method:: generateCaptchaHtml()

    Generate CAPTCHA HTML

    :returns: CAPTCHA HTML Code
    :rtype: string

  .. php:method:: isCaptchaRequired()

    Checks if CAPTCHA is required

    :returns: TRUE if required, FALSE if not required
    :rtype: boolean
