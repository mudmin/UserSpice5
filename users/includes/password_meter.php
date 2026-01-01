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



      <script nonce="<?=htmlspecialchars($usespice_nonce ?? '')?>" type="text/javascript">

function setupPasswordValidation(passwordSelector, confirmSelector, submitButtonId) {
  const minScore = <?= $pw_settings->min_score; ?>;
  const pwSettings = <?= json_encode($pw_settings); ?>; // Get all password settings

  async function evaluatePasswordStrength(password) {
    return new Promise((resolve, reject) => {
      var formData = {
        'password': password,
        'pw_settings': pwSettings,
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
        resolve(data.score);
      })
      .fail(function(jqXHR, textStatus, errorThrown) {
        console.error('AJAX request failed: ', textStatus, errorThrown);
        reject(0);
      });
    });
  }

  async function checkPasswordConditions() {
    var pswd = $(passwordSelector).val();
    var strengthScore = await evaluatePasswordStrength(pswd);
    var confirmPswd = $(confirmSelector).val();
    var isPasswordNotEmpty = pswd.length > 0;

    // Update strength score display
    var strengthScoreClass = 'text-danger';
    if (strengthScore >= minScore) {
      strengthScoreClass = 'text-success';
    } else if (strengthScore >= minScore / 2) {
      strengthScoreClass = 'text-info';
    } else if (strengthScore >= minScore / 4) {
      strengthScoreClass = 'text-warning';
    }

    $(".usPasswordScore").html(` (<?= lang("JOIN_SCORE") ?> <span class='${strengthScoreClass}'><b>${strengthScore}</b></span>/100)`);

    // Initialize conditions array with only the active requirements
    let conditions = [];

    // Only add length conditions if they are set
    if (pwSettings.min_length > 0) {
      conditions.push({
        condition: isPasswordNotEmpty && pswd.length >= pwSettings.min_length,
        iconMet: $("#min_length_met_icon"),
        iconUnmet: $("#min_length_unmet_icon"),
        text: $("#min_length")
      });
    }

    if (pwSettings.max_length > 0) {
      conditions.push({
        condition: isPasswordNotEmpty && pswd.length <= pwSettings.max_length,
        iconMet: $("#max_length_met_icon"),
        iconUnmet: $("#max_length_unmet_icon"),
        text: $("#max_length")
      });
    }

    // Only add uppercase condition if required
    if (pwSettings.require_uppercase == 1) {
      conditions.push({
        condition: isPasswordNotEmpty && /[A-Z]/.test(pswd),
        iconMet: $("#caps_met_icon"),
        iconUnmet: $("#caps_unmet_icon"),
        text: $("#caps")
      });
    }

    // Only add lowercase condition if required
    if (pwSettings.require_lowercase == 1) {
      conditions.push({
        condition: isPasswordNotEmpty && /[a-z]/.test(pswd),
        iconMet: $("#lower_met_icon"),
        iconUnmet: $("#lower_unmet_icon"),
        text: $("#lower")
      });
    }

    // Only add number condition if required
    if (pwSettings.require_numbers == 1) {
      conditions.push({
        condition: isPasswordNotEmpty && /\d/.test(pswd),
        iconMet: $("#number_met_icon"),
        iconUnmet: $("#number_unmet_icon"),
        text: $("#number")
      });
    }

    // Only add symbol condition if required
    if (pwSettings.require_symbols == 1) {
      conditions.push({
        condition: isPasswordNotEmpty && /[^A-Za-z0-9]/.test(pswd),
        iconMet: $("#symbols_met_icon"),
        iconUnmet: $("#symbols_unmet_icon"),
        text: $("#symbols")
      });
    }

    // Always add password match condition
    conditions.push({
      condition: isPasswordNotEmpty && pswd === confirmPswd,
      iconMet: $("#password_match_met_icon"),
      iconUnmet: $("#password_match_unmet_icon"),
      text: $("#password_match")
    });

    // Add score condition
    conditions.push({
      condition: strengthScore >= minScore,
      iconMet: $("#score_met_icon"),
      iconUnmet: $("#score_unmet_icon"),
      text: $(".usPasswordScore")
    });

    // Check all conditions
    let allConditionsMet = true;
    conditions.forEach(function(c) {
      const conditionMet = c.condition;
      allConditionsMet = allConditionsMet && conditionMet;
      updateConditionDisplay(conditionMet, c.iconMet, c.iconUnmet, c.text);
    });

    // Only disable submit button if enforce_rules is enabled
    if (pwSettings.enforce_rules == 1) {
      $(submitButtonId).prop('disabled', !allConditionsMet);
    }
  }

  function updateConditionDisplay(conditionMet, iconMet, iconUnmet, text) {
    if (conditionMet) {
      iconMet.css('display', 'inline-block');
      iconUnmet.hide();
      text.addClass("text-success").removeClass("text-muted");
    } else {
      iconMet.hide();
      iconUnmet.css('display', 'inline-block');
      text.removeClass("text-success").addClass("text-muted");
    }
  }

  // Setup event listeners and initial check
  $(passwordSelector + ", " + confirmSelector).keyup(checkPasswordConditions);
  checkPasswordConditions();
}

// Initialize on document ready
$(document).ready(function() {
  setupPasswordValidation('#password', '#confirm', '#next_button');
});

</script>
<?php } //end meter active
?>