# ToDo

# Login Tokens
  - Config for Cookie Name
  - Single Login (Only one Token per User)

# DDOS
  - Cookie usage?
  - UserId to DB

# Login
  - TOTP
  - reCAPTCHA
  - oAuth2
    - Facebook
    - Github
    - Twitter
    - ...

# listUsers
  - bool|integer $group_par Specify group id to list group or FALSE for all users

# getUser
  - Maybe we remove the model find if $email is not set (return sessions id)
