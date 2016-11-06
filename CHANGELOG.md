## Change Log

### v2.5.12 (2016/9/21)
 - [ef8bfa0](https://github.com/emreakay/CodeIgniter-Aauth/commit/ef8bfa001442468c89886d3df29e799362a62542) add sort parameter to list_users (#176) (@REJack)
 - [e9e1503](https://github.com/emreakay/CodeIgniter-Aauth/commit/e9e15035d65796aa722a6a98d1201bef6497c6a8) is_allowed improvement (#166) (@REJack)
 - [f54cab0](https://github.com/emreakay/CodeIgniter-Aauth/commit/f54cab050aba62d9ebe6593871eb7b2dddb5363b) changed version tag (@REJack)

### v2.5.11 (2016/9/15)
 - [d557569](https://github.com/emreakay/CodeIgniter-Aauth/commit/d5575693648225a2448006f566cfe9f48084408a) changed version tag (@REJack)
 - [c6fc965](https://github.com/emreakay/CodeIgniter-Aauth/commit/c6fc9650ff7293cf176567dc4031f6c6ca085aba) `__contruct` cleanup (@REJack)
    - moved any helper loader & email library loader to the function they use the helper/library.
 - [1a85504](https://github.com/emreakay/CodeIgniter-Aauth/commit/1a855044a17ca6da3385a1a510366e7e0618f9ff) Merge pull request #175 from perenstrom/master (@REJack)
    - Swedish translation
 - [bd54730](https://github.com/emreakay/CodeIgniter-Aauth/commit/bd5473013788c77c0fc6412045dba927f00eb614) Create aauth_lang.php (@perenstrom)
    - Translated to swedish.
 - [562e247](https://github.com/emreakay/CodeIgniter-Aauth/commit/562e24711bf0851a3077dce20af316ef599a3954) Merge pull request #169 from siarlex/master (@REJack)
    - Correction of phrase
 - [d8b840f](https://github.com/emreakay/CodeIgniter-Aauth/commit/d8b840f480f1aef40ed5fd5c31765d5b1a68330f) Merge pull request #167 from mirivlad/master (@REJack)
    - Add russian translate
 - [ea5fb86](https://github.com/emreakay/CodeIgniter-Aauth/commit/ea5fb86d41e3869671c214abd2f8cb36a2578c8b) Merge pull request #172 from pars0097/master (@emreakay)
    - add persian language
 - [89cdcdd](https://github.com/emreakay/CodeIgniter-Aauth/commit/89cdcdd60f86c16d8d263f221e12483917d2e44f) Create aauth_lang.php (@pars0097)
    - add persian :)
 - [51c5bca](https://github.com/emreakay/CodeIgniter-Aauth/commit/51c5bca9af211f95cb14fef758c8d933301208d2) Delete aauth_lang.php (@pars0097)
 - [280bebd](https://github.com/emreakay/CodeIgniter-Aauth/commit/280bebd1181eea58c32af0f1de3b5b217d11ed9e) Create aauth_lang.php (@pars0097)
    - add persian :)
 - [ef045fc](https://github.com/emreakay/CodeIgniter-Aauth/commit/ef045fcae17d4d51b33e57651a70aebd112721fa) Correction of phrase (@siarlex)
 - [bc05227](https://github.com/emreakay/CodeIgniter-Aauth/commit/bc05227b3a5f717d6350bc63a76c8d2ea0f74353) Correct some error (@mirivlad)
 - [a9b9498](https://github.com/emreakay/CodeIgniter-Aauth/commit/a9b94983d29bc8b1b8a817c6379093724dc12d1d) Add russian translate (@mirivlad)

### v2.5.10 (2016/7/26)
 - [05e4728](https://github.com/emreakay/CodeIgniter-Aauth/commit/05e47288c7b5f71b7d23f91fc1b6c028c6d51e2e) updated version tag (@REJack)
 - [a0391c8](https://github.com/emreakay/CodeIgniter-Aauth/commit/a0391c871eb398d68df8656916e7b4c095607dd9) Merge pull request #165 from paulcanning/2.5-stable (@REJack)
 - [e404e0a](https://github.com/emreakay/CodeIgniter-Aauth/commit/e404e0a5c7b0caf3440c0183ca2f0a151cd565f7) Fix for list_pms (@paulcanning)
 - [54cfd3b](https://github.com/emreakay/CodeIgniter-Aauth/commit/54cfd3b2b13839ff896a3891ec8f5761a1354ab6) Fixed PM default type for delete flag (@paulcanning)

### v2.5.9 (2016/07/22)
 - [5cbff6c](https://github.com/emreakay/CodeIgniter-Aauth/commit/5cbff6c4c04897048a6083ae155262ca3dc50061) Merge pull request #163 from paulcanning/2.5-stable (@REJack)
 - [b409fef](https://github.com/emreakay/CodeIgniter-Aauth/commit/b409fef20c7b90b4698324f260c2dcbd1ec799d1) Fixed count_unread_pms not checking for deleted status. (@paulcanning)

### v2.5.8 (2016/07/16)
 - [afa1647](https://github.com/emreakay/CodeIgniter-Aauth/commit/afa16478caea58387d78030cf92a17c1ad853f48) fixed email_config error (@REJack)
 - [e502904](https://github.com/emreakay/CodeIgniter-Aauth/commit/e5029041ed83223428875633475c60324b621928) fixed sql error on `create_user()` with `use_password_hash`-config_var on __true__ (@REJack)
 - [bd91700](https://github.com/emreakay/CodeIgniter-Aauth/commit/bd91700380d27be84963d620acd3bc3733639b22) updated `config/aauth.php` (@REJack)

### v2.5.7 (2016/06/17)
 - [34d8a89](https://github.com/emreakay/CodeIgniter-Aauth/commit/34d8a896b86e784d7ee1228eb5a74cc908c6d369) v2.5.7 (@REJack)
    - fixed login remember
    - removed `use_cookies`-config_var (unused since reCAPTCHA doesnt use cookie/session)
    - changed `logout()`
    - changed `is_loggedin()` removed wrong session checks

### v2.5.6 (2016/06/14)
 - [fe117dd](https://github.com/emreakay/CodeIgniter-Aauth/commit/fe117dd30f551b8cafd13f2bb0bf2ff9bce99b51) added abilty to set a config for CI's Email Library (@REJack)
 
### v2.5.5 (2016/06/07)
 - [a1bf4fb](https://github.com/emreakay/CodeIgniter-Aauth/commit/a1bf4fb66ff195dbb72d38428a0a7916b8bfc5c0) fixed `reCAPTCHA`-validation (moved after `DDoS` check) (@REJack)
 - [91ededf](https://github.com/emreakay/CodeIgniter-Aauth/commit/91ededf5cd9bc47292bf2777170e507af969f0f5) changed version to 2.5.5 (@REJack)
 - [5701a7a](https://github.com/emreakay/CodeIgniter-Aauth/commit/5701a7a6fc89a0133f6fff9eafe46b19c41f2c03) some little fixes with ddos_protection & reCAPTCHA (@REJack)
    - fixed timestamp where in `reset_login_attempts()`, `get_login_attempts()` & `update_login_attempts()`
    - fixed `login()` removed cookie/session-userdata for reCAPTCHA (if reCAPTCHA needed)
    - fixed `login()` moved `update_login_attempts()` before test email/name & password
    - fixed `generate_recaptcha_field()` removed cookie/session check

### v2.5.4 (2016/06/02)
 - [66622f6](https://github.com/emreakay/CodeIgniter-Aauth/commit/66622f640f2b454c04257b946b1062293993ed3b) DDoS Protections fixes in `login()` (@REJack)
    - removed user get query from DDoS check in
    - fixed DDoS protection to update login_attempts if user not exist too
    - removed user get query from DDoS/reCAPTCHA check
    - fixed DDoS/reCAPTCHA proection to update login_attempts if user not exist too
    - added `get_login_attempts()` returns login_attempts as INT (used in `login()`)

### v2.5.3 (2016/06/02)
 - [116b2c0](https://github.com/emreakay/CodeIgniter-Aauth/commit/116b2c0f09fb49c6a99e76a7e831a85ef5923a20) changed version to 2.5.3 (@REJack) 
 - [a731c28](https://github.com/emreakay/CodeIgniter-Aauth/commit/a731c28772c5a5a4fb870788d1b6ddbd3a875bf0) fixed reCAPTCHA DDoS check (@REJack) 

### v2.5.2 (2016/06/02)
 - [35e3a41](https://github.com/emreakay/CodeIgniter-Aauth/commit/35e3a41f29e3035998451436ca1a1b4b9e304a44) changed version to 2.5.2 (@REJack) 
 - [330028b](https://github.com/emreakay/CodeIgniter-Aauth/commit/330028b5f75aaea4722d8d0390ecbad3bad84698) fixed error with `user_exist_by_name()` (@REJack) 

### v2.5.1 (2016/06/01)
 - [89e715e](https://github.com/emreakay/CodeIgniter-Aauth/commit/89e715e48e58edee3e5da63bac8b968ec9a0f0e8) changed version tag (@REJack) 
 - [2e08204](https://github.com/emreakay/CodeIgniter-Aauth/commit/2e08204bce4944e56da9b365f6d297de6d75cab0) fixed `get_pm()` & `delete_pm()` (@REJack) 
 - [26ea41d](https://github.com/emreakay/CodeIgniter-Aauth/commit/26ea41de30e235f13481d849729bcc526008f667) Merge pull request #148 from paulcanning/master (@REJack) 
 - [b422027](https://github.com/emreakay/CodeIgniter-Aauth/commit/b42202780dec0ea3ae3eeb1b0a61b629512996c4) (@paulcanning) 
    - Fixed PM's not being decrypted with `list_pms()` #145
    - Fixed `get_pm()` method to fetch correct PM #145

### v2.5.0 (2016/06/01)
 - [1eee170](https://github.com/emreakay/CodeIgniter-Aauth/commit/1eee170358fdb87c1abeda52041d5c9634f1350c) (@REJack)
    - release prefix changed in library
    - changed copyright in library
    - fixed usernames in Quick Start-Section
    
### v2.5.0-alpha.6 (2016/06/01)
 - [7e92c31](https://github.com/emreakay/CodeIgniter-Aauth/commit/7e92c31751810f6ef6581b1d53aa965d3755f6e9) v2.5.0-alpha.5 fixes (@REJack)
    - fixed both SQL files
    - fixed `list_pms()`
    - fixed `delete_pm()`
    - added abilty to send `system` PM's for `send_pm()` & `send_pms()`
    - changed `name` to `username` in aauth_users table
    - changed `name` to `username` in all user related functions
    - changed `$name` to `$username` in `create_user()` & `update_user()`
    - added `user_exist_by_username()`
    - changed `user_exist_by_name()` to an alias of `user_exist_by_username()`

### v2.5.0-alpha.5 (2016/05/30)
- [847a639](https://github.com/emreakay/CodeIgniter-Aauth/commit/847a639d893cff4ae821615ddb48061cedb64def) (@REJack)
    - reverted changed `count_unread_pms()` it counts now only not deleted pm's
    - changed `delete_pm()` if a receiver deletes a pm it updates date_read
- [84b61fd](https://github.com/emreakay/CodeIgniter-Aauth/commit/84b61fd97cef0e7de9560e1675f851f2572c5942) changed some explanation infos in aauth's config (@REJack)
- [fe89cdb](https://github.com/emreakay/CodeIgniter-Aauth/commit/fe89cdb861d6864dc200db4089561669a3fd4353) (@REJack)
    - fixed explanation info text in aauth config
    - added `pm_cleanup_max_age`-config_var
    - added 2 fields (`pm_deleted_sender` & `pm_deleted_receiver`) in pm table
    - changed `list_pms()` to catch only not deleted pm's
    - changed `delete_pm()` now it need a user_id to delete a pm (like `get_pm()`)
    - changed `delete_pm()` sender's can now detete pm's from outbox
    - changed `count_unread_pms()` it counts now only not deleted pm's.
    - added `cleanup_pms()` removes pms older than X defined by `pm_cleanup_max_age`-config_var
- [e6e770a](https://github.com/emreakay/CodeIgniter-Aauth/commit/e6e770a95d5c0f10e26226aaae6b8e308e60eeab) (@REJack)
    - changed `send_pm()` to `send_pms()` 
    - added `send_pm()`
- [1f1afbd](https://github.com/emreakay/CodeIgniter-Aauth/commit/1f1afbde0abf79594b4eb0351e645ca8cd6f42cd) enhanced `send_pm()` (@REJack)
    - changed `$receiver_id` to `$receiver_ids`
    - sends multiple pms
    - returns array of receiver user ids with specific error message on failure or TRUE if message successfully sent
- [10e8446](https://github.com/emreakay/CodeIgniter-Aauth/commit/10e844653eb28dfcefa0c6aa6aa9909fd1625b6d) (@REJack)
    - added `date_created` field to `aauth_users`-table in both SQL files
    - changed `create_user()` to fill `date_created` on user creation
- [30239ed](https://github.com/emreakay/CodeIgniter-Aauth/commit/30239ed3a0945db05c10ce43e2ab9d2ef7641741) (@REJack)
    - added `pm_encryption` config_var
    - added abilty to encrypt PM's in `send_pm()` & `get_pm()`
    - added function `user_exist_by_id` used in `send_pm()`
    - added a `user_id` check in `get_pm()`
- [483ed60](https://github.com/emreakay/CodeIgniter-Aauth/commit/483ed60540019d95c9bb2f24b447c8b79f26919e) enhanced `get_pm()` (@REJack)
    - added `$user_id` argument between `$pm_id ` & `$set_as_true`
    - changed `set_as_true` to set read date only if user_id is equal to receiver's id

### v2.5.0-alpha.4 (2016/05/28)
- [46308eb](https://github.com/emreakay/CodeIgniter-Aauth/commit/46308eb79411183412d31f7807d854c5e4af07a6) fixed missing comma in sql files (@REJack)
    - SQL files Tested with MySQL v5.7.11

### v2.5.0-alpha.3 (2016/05/25)
- [1c67131](https://github.com/emreakay/CodeIgniter-Aauth/commit/1c67131ee86eeb645eb80e9986e891f266a16566) Create aauth_lang.php (@tobiasfichtner)
    - added german translation

### v2.5.0-alpha.2 (2016/05/25)
- [852d4f9](https://github.com/emreakay/CodeIgniter-Aauth/commit/852d4f9f340d25fee095b024e6e1dcfa05b4aa3b) Create aauth_lang.php (@terrylinooo)
    - added Traditional Chinese translation, used by Taiwan, Hong Kong
- [52412ff](https://github.com/emreakay/CodeIgniter-Aauth/commit/52412ff9fef3d384b49ea3c5415ad2ffed420e12) Create aauth_lang.php (@terrylinooo)
    - added Simplified Chinese translation, used by China, Singapore and Malaysia

### v2.5.0-alpha (2016/05/24)
- [36da952](https://github.com/emreakay/CodeIgniter-Aauth/commit/36da952709e023cd203150121abaffbe5bee4a00) fixed SQL files (now its compatible with `MySQL >= 5.7.3`) (@REJack)
- [34f66af](https://github.com/emreakay/CodeIgniter-Aauth/commit/34f66afe5ec26e5d2f081e2d3ecde5a7de2fdecc) #137 Non-user based DDoS check (@REJack)
    - added a new table for login_attempts (in both SQL files)
    - added 2 config vars `login_attempts`(db) & `remove_successful_attempts`
    - changed function `reset_login_attempts()` (removed user_id and changed where to ip_address and timestamp from user_id only)
    - changed function `update_login_attempts()` (removed user_id and changed where to ip_address and timestamp from email/user_id only)
    - changed function `login()` (removed arguments from changed functions, added abilty to enable/disable removing login attempt after successful login)
- [61f9907](https://github.com/emreakay/CodeIgniter-Aauth/commit/61f9907498a0346a6d9d750786b76e9a97ca6e61) (@REJack)
    - removed `aauth_system_variables` from SQL files
    - removed config var `system_variables`
- [51d03fa](https://github.com/emreakay/CodeIgniter-Aauth/commit/51d03fa2c5817265573ccf1597766fa4d0213b3d) added config var info for `totp_two_step_login_redirect` (@REJack)
- [37a731d](https://github.com/emreakay/CodeIgniter-Aauth/commit/37a731dbdbb9d5f227ccec32634b259d06e0f051) totp enhancements (@REJack)
    - added 2 config vars (`totp_two_step_login_active`, `totp_two_step_login_redirect`)
    - changed `login()` to set session data if totp is required and two_step_login is active and skip default
    - fixed `control()` to check if totp verification is required, if required then it redirects to `totp_two_step_login_redirect`
    - fixed `control()` to check if is_loggedin not with totp verification is required
    - changed `is_allowed()` to check if totp verification is required, if required then it redirects to `totp_two_step_login_redirect`
    - added 2 functions `verify_user_totp_code($totp_code, $user_id = FALSE)` & `is_totp_required()`
- [bf04633](https://github.com/emreakay/CodeIgniter-Aauth/commit/bf0463310ebafdf4365b922a1df5739b31d79d7d) some little fixes (@REJack)
    - `is_loggedin()` 2 empty lines removed
    - `control()` it hasn't checked if no perm_par was given
- [bfdc6ea](https://github.com/emreakay/CodeIgniter-Aauth/commit/bfdc6ea1deab807653fa8254b35dd0049b16a1ed) removed System Variables (@REJack)
    - if anyone use the System Variables and want update to v2.5.0 a Compatibility Library is available under https://github.com/REJack/CodeIgniter-Aauth-Compat
- [569fc87](https://github.com/emreakay/CodeIgniter-Aauth/commit/569fc870a65bc572ac88b46e3e20de1a10f2ba9a) fixed config var `password_hash_algo` string to constant and added info link (@REJack)
- [906ccf0](https://github.com/emreakay/CodeIgniter-Aauth/commit/906ccf02e41e155653209aa2bff6ca9ac236056e) changed config var name from `max_login_attempt_per_minutes` to `max_login_attempt_time_period` (@REJack)
- [fd6e3f3](https://github.com/emreakay/CodeIgniter-Aauth/commit/fd6e3f34954e641fc444b865f5ec862dbc02b83f) removed config var `update_last_login_attempt` (@REJack)
- [f33affc](https://github.com/emreakay/CodeIgniter-Aauth/commit/f33affcb586b9028971ab39ad204ae6f48994f5f) changed `get_user_groups()` (public groups now visible if checked on guests) (@REJack)
- [bd33c95](https://github.com/emreakay/CodeIgniter-Aauth/commit/bd33c956a2286c15aad8bfce2b19b7e1587f6210) BCrypt/PHP's password_hash support (@REJack)
- [e4aa1f5](https://github.com/emreakay/CodeIgniter-Aauth/commit/e4aa1f5bc71a3de5db73309ec31b8bc7a8e287f8) tests `update_login_attempts` done (@REJack)
- [4c3aec4](https://github.com/emreakay/CodeIgniter-Aauth/commit/4c3aec4b7c86fbd08b430a1efd7f6e8989f4272a) fixed `strtotime()` parameter (@REJack)
- [e205dc2](https://github.com/emreakay/CodeIgniter-Aauth/commit/e205dc28b844dbdeab7959f2e3b41b98d789dafe) removed user_id for reset_/remind_password function (#124) (@REJack)
- [30a576d](https://github.com/emreakay/CodeIgniter-Aauth/commit/30a576df06bb54be56a70b6fbb0ff6678f37bdf0) fixed fatal flaw on `update_login_attempts` (#133) (@REJack)
- [952f3eb](https://github.com/emreakay/CodeIgniter-Aauth/commit/952f3ebe46cbe5a5297e2668c4d8153048d4845f) changed version to 2.5.0-alpha (@REJack)

### v2.4.7 (2016/05/13)
- [0ae258d](https://github.com/emreakay/CodeIgniter-Aauth/commit/0ae258d8892b428f930d49cf935192dc2d141666) added function `get_user_vars($user_id)` (@REJack)
- [3887dd4](https://github.com/emreakay/CodeIgniter-Aauth/commit/3887dd46ad1c01f25e63de0c27765dd7c106d69f) renamed `valid_chars` to `additional_valid_chars` #125 (@REJack)
- [58b08f9](https://github.com/emreakay/CodeIgniter-Aauth/commit/58b08f9e267a5ac4a56ca3647b1f5c160a19a561) fixed `Quick Start`-Section (changed `deny` to `deny_group`) (@REJack)
- [0ba3a8e](https://github.com/emreakay/CodeIgniter-Aauth/commit/0ba3a8ea5e95c616a1821ae50370160bbc90f04e) verification email sending disabled if a admin is creating a user (@REJack)
- [4675b2f](https://github.com/emreakay/CodeIgniter-Aauth/commit/4675b2fc5f502f74adf73301ad8df62b8914df33) Sub-Groups added (@REJack)
- [6a34d51](https://github.com/emreakay/CodeIgniter-Aauth/commit/6a34d5149e367c667e42c9d09f6a4b7cae90c02b) add waffle.io badge (@waffle-iron)
- [ca2cefd](https://github.com/emreakay/CodeIgniter-Aauth/commit/ca2cefd2b7ccb936b76c19718456eb7a7b7094b6) added a check if user has email or name already (@REJack)
- [33c1bf7](https://github.com/emreakay/CodeIgniter-Aauth/commit/33c1bf75283161318156cc7005c34d505171b42f) removed some spaces (@REJack)
- [586e931](https://github.com/emreakay/CodeIgniter-Aauth/commit/586e9316a6f7a9378c7eac3eda1ef3309613ecd1) PHP7 fix #107 (@REJack)
- [c651d45](https://github.com/emreakay/CodeIgniter-Aauth/commit/c651d4597745985369400db35e164f9ae2304ad9) add indonesian  language file translation (@suhindra)
- [a775982](https://github.com/emreakay/CodeIgniter-Aauth/commit/a775982cb8369230ac5039f26d8e0cc91f55ed06) Update Aauth.php (@AnasTHH)
- [eedb053](https://github.com/emreakay/CodeIgniter-Aauth/commit/eedb053d2d83180891ca6c923f6e345cbd035a80) Updated optional name param to use false instead of string
- [b09f96f](https://github.com/emreakay/CodeIgniter-Aauth/commit/b09f96f24446db857e62485e7d002e64b41646ba) Fixed error on optional param of name when creating user
- [8d9d5b2](https://github.com/emreakay/CodeIgniter-Aauth/commit/8d9d5b28e43eb2650e5163d634844d49d41821e4) center smaller logo (@ManeBit)
- [b690aef](https://github.com/emreakay/CodeIgniter-Aauth/commit/b690aefa313e136abc8af5f9c065d9c176378648) smaller logo (@ManeBit)

### v2.4.6 (2015/12/02)
- [8161fff](https://github.com/emreakay/CodeIgniter-Aauth/commit/8161fff5d24007f4edc6753653da0cb8c473c8a5) Update Aauth.php (@emreakay)
- [09c1ffa](https://github.com/emreakay/CodeIgniter-Aauth/commit/09c1ffa481924b5306e10dad49db5d79ae0f590a) Update Aauth.php (@AnasTHH)
- [e1dee38](https://github.com/emreakay/CodeIgniter-Aauth/commit/e1dee38adce782dd44f4750ddd3ae34eaed5e688) Added a function to remove member from all groups (@AnasTHH)
- [b254c9d](https://github.com/emreakay/CodeIgniter-Aauth/commit/b254c9d7159a3f5e9610c30684958260d278aa68) Update array clearing for php compatibilities (@scombat)
- [a858c1a](https://github.com/emreakay/CodeIgniter-Aauth/commit/a858c1abf459b165dfc1ccb61c554c26ab9125cc) changed 'TOTP Code' to 'Authentication Code' in english lang file (@REJack)
- [c7e05f0](https://github.com/emreakay/CodeIgniter-Aauth/commit/c7e05f0265347068d176f6eb09143220e227455e) sry thats was my failure (@REJack)
- [50ddf8b](https://github.com/emreakay/CodeIgniter-Aauth/commit/50ddf8b99c56663bb844a5f66b5aac86e0d38c09) fix for allow_user and allow_group problem #90 (@REJack)
- [572e49f](https://github.com/emreakay/CodeIgniter-Aauth/commit/572e49f494bf885a8360b94134b30366f7e5fa95) Removed print_r in recapcha helper

### v2.4.5 (2015/10/28)
- [ecb3ae3](https://github.com/emreakay/CodeIgniter-Aauth/commit/ecb3ae3a779c48a70edd845893c9da695918333b) Update Aauth.php (@emreakay)
- [825f535](https://github.com/emreakay/CodeIgniter-Aauth/commit/825f53576f051add512a05ec404bdb6f5f18fba6) reform old gitignore (@scombat)
- [c276164](https://github.com/emreakay/CodeIgniter-Aauth/commit/c276164c5b6a5303632716d25130be0e3c912278) Add explaination an recommendations (@scombat)
- [c84fde5](https://github.com/emreakay/CodeIgniter-Aauth/commit/c84fde559118caa520db9528c6eb0f902f10fd6d) Add hash in configuration (@scombat)
- [6dd3839](https://github.com/emreakay/CodeIgniter-Aauth/commit/6dd383938555675095f92e14636fc1e3b18d84bd) add gitignore for development comodity (@scombat)

### v2.4.4 (2015/10/27)
- [6f70228](https://github.com/emreakay/CodeIgniter-Aauth/commit/6f70228f7117411c785046b0a13f0c4c0316a3a9) Update Aauth.php (@emreakay)
- [f42e546](https://github.com/emreakay/CodeIgniter-Aauth/commit/f42e5468ffc5037ac10c20256509e690064d6c83) moved $perm_id after the if's conditions for more performance (@REJack)
- [f51e1b4](https://github.com/emreakay/CodeIgniter-Aauth/commit/f51e1b4ff2dd761f631f322fe80c7682c36d8b89) Enchantment on is_allowed() function #83 (@REJack)
- [c999d7c](https://github.com/emreakay/CodeIgniter-Aauth/commit/c999d7c8da0a612af41d44a6d73c487d2b220d07) Update README.md (@emreakay)

### v2.4.3 (2015/10/27)
- [0f31aa7](https://github.com/emreakay/CodeIgniter-Aauth/commit/0f31aa7ea7095b56964e90ab03c08b14cf5105d2) Update Aauth.php (@emreakay)
- [1c5e9aa](https://github.com/emreakay/CodeIgniter-Aauth/commit/1c5e9aad63a1ce5fe93afb92eb28452a4e162b9e) fix for #81 Invalid new config file (@REJack)

### v2.4.2 (2015/10/26)
- [80977fe](https://github.com/emreakay/CodeIgniter-Aauth/commit/80977fe87742a32da238baa6410499cc5de80a31) Update Aauth.php (@emreakay)
- [581981f](https://github.com/emreakay/CodeIgniter-Aauth/commit/581981f02cca4aab6b39bc7bf6e6bad89cb75ee8) fix for #79 (@REJack)
- [b9174a1](https://github.com/emreakay/CodeIgniter-Aauth/commit/b9174a1cdecf323a8871792a58de133f3088ae6e) Double declaration and assignation of valid flag (@scombat)
- [36bce1e](https://github.com/emreakay/CodeIgniter-Aauth/commit/36bce1e8401f3021d47f14bf75496770d97bbc2d) Update config file for readability and comprehension (@scombat)
- [51d9ea8](https://github.com/emreakay/CodeIgniter-Aauth/commit/51d9ea89f89a6ee87eb92da17cf6f43c6876bf15) Add first version of french language file (@scombat)
- [9ead755](https://github.com/emreakay/CodeIgniter-Aauth/commit/9ead7557c9ff7892e97bd26aa2940370e7038d83) Another approach for aauth_error_login_failed (@vipinks)
- [3db113a](https://github.com/emreakay/CodeIgniter-Aauth/commit/3db113a30af247e1e807766dac75fbf0e5243e8e) "aauth_error_login_failed" is not specified (@vipinks)
- [cfc0295](https://github.com/emreakay/CodeIgniter-Aauth/commit/cfc0295f71ea9bab07fc0ec96b2267c2592da326) Update Aauth.php (@emreakay)

### v2.4.1 (2015/10/12)
- [da36535](https://github.com/emreakay/CodeIgniter-Aauth/commit/da36535250fbd0df57a1ecc179bf851bc3bbdeb4) Fix depreciated valid email
- [dce098f](https://github.com/emreakay/CodeIgniter-Aauth/commit/dce098ffcba01c743c2763c376942e6fbbbb68ea) Fix for depreciated valid_email function
- [205380b](https://github.com/emreakay/CodeIgniter-Aauth/commit/205380b22e8496b43787ba51256615673fd412c4) Set definition as not mandatory parameter for create_group

### v2.4.0 (2015/10/07)
- [a683c62](https://github.com/emreakay/CodeIgniter-Aauth/commit/a683c62c4e84e6d6e6eb614ee2f6ab6fe60b537a) Update Aauth.php (@emreakay)
- [bc1c12a](https://github.com/emreakay/CodeIgniter-Aauth/commit/bc1c12aa52d950492899b8b0d72c2c213dc2209b) Update Aauth.php (@emreakay)
- [bc90f5a](https://github.com/emreakay/CodeIgniter-Aauth/commit/bc90f5a0bb45e6d48e529042b60eaef5addf62a8) Updated aauth.php (@REJack)
- [a19e5d8](https://github.com/emreakay/CodeIgniter-Aauth/commit/a19e5d81f854177779e3bd4474e2005f2f4c280e) version 2.3.4 (@emreakay)

### v2.3.4 (2015/10/07)
- [d724b54](https://github.com/emreakay/CodeIgniter-Aauth/commit/d724b54fefe1ac362d5a0298862a4623e0a522c7) Spanish Language Added
- [e6aa1f6](https://github.com/emreakay/CodeIgniter-Aauth/commit/e6aa1f6a057fedf441e665fb4251929327f0c4cc) changed __key__ to __data_key__ in ``user_variables`` & ``system_variables`` (fix for #68) (@REJack)
- [9aca808](https://github.com/emreakay/CodeIgniter-Aauth/commit/9aca808dd70885e0d6c293189f015774cf031cf6) possible fix for  #66 (@REJack)

### v2.3.3 (2015/09/28)
- [f7d44fc](https://github.com/emreakay/CodeIgniter-Aauth/commit/f7d44fc0f645668fcf9f555f795f047b8886a8ba) @version update (@emreakay)
- [4be2591](https://github.com/emreakay/CodeIgniter-Aauth/commit/4be259129d55e6bfe7a361a0b190a0188aba2326) Added wrong password message
- [eacf9b1](https://github.com/emreakay/CodeIgniter-Aauth/commit/eacf9b153900dbfabe74c16c343cd27756b7c551) Fix wrong password message
- [29330e2](https://github.com/emreakay/CodeIgniter-Aauth/commit/29330e248f493b4d505cfcfbc21acb49b5b8e648) 3.x update (@emreakay)
- [65c565b](https://github.com/emreakay/CodeIgniter-Aauth/commit/65c565b7a7e0a0915d185c56e5b365d4f26b7137) 3x (@emreakay)

### v2.3.1 (2015/09/21)
- [26a187b](https://github.com/emreakay/CodeIgniter-Aauth/commit/26a187bd063aa5a7a2a59c3bffc380b9d36191ac) Fix sql error
- [54f8563](https://github.com/emreakay/CodeIgniter-Aauth/commit/54f8563dcef0686fc4696a7b33fc77d38a8783a0) Fix issue with messages (@cekdahl)
- [56202a2](https://github.com/emreakay/CodeIgniter-Aauth/commit/56202a2e7d30dbf54374e3f8e47e74b905344855) there was a mistake for #58 fix (@REJack)
- [39c893f](https://github.com/emreakay/CodeIgniter-Aauth/commit/39c893fcc436230dd10552ab5d711a5b42959562) fix for #58 sry for my mistake (@REJack)
- [4b530ed](https://github.com/emreakay/CodeIgniter-Aauth/commit/4b530eda60f82c1f2a528635ce0dd593637b8e65) SQL error fixed (@REJack)
- [a11bdbe](https://github.com/emreakay/CodeIgniter-Aauth/commit/a11bdbe5800b9d85d4bb01df08acc675e540cb26) Reserved keyword conflict in MySQL. (@REJack)
- [136ba68](https://github.com/emreakay/CodeIgniter-Aauth/commit/136ba686bdd6b71d72c3ad1a7002f91d85d74dbe) fix for #51 'is_allowed() bug ' (@REJack)

### v2.3.0 (2015/07/28)
- [87369a9](https://github.com/emreakay/CodeIgniter-Aauth/commit/87369a93419407a1beb98982daaea2cb5ede7114) Revert "reverted the revert :smile:" (@REJack)
- [b449749](https://github.com/emreakay/CodeIgniter-Aauth/commit/b449749451e392c996c7d0783745c6227390673f) reverted the revert :smile: (@REJack)
- [595fe0b](https://github.com/emreakay/CodeIgniter-Aauth/commit/595fe0b5bb18ca074b25ab9308cfeb5e96c284c7) revert max pw lenght (@REJack)
- [6474cdf](https://github.com/emreakay/CodeIgniter-Aauth/commit/6474cdf2e4bd82ef57ead03cb5d17361d5a8d1fe) test to resolve conflicts :smile: (@REJack)
- [12a76b1](https://github.com/emreakay/CodeIgniter-Aauth/commit/12a76b1659984fb72b78113081dee1519fc5cfb5) changed result to row by get_pm (@REJack)
- [f0cf74e](https://github.com/emreakay/CodeIgniter-Aauth/commit/f0cf74ec517b24428f93a7b7029b94af17730bc0) added return by delete_user() (@REJack)
- [bcbf28b](https://github.com/emreakay/CodeIgniter-Aauth/commit/bcbf28b432c0a07feef72d0116cd5fbfeb27ab7d) changed NULL to FALSE by get_perm_id() (@REJack)
- [461278b](https://github.com/emreakay/CodeIgniter-Aauth/commit/461278b157e55426ec355bfffd4c8f261aa635b2) fixed login error after TOTP check (login with wrong pw fixed) (@REJack)
- [3413b3b](https://github.com/emreakay/CodeIgniter-Aauth/commit/3413b3bf0ae45336aa3af01607942a11eb230887) added configuration to not use cookies if sessions are enabled. (@REJack)
- [9afda70](https://github.com/emreakay/CodeIgniter-Aauth/commit/9afda70a7d61692edbece00340735a027d57dd58) Updated README.md (@REJack)
- [12d01e6](https://github.com/emreakay/CodeIgniter-Aauth/commit/12d01e609f5a9c93ce6ed5ce605752aa8da3f064) Fixing typos in functions (@ManeBit)
- [ab64f61](https://github.com/emreakay/CodeIgniter-Aauth/commit/ab64f6118f66115e58632e583ff2736004c486c2) URGENT: variable scope undefined fix! (@ManeBit)
- [35a9232](https://github.com/emreakay/CodeIgniter-Aauth/commit/35a9232e3ec17234e9fb9806375bb29fe21fea62) added a fix for #46 (@REJack)
- [1096ff9](https://github.com/emreakay/CodeIgniter-Aauth/commit/1096ff924641d754106b616c75afa5ce59e7dc06) function remind_password: return TRUE/FALSE. (@ManeBit)
- [43f0d83](https://github.com/emreakay/CodeIgniter-Aauth/commit/43f0d83fac23e19ececed9e7ba76da9f4c9d50b7) added 'min' password length like 'max' (@REJack)
- [bbc992d](https://github.com/emreakay/CodeIgniter-Aauth/commit/bbc992d2f7386e02ba06a472d832f8cd1a32b2ef) Revert "added min password length" (@REJack)
- [341bab5](https://github.com/emreakay/CodeIgniter-Aauth/commit/341bab55a73e45b9c2f6ea3bfae12a452bd1bdfc) added min password length (@REJack)
- [515945b](https://github.com/emreakay/CodeIgniter-Aauth/commit/515945b11a075b96004cd4205972b4579042d606) fixed issue #42 (@REJack)
- [239ef68](https://github.com/emreakay/CodeIgniter-Aauth/commit/239ef68c802b45b6f4ce8f073ebe94ac379659a9) changed some default config vars (@REJack)
- [3198846](https://github.com/emreakay/CodeIgniter-Aauth/commit/319884689a3908ecbc16a0bedd2531c0de41fbf8) added specific error messages for update_user without forgotten password text (@REJack)
- [7617a79](https://github.com/emreakay/CodeIgniter-Aauth/commit/7617a79cda73dbaf3fe662505df20039c04d7fee) found a missing aauth_db (@REJack)
- [59bbfdd](https://github.com/emreakay/CodeIgniter-Aauth/commit/59bbfdd94aaadb9d369834711197c296b7d90b5c) added checks from create_user in update_user (@REJack)
- [11bd0dc](https://github.com/emreakay/CodeIgniter-Aauth/commit/11bd0dcd49860fef791317af71486935527978e0) moved user_exsist_by_name out of the IF (@REJack)
- [f4c42a3](https://github.com/emreakay/CodeIgniter-Aauth/commit/f4c42a31208c8b4c093de3eb66cfbef87251b57f) added totp_only_on_ip_change (@REJack)
- [d2cf407](https://github.com/emreakay/CodeIgniter-Aauth/commit/d2cf407cb38c5ee4c7898fddad4fc5e58fdf1354) changed totp_active default value to false (@REJack)
- [f0f1bb0](https://github.com/emreakay/CodeIgniter-Aauth/commit/f0f1bb08e8958e2f154f8b22ae79c41469a6128d) fixed a failure (@REJack)
- [86845c2](https://github.com/emreakay/CodeIgniter-Aauth/commit/86845c22b0e14b72c15cbfe279e59cfa380dde3a) fixed a error on login without totp_code (@REJack)
- [1128820](https://github.com/emreakay/CodeIgniter-Aauth/commit/11288205faddb39b339e550fff55ade55609a317) added totp_reset_over_reset_password and update_user_totp_secret() (@REJack)
- [98f0a74](https://github.com/emreakay/CodeIgniter-Aauth/commit/98f0a74457b31f5cc117ee4a388c51da7f99c232) added Time-Based One-Time Password (@REJack)
- [f0f781d](https://github.com/emreakay/CodeIgniter-Aauth/commit/f0f781dfca8c8848068cd186616069d4b2efe367) added config var for reset_password_link and verification_link, so its not needed to edit the language file (@REJack)
- [7c749af](https://github.com/emreakay/CodeIgniter-Aauth/commit/7c749af13f18d82ef2ac79e5901528878912f4ee) removed a unused config_var (@REJack)
- [1271388](https://github.com/emreakay/CodeIgniter-Aauth/commit/1271388c3fa05ead98ca1418cae8aedf4f05110b) fixed set_system_var bug (issue #39) (@REJack)
- [1e6007a](https://github.com/emreakay/CodeIgniter-Aauth/commit/1e6007a7c6eeeef5edea4d860b90e1d9c0c6683c) Adjusted password field to 64 chars (@tswagger)
- [08affa2](https://github.com/emreakay/CodeIgniter-Aauth/commit/08affa2abcc5658ac97db35bef522bddf676dc61) changed list_user_var_keys's output from array to object (@REJack)
- [7b180a0](https://github.com/emreakay/CodeIgniter-Aauth/commit/7b180a01a1f8844d46828ac00640b015d8b7c970) build update_group similar to update_user (@REJack)
- [106a3d5](https://github.com/emreakay/CodeIgniter-Aauth/commit/106a3d55d10f79358d77287dc6a03c3fb4fdbe5e) added missing $definition to update_group (@REJack)
- [41224e6](https://github.com/emreakay/CodeIgniter-Aauth/commit/41224e613a74d6d99656fc57b147cc2398a2629e) added to create_group and update_group 'definition' based on tswagger's sql changes (@REJack)
- [206342b](https://github.com/emreakay/CodeIgniter-Aauth/commit/206342b49e09c042f9055185e296275cd443d5b9) moved user_exsist_by_email out of else to prevent double emails in database (@REJack)
- [790dd44](https://github.com/emreakay/CodeIgniter-Aauth/commit/790dd44a10cd3137ed19d76fbecc8897b711f7b3) Configurable Login over Name or Email (@REJack)
- [fc24226](https://github.com/emreakay/CodeIgniter-Aauth/commit/fc242264a4efd5bd32a528502182972fbd52b038) changed the copyright info to this year (@REJack)
- [5df18c0](https://github.com/emreakay/CodeIgniter-Aauth/commit/5df18c08971aa66f529202a7f73c1ff011823ea4) fixed cookie creation for reCAPTCHA if it's not active (@REJack)
- [6b68f4c](https://github.com/emreakay/CodeIgniter-Aauth/commit/6b68f4c21e0ce59fab3eee3bf28469604677c2cd) removed unused functions (@REJack)
- [b9b855e](https://github.com/emreakay/CodeIgniter-Aauth/commit/b9b855ea863a680d180a0deac4f1a178bad263b9) fix for empty names on creation (@REJack)
- [5028eb7](https://github.com/emreakay/CodeIgniter-Aauth/commit/5028eb7074785db9c7bf31e892bdeb7ff72c9307) added db profile (@REJack)
- [b945abb](https://github.com/emreakay/CodeIgniter-Aauth/commit/b945abbdaedc3487257ddce73107526715c2ab55) cleaned the config file (@REJack)
- [881bae1](https://github.com/emreakay/CodeIgniter-Aauth/commit/881bae11ab6cd1be94cbb13e831932e59d8c1eba) removed requirement for unique name/username (@REJack)
- [7276ebe](https://github.com/emreakay/CodeIgniter-Aauth/commit/7276ebeac7a2f9dd055e29024c4b5ffd08e85c83) Minor Typo Fix (@tswagger)

### v2.2.0 (2015/05/10)
- [2a83ea9](https://github.com/emreakay/CodeIgniter-Aauth/commit/2a83ea996a29f3269d66d788254aa30738244776) Some style changes (@tswagger)
- [bae4b0c](https://github.com/emreakay/CodeIgniter-Aauth/commit/bae4b0cf172bfa54750084e94edf847e95438ad1) Modified keep_infos() and keep_errors() with options (@tswagger)
- [5ff1af1](https://github.com/emreakay/CodeIgniter-Aauth/commit/5ff1af124c7dd2f33923efdd668f0376333ff781) Fixed issue with unintentional flashdata (@tswagger)
- [a4726f2](https://github.com/emreakay/CodeIgniter-Aauth/commit/a4726f2aa03b0229273a3ec1d7817bde6aa8ec7b) Updated SQL Table info (@tswagger)
- [6eddbc6](https://github.com/emreakay/CodeIgniter-Aauth/commit/6eddbc63cc513f58800dabc136dc07a6b07856d1) Modified lang-file constants to include prefix. (@tswagger)
- [d025313](https://github.com/emreakay/CodeIgniter-Aauth/commit/d025313e317417d6fbba9adf061252f71eca798e) Fixed an issue with is_allowed (@tswagger)
- [9daa4df](https://github.com/emreakay/CodeIgniter-Aauth/commit/9daa4df516323e5d98828362d3ead423f669e490) Modified error() and info() to NOT use flashdata by default (@tswagger)
- [dd45503](https://github.com/emreakay/CodeIgniter-Aauth/commit/dd4550374f9afa794f710b04f17b2a70d9120cbb) Removed redundant index keys on a few tables. (@tswagger)
- [6de68fe](https://github.com/emreakay/CodeIgniter-Aauth/commit/6de68fe3be4944fedd17b9ccf620ca563bfc0c7e) Edited README.md for grammer and content (@tswagger)
- [064bbf4](https://github.com/emreakay/CodeIgniter-Aauth/commit/064bbf4e9e1192bace3420fa42424076d72c7a8b) fixed minor typo in clear_infos() function name (@tswagger)
- [ec82d3e](https://github.com/emreakay/CodeIgniter-Aauth/commit/ec82d3ef06c95b7645b6109de0f2a7e4fec6b070) adjustments of typos (@tswagger)
- [6119213](https://github.com/emreakay/CodeIgniter-Aauth/commit/6119213f19532ec3a401640af81895b0c7d55a4b) Added same fix for info messages as was implemented for error messages (@tswagger)
- [1707579](https://github.com/emreakay/CodeIgniter-Aauth/commit/170757982486ca069abfdd64b124a3a8ae54a255) Fixed issue with error and modified control() to include redirect indicated in config file (@tswagger)

### v2.1.0 (2014/12/23)
- [758fd21](https://github.com/emreakay/CodeIgniter-Aauth/commit/758fd21561f2b6fed17e72311299574107be6d06) Revert "Added two new function: user_exsist_by_id() and user_exsist_by_email()" (@emreakay)
- [1006f88](https://github.com/emreakay/CodeIgniter-Aauth/commit/1006f8800f2c3e0b0a4f41e9dd0994ba3446a786) lil fix for reCAPTCHA (@REJack)
- [2b934aa](https://github.com/emreakay/CodeIgniter-Aauth/commit/2b934aaade0a88ae0d94010f7e57dabbd1ba0f0a) reCAPTCHA integration (@REJack)
- [6b1723e](https://github.com/emreakay/CodeIgniter-Aauth/commit/6b1723e95a4d1c96fa40ed4ef129055133a7e9bc) removed already existing functions
- [4491a03](https://github.com/emreakay/CodeIgniter-Aauth/commit/4491a030861ca71aeff0ed041988ef531247cfa7) Update README.md
- [c80bd10](https://github.com/emreakay/CodeIgniter-Aauth/commit/c80bd1084d2361440553143df15c59c6c7a2d70c) Added two new function: user_exsist_by_id() and user_exsist_by_email() (@c2pdev)
- [25b383b](https://github.com/emreakay/CodeIgniter-Aauth/commit/25b383bf732928b04e213d83545048f50056de00) Added missing id columns.

### v2.0.5 (2014/09/26)
- [48059ab](https://github.com/emreakay/CodeIgniter-Aauth/commit/48059ab401d9ee9804692b9bfe919ba9fb1b3e6c) Changed collation from utf8_turkish_ci to global standard utf8_general_ci
- [44cefd4](https://github.com/emreakay/CodeIgniter-Aauth/commit/44cefd4a597c5ebcf60e1621eb735800f51db667) Fixes

### v2.0.4 (2014/08/16)
- [bd75de2](https://github.com/emreakay/CodeIgniter-Aauth/commit/bd75de2c9702b1143b42f3161c4d6d96da7d9375) Update Aauth.php
- [b4f2574](https://github.com/emreakay/CodeIgniter-Aauth/commit/b4f25747cbfbaf5dfde4781f2ad835ba39e6159a) added list_system_var_keys
- [d255234](https://github.com/emreakay/CodeIgniter-Aauth/commit/d255234f1e172774f604b634730bfb99774e0340) Update Aauth.php
- [16f8113](https://github.com/emreakay/CodeIgniter-Aauth/commit/16f811352aa303d42aa49086977a3697a9403f31) 'lil fix
- [a0d4cc4](https://github.com/emreakay/CodeIgniter-Aauth/commit/a0d4cc4b8a452ffa14ff28e1e9b29bf59b05bf3d) inserted get_user_var_keys function

### v2.0.3 (2014/08/06)
- [27fd0a8](https://github.com/emreakay/CodeIgniter-Aauth/commit/27fd0a88544ead19485082ff614af6813b233391) Create aauth_lang.php
- [4d0370a](https://github.com/emreakay/CodeIgniter-Aauth/commit/4d0370af5747ceebbdb8781f13490d52a6860c3b) Update aauth.php
- [365ec00](https://github.com/emreakay/CodeIgniter-Aauth/commit/365ec00e28dacd4dd9cde48e8f69459fb9dc3d86) Update Aauth.php

### v2.0.2 (2014/08/05)
- [ec48e8e](https://github.com/emreakay/CodeIgniter-Aauth/commit/ec48e8e64103d2c92c27f13ad3477b716c272df2) Litle bug (@alfonsor)
- [a3160a0](https://github.com/emreakay/CodeIgniter-Aauth/commit/a3160a0df152a1ee491dffd31a148eeb79af89ad) Update README.md (@emreakay)

### v2.0.1 (2014/07/22)
- [05c660c](https://github.com/emreakay/CodeIgniter-Aauth/commit/05c660cf93d5d47eb5b1659d16ca4e39f94c3162) Update Aauth.php (@peazz)
- [cf7b065](https://github.com/emreakay/CodeIgniter-Aauth/commit/cf7b06562a057d69c0097df0be89c06f6480802a) Update README.md (@emreakay)
- [df90219](https://github.com/emreakay/CodeIgniter-Aauth/commit/df9021967d212009b5910a1f08b5c8e04767fb45) Update README.md (@emreakay)

### v2.0-beta (2014/07/04)
- [de03499](https://github.com/emreakay/CodeIgniter-Aauth/commit/de03499784c45b7dd67a732e08e45cfb44be1e5f) minor changes
- [f05e97e](https://github.com/emreakay/CodeIgniter-Aauth/commit/f05e97e4e47f66e2e47eee7adc2ccfb52c1dff30) minor changes
- [c78c66a](https://github.com/emreakay/CodeIgniter-Aauth/commit/c78c66a5f11017943e0e6615f77ef4fc73376b77) minor changes
- [ab95c66](https://github.com/emreakay/CodeIgniter-Aauth/commit/ab95c6689b23489899c7037fec3a1662bf761bc5) print_error and print_infos changed
- [6aba583](https://github.com/emreakay/CodeIgniter-Aauth/commit/6aba5838381618f6d77e4bdf5411f0d442e44bcc) ddos protection
- [0cdf506](https://github.com/emreakay/CodeIgniter-Aauth/commit/0cdf506727327906fa4d006d2a0a0a6bdf04c131) ddos protection
- [4e0db4a](https://github.com/emreakay/CodeIgniter-Aauth/commit/4e0db4a59192d069cd2eff87da219553a99cb8c3) ddos protection
- [ecbadd9](https://github.com/emreakay/CodeIgniter-Aauth/commit/ecbadd961d1f4ea9906ed4919d72fe4d89a14621) ddos protection changed
- [72c5596](https://github.com/emreakay/CodeIgniter-Aauth/commit/72c5596865bdd0eb91b06f6fb70ca35ef28da147) logout() is debugged
- [3f917d8](https://github.com/emreakay/CodeIgniter-Aauth/commit/3f917d83b17f10469908beda0f85e3c8a532e37b) Ddos protection feature has removed
- [221e686](https://github.com/emreakay/CodeIgniter-Aauth/commit/221e686a22710cb7c1235db8e059b325e3826096) user and aauth system variables implemented
- [aea9449](https://github.com/emreakay/CodeIgniter-Aauth/commit/aea9449d921a19dc671cb863cc472dd882d07b5c) unset_user_var() implemented
- [628d6d1](https://github.com/emreakay/CodeIgniter-Aauth/commit/628d6d149a027894bfc8a9b2b0862f3d37070bca) set_user_var() implemented
- [2a74c11](https://github.com/emreakay/CodeIgniter-Aauth/commit/2a74c1131d9f448d230b1929e66e8ae1d10915f0) get_user_var implemented
- [7c050bc](https://github.com/emreakay/CodeIgniter-Aauth/commit/7c050bc8b08018e11aa731bf6a75e61ad37e2275) unset_user_var() added
- [386a77e](https://github.com/emreakay/CodeIgniter-Aauth/commit/386a77e71f894eb46e7dc98ce0293079b246105d) PhpDocs of User and Aauth System Variables.
- [982cb87](https://github.com/emreakay/CodeIgniter-Aauth/commit/982cb87c956125a0d97ea039dc0b7666602dd62d) User and Aauth System Variables.
- [b34a57a](https://github.com/emreakay/CodeIgniter-Aauth/commit/b34a57a379e40eb83bac2397be01b8f8738cb731) some changes
- [20aab13](https://github.com/emreakay/CodeIgniter-Aauth/commit/20aab13344bb6b92320bd072b301c7b82e27cf6a) bug fixed in delete_group()
- [270dc68](https://github.com/emreakay/CodeIgniter-Aauth/commit/270dc685400a58d5f75b71b27aa72a765b2e31d0) ip_address will be also updated in update_last_login()
- [83be42c](https://github.com/emreakay/CodeIgniter-Aauth/commit/83be42c3c429eddde8776440270883bc6b9cedef) allow_user( ) and deny_user() functions is implemented
- [3615446](https://github.com/emreakay/CodeIgniter-Aauth/commit/361544600acd4784f76e33a19d26d7aaec59e85b) v2 dev
- [77e30dc](https://github.com/emreakay/CodeIgniter-Aauth/commit/77e30dc5f1d1a67c339ae0242f8b6986efe0b286) v2 dev

### v1.0 (2014/06/11)
- [257e186](https://github.com/emreakay/CodeIgniter-Aauth/commit/257e186353cfe4c4a2a4bcb89a8aefb9bb352d5c) Version 1.0 last commit
- [336e510](https://github.com/emreakay/CodeIgniter-Aauth/commit/336e5109ce91b7413ae31f56459e12dc1d8f88d7) Example change2
- [4aa6494](https://github.com/emreakay/CodeIgniter-Aauth/commit/4aa6494064141ce5578a3c9db8d48dee6afc9a8b) Added stronger password encyption with salts (@jacobtomlinson)
- [b5a723e](https://github.com/emreakay/CodeIgniter-Aauth/commit/b5a723eb87f6e45f9d04e1632cbb00c006608ec2) Moved password hashing to separate function (@jacobtomlinson)
- [a8fca2f](https://github.com/emreakay/CodeIgniter-Aauth/commit/a8fca2f0360536c33f9555e44bcb65cfd869afcc) More comment and whitespace cleanup (@jacobtomlinson)
- [c4e9da7](https://github.com/emreakay/CodeIgniter-Aauth/commit/c4e9da73feff6f9bce02aa428fccff506f5dc6d2) Added PHP Doc comments http://www.phpdoc.org/docs/latest/index.html (@jacobtomlinson)
- [1f81b3f](https://github.com/emreakay/CodeIgniter-Aauth/commit/1f81b3fbeea8aaccae3aeea3985a96393823679a) Remove allowed characters before name before alphanumeric test (@jacobtomlinson)
- [36cd525](https://github.com/emreakay/CodeIgniter-Aauth/commit/36cd525b50cc849167608719f157ec2981725892) Added checking for unverified account on login, display appropriate error message. (@jacobtomlinson)
- [534d5ca](https://github.com/emreakay/CodeIgniter-Aauth/commit/534d5ca710840761d8f73e1d4f4018e7aa863356) Changed cookie access to use CodeIgniter input class instead of direct access (@jacobtomlinson)
- [af10b64](https://github.com/emreakay/CodeIgniter-Aauth/commit/af10b6475d31abaeb60e7235252e39c7a4847df7) Removed closing tag and whitespace as it was causing headers to go early (@jacobtomlinson)
- [ca5d616](https://github.com/emreakay/CodeIgniter-Aauth/commit/ca5d616628e5a0bc7d6db5071453eb3800327333) Update README.md (@emreakay)
- [6bd88b5](https://github.com/emreakay/CodeIgniter-Aauth/commit/6bd88b5ca755f871bb82263182367d5562b65760) little (@emreakay)
- [535f94a](https://github.com/emreakay/CodeIgniter-Aauth/commit/535f94aaf5516d80d8eb1b58701f6c53175aea82) relese (@emreakay)
- [9e58c34](https://github.com/emreakay/CodeIgniter-Aauth/commit/9e58c3429e1747c9ee0f9498fa2563ef956f3687) Relase
- [3befcf9](https://github.com/emreakay/CodeIgniter-Aauth/commit/3befcf92f520b9b5942c528f241de742718e98ca) little chance (@emreakay)
- [c834be7](https://github.com/emreakay/CodeIgniter-Aauth/commit/c834be73c838349c6bb65568515d5e9690ec8768) minor change
- [c24a539](https://github.com/emreakay/CodeIgniter-Aauth/commit/c24a539caa668570c5b109fd86e5283520ec83df) minor change
- [dd7cd95](https://github.com/emreakay/CodeIgniter-Aauth/commit/dd7cd95bc8390eb586600e1f8456610a340a48f1) minor change
- [64d91d6](https://github.com/emreakay/CodeIgniter-Aauth/commit/64d91d60d2564f75b480f184f2a69638cea0a2bd) minor change
- [cc08326](https://github.com/emreakay/CodeIgniter-Aauth/commit/cc083260b84766231e2ec718d367993ef6bcadee) minor change
- [5a3460c](https://github.com/emreakay/CodeIgniter-Aauth/commit/5a3460c941c14eb54836e7de6f3a8585a6d8fb03) deleting other files
- [b4f99c5](https://github.com/emreakay/CodeIgniter-Aauth/commit/b4f99c53409bbf0dedf1a80e7554741f56236304) deleting other files
- [0af3cda](https://github.com/emreakay/CodeIgniter-Aauth/commit/0af3cdad9ed6ca046bb9ae8b4e2a94f8fe608def) New changelist
- [4667997](https://github.com/emreakay/CodeIgniter-Aauth/commit/4667997b7df7167cd2c582d6ec2ba9fb69ee01d4) deleting some files
- [afc8aa1](https://github.com/emreakay/CodeIgniter-Aauth/commit/afc8aa16f4424696d1594ae720f2e77dac041e44) deleting some files
- [e3431dc](https://github.com/emreakay/CodeIgniter-Aauth/commit/e3431dc7325821b0c142fdc41dd85032984180d8) c
- [19873a3](https://github.com/emreakay/CodeIgniter-Aauth/commit/19873a3eb0be98aeee8645710477a25b23a04d84) c
- [c886418](https://github.com/emreakay/CodeIgniter-Aauth/commit/c886418fdf0ff209334146fe13c3cab29a5d928e) c
- [3ab258e](https://github.com/emreakay/CodeIgniter-Aauth/commit/3ab258e4605277363141f3ff79c1ee46097bb4b8) deleted (@emreakay)
- [5c2834e](https://github.com/emreakay/CodeIgniter-Aauth/commit/5c2834e09b777f5ffeed1f35b6c5dc5b77344fb5) c
- [3389b67](https://github.com/emreakay/CodeIgniter-Aauth/commit/3389b67e855768069a94cafae117a2a3e25ffc80) minor changes
- [9abde25](https://github.com/emreakay/CodeIgniter-Aauth/commit/9abde255268452e66f60f4b148b5d55514250f16) minor changes
- [4d27f07](https://github.com/emreakay/CodeIgniter-Aauth/commit/4d27f07e1dd4433758ee81870b368e907cca26b1) sql files added under sql folder
- [0ea6409](https://github.com/emreakay/CodeIgniter-Aauth/commit/0ea6409608fde5618dcfbb60be088f5a0bf4e731) minor changes
- [2fc4269](https://github.com/emreakay/CodeIgniter-Aauth/commit/2fc4269da3fb787803c895dcf0a80368c713d4d9) create_user now automaticy sets default group
- [7358295](https://github.com/emreakay/CodeIgniter-Aauth/commit/73582950b32bf397beee48a77a77ba0459f9b3bc) errors and infos fixed
- [74d4adb](https://github.com/emreakay/CodeIgniter-Aauth/commit/74d4adb4d5ade9dbad178897d272aeb11f1b6c41) First commit