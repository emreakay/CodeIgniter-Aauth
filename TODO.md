# ToDo

## GitHub
  - PHPUnit tests over Travis-CI.org & Code-Coverage over CodeCov. 

## Code

### Login Tokens
  - Config for Cookie Name
  - Single Login (Only one Token per User)
  - Remove Token on Update User Password?

### DDOS
  - Cookie usage?
  - UserId to DB

### Login
  - Single Login mode (allow only one session per user) (#187)
  - Config for unified error message (Email or Password wrong vs Email wrong ...)
  - TOTP
  - hCAPTCHA
  - reCAPTCHA
  - oAuth2
    - Facebook
    - Github
    - Twitter

### listUsers
  - remove * from select on list_users (#184)
  - bool|integer $group_par Specify group id to list group or FALSE for all users

### getUser
  - Maybe we remove the model find if $email is not set (return sessions id)

### From CI3 V3 Issue
  x add CI's Form Validation support (User, Group & Perms trough CI4's Model)

  - add foreign key to database tables
  - Unspecific session variable names for user (#177) ->session->id to ->session->user->id ...
  - easy Migration from v2.X
    - how to do without using Migration or rebuild migrations table for further updates

  x Login with email and username (idk main behavior or config option)
  x basic ui (login/register, user-, group-, perm-management, pm center, etc.)
  x change licence to MIT (#88)
  x change email to use a view with passed parameters, instead of plain text