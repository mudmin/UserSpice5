If you distribute/modify this code, it is recommended that you release it without the following files.

usersc/templates/customizer/assets/css/customizations.php
usersc/templates/customizer/assets/css/custom-bootstrap-202xxxxxxxxx.css
usersc/templates/customizer/assets/child_themes/dashboard.php
usersc/templates/customizer/assets/child_themes/dashboard-202xxxxxxxxx.css

You can put defaults for these in usersc/templates/customizer/assets/defaults

By doing this you will not overwrite anyone's existing files. The first time the template loads without finding 
usersc/templates/customizer/assets/css/customizations.php
It will create a new set of defaults.  Otherwise, the existing files will be left alone during the update process.
