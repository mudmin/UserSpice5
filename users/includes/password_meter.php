<?php
if ($pw_settings->meter_active == 1) {
           

    $unmet_icon = '<i class="fa fa-times text-danger me-2" style="font-size:1.25rem; padding-right:.25rem!important;></i>';
    $met_icon = '<i class="fa fa-check text-success" style="margin-right:.35rem;"></i>';


    function generate_icon_statement($id, $iconHtml, $tooltipText)
    {
      global $unmet_icon, $met_icon;
      return "<tr>
            <td>
                <span id='{$id}_met_icon' class='password-requirement-icon' style='display:none;'>{$met_icon}</span>
                <span id='{$id}_unmet_icon' class='password-requirement-icon'>{$unmet_icon}</span>
                <span id='{$id}_met_icon' class='password-requirement-icon'>{$met_icon}</span>
                {$iconHtml}
            </td>
            <td><span id='{$id}' class='text-muted'>{$tooltipText}</span></td>
        </tr>";
    }

    $statements = [];

    // Character range icons for min and max lengths
    $min_icon = '<i class="me-2 fa fa-text-width" title="' . htmlspecialchars(lang("GEN_MIN") . " " . $pw_settings->min_length . " " . lang("GEN_CHAR")) . '"></i>';
    $max_icon = '<i class="me-2 fa fa-text-width" title="' . htmlspecialchars(lang("GEN_MAX") . " " . $pw_settings->max_length . " " . lang("GEN_CHAR")) . '"></i>';
    $statements[] = generate_icon_statement('min_length', $min_icon, ucfirst(trim(lang("GEN_MIN"))) . " " . $pw_settings->min_length);
    $statements[] = generate_icon_statement('max_length', $max_icon, ucfirst(trim(lang("GEN_MAX"))) . " " . $pw_settings->max_length);

    // Other requirements
    if($pw_settings->require_uppercase == 1){
    $caps_icon = '<i class="me-2 fa fa-font" title="' . htmlspecialchars(ucfirst(trim(lang("JOIN_CAP")))) . '"></i>';
    $statements[] = generate_icon_statement('caps', $caps_icon, ucfirst(trim(lang("JOIN_CAP"))));
    }

    if($pw_settings->require_lowercase == 1){
    $lower_icon = '<i class="me-2 fa fa-font" style="font-size: 90% !important;" title="' . htmlspecialchars(ucfirst(trim(lang("JOIN_LOWER")))) . '"></i>';
    $statements[] = generate_icon_statement('lower', $lower_icon, ucfirst(trim(lang("JOIN_LOWER"))));
    }

    if($pw_settings->require_numbers == 1){
    $number_icon = '<i class="me-2 fa fa-hashtag" title="' . htmlspecialchars(ucfirst(trim(lang("GEN_NUMBER")))) . '"></i>'; // Using 'me-2 fa fa-sort-numeric-up' for numbers
    $statements[] = generate_icon_statement('number', $number_icon, ucfirst(trim(lang("GEN_NUMBER"))));
    }

    if($pw_settings->require_symbols == 1){
    $symbol_icon = '<i class="me-2 fa fa-at" title="' . htmlspecialchars(ucfirst(trim(lang("JOIN_SYMBOL")))) . '"></i>'; // '@' symbol for special characters
    $statements[] = generate_icon_statement('symbols', $symbol_icon, ucfirst(trim(lang("JOIN_SYMBOL"))));
    } 

    $match_icon = '<i class="me-2 fa fa-copy" title="' . htmlspecialchars(lang("JOIN_TWICE")) . '"></i>'; // Double check for password match
    $statements[] = generate_icon_statement('password_match', $match_icon, lang("JOIN_TWICE"));

    $score_icon = '<i class="me-2 fa fa-shield" title="' . htmlspecialchars(lang("JOIN_SCORE")) . '"></i>'; // Shield for password strength score
    $goal_score = $pw_settings->min_score;
    if ($goal_score < 0) $goal_score = 0;
    $statements[] = generate_icon_statement('score', $score_icon, ">= " . $goal_score . "<span class='usPasswordScore'></span>");
?>
    <table style="border-collapse: collapse; border: none;">
        <?= implode("", $statements); ?>
    </table>

    <style>
    .password-verification {
      font-size: 80%;
    }

    .password-verification i.fa {
      font-size: 1.12rem;
    }
  </style>



      <script type="text/javascript">

function setupPasswordValidation(passwordSelector, confirmSelector, submitButtonId) {
  // Define the minimum acceptable score.
  const minScore = <?= $pw_settings->min_score; ?>;



  // Function to evaluate password strength and return a score.
  // function evaluatePasswordStrength(password) {
  //   let score = 0;
  //   const criteria = [{
  //       regex: /[a-z]/,
  //       score: pwSettings.lowercase_score,
  //       found: false
  //     },
  //     {
  //       regex: /[A-Z]/,
  //       score: pwSettings.uppercase_score,
  //       found: false
  //     },
  //     {
  //       regex: /\d/,
  //       score: pwSettings.number_score,
  //       found: false
  //     },
  //     {
  //       regex: /[^A-Za-z0-9]/,
  //       score: pwSettings.symbol_score,
  //       found: false
  //     },
  //     {
  //       length: 8,
  //       score: pwSettings.greater_eight
  //     },
  //     {
  //       length: 12,
  //       score: pwSettings.greater_twelve
  //     },
  //     {
  //       length: 16,
  //       score: pwSettings.greater_sixteen
  //     }
  //   ];

  //   criteria.forEach(criterion => {
  //     if (criterion.regex && criterion.regex.test(password)) {
  //       score += criterion.score;
  //       criterion.found = true; // Mark as found
  //     } else if (criterion.length && password.length >= criterion.length) {
  //       score += criterion.score;
  //     }
  //   });

  //   // Calculate bonus points for length to a max of 20
  //   score += Math.min(20, password.length * 2);

  //   // Check if all types of characters were found; if not, limit score to 74
  //   if (!criteria[0].found || !criteria[1].found || !criteria[2].found || !criteria[3].found) {
  //     score = Math.min(score, 74);
  //   }

  //   // Ensure score is not above 100
  //   score = Math.min(score, 100);

  //   // Handle NaN case
  //   if (isNaN(score)) {
  //     score = 0;
  //   }

  //   return score;
  // }

  function evaluatePasswordStrength(password) {

    return new Promise((resolve, reject) => {
        var formData = {
            'password': password,
            'pw_settings': <?= json_encode($pw_settings) ?>,
            'token': "<?= Token::generate() ?>",
        };

        $.ajax({
            type: 'POST',
            url: '<?= $us_url_root ?>users/parsers/pw_strength_check.php',
            data: formData,
            dataType: 'json',
        })
        .done(function(data) {
            console.log('Password strength score:', data.score);
            resolve(data.score); // Promise resolved
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            
            console.error('AJAX request failed: ', textStatus, errorThrown);
            reject(0); 
        });
    });
}


  // Function to check password conditions and update UI accordingly.
  async function checkPasswordConditions() {
    var pswd = $(passwordSelector).val();

    var strengthScore = await evaluatePasswordStrength(pswd);
    console.log('Password Score:', strengthScore); 
  

    // Update the password strength meter based on the score.
    var scoreColor = 'text-danger';

    if (strengthScore < minScore / 4) {
      strengthScoreClass = 'text-danger';
    } else if (strengthScore < minScore / 2) {
      strengthScoreClass = 'text-warning';
    } else if (strengthScore < minScore) {
      strengthScoreClass = 'text-info';
    } else {
      strengthScoreClass = 'text-success';
    }


    $(".usPasswordScore").html(` (<?= lang("JOIN_SCORE") ?> <span class='${strengthScoreClass}'><b>${strengthScore}</b></span>/100)`); // Update the password score display.

    var meetsScoreRequirement = strengthScore >= minScore;
    updateConditionDisplay(meetsScoreRequirement, $("#score_met_icon"), $("#score_unmet_icon"), $(".usPasswordScore"));
    var disableSubmitOnFailure = <?=$pw_settings->enforce_rules?>; 
    var confirmPswd = $(confirmSelector).val();
    var allConditionsMet = strengthScore >= minScore; // Check if the score meets the minimum requirement.
    var isPasswordNotEmpty = pswd.length > 0;

    var conditions = [{
        condition: isPasswordNotEmpty && pswd.length >= <?= $pw_settings->min_length; ?>,
        iconMet: $("#min_length_met_icon"),
        iconUnmet: $("#min_length_unmet_icon"),
        text: $("#min_length")
      },
      {
        condition: isPasswordNotEmpty && pswd.length <= <?= $pw_settings->max_length; ?>,
        iconMet: $("#max_length_met_icon"),
        iconUnmet: $("#max_length_unmet_icon"),
        text: $("#max_length")
      },
      {
        condition: isPasswordNotEmpty && /[A-Z]/.test(pswd),
        iconMet: $("#caps_met_icon"),
        iconUnmet: $("#caps_unmet_icon"),
        text: $("#caps")
      },
      {
        condition: isPasswordNotEmpty && /[a-z]/.test(pswd),
        iconMet: $("#lower_met_icon"),
        iconUnmet: $("#lower_unmet_icon"),
        text: $("#lower")
      },
      {
        condition: isPasswordNotEmpty && /\d/.test(pswd),
        iconMet: $("#number_met_icon"),
        iconUnmet: $("#number_unmet_icon"),
        text: $("#number")
      },
      {
        condition: isPasswordNotEmpty && /[^A-Za-z0-9]/.test(pswd),
        iconMet: $("#symbols_met_icon"),
        iconUnmet: $("#symbols_unmet_icon"),
        text: $("#symbols")
      },
      {
        condition: isPasswordNotEmpty && pswd === confirmPswd,
        iconMet: $("#password_match_met_icon"),
        iconUnmet: $("#password_match_unmet_icon"),
        text: $("#password_match")
      },
      {
        condition: isPasswordNotEmpty && pswd.length >= <?= $pw_settings->min_length; ?>,
        iconMet: $("#min_length_met_icon"),
        iconUnmet: $("#min_length_unmet_icon"),
        text: $("#min_length")
      },
      {
        condition: isPasswordNotEmpty && pswd.length <= <?= $pw_settings->max_length; ?>,
        iconMet: $("#max_length_met_icon"),
        iconUnmet: $("#max_length_unmet_icon"),
        text: $("#max_length")
      },
    ];

    conditions.forEach(function(c) {
      var conditionMet = c.condition;
      allConditionsMet = allConditionsMet && conditionMet; // Ensure all conditions are met.
      updateConditionDisplay(conditionMet, c.iconMet, c.iconUnmet, c.text);
    });

    if (disableSubmitOnFailure == 1) {
      $(submitButtonId).prop('disabled', !allConditionsMet);
    }
  }

  function updateConditionDisplay(conditionMet, iconMet, iconUnmet, text) {
    if (conditionMet) {
      console.log('Showing Met Icon:', iconMet.attr('id')); // Debugging
      iconMet.css('display', 'inline-block'); // Use CSS method as a direct approach
      iconUnmet.hide();
      text.addClass("text-success").removeClass("text-muted");
    } else {
      console.log('Hiding Met Icon:', iconMet.attr('id')); // Debugging
      iconMet.hide();
      iconUnmet.css('display', 'inline-block');
      text.removeClass("text-success").addClass("text-muted");
    }
  }

  // Setup event listeners for real-time validation.
  $(passwordSelector + ", " + confirmSelector).keyup(checkPasswordConditions);

  // Initial condition check.
  checkPasswordConditions();
}

// Initialize the password validation setup on document ready.
$(document).ready(function() {
  setupPasswordValidation('#password', '#confirm', '#next_button', true);
});
</script>




<?php

} //end meter active
?>