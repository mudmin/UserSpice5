If you would like to override any of the existing language keys that are in users/lang, you can do so by creating a file with the same name in this folder.

See the en-US.php example.

Additinally, if you want to create your own language keys and use them throughout your project you can add to the language array by just adding additional keys.

Understanding Terms and Conditions
The file usersc/includes/user_agreement.php is the default/English terms and conditions.

You can edit that however you want.  This is the logic:
1. If the user's language is en-US, it will load the file in usersc/includes/user_agreement.php
2. If the user's language is not en-US, it will check for a file in usersc/lang/termsandcond with that langauge name in the format of xx-XX.php.
3. If it finds it, it will load that file. Note that this is not a language key like the rest of the language. This is plain HTML.
4. If it doesn not find the file in the termsandcond folder, it will load the default one.
