<?php
//This file parses all the various messages that are stored in
//$_GET and $_SESSION variables and displays them
//note that if you create a usersc/includes/system_messages_footer.php
//your file will be included instead of ours

// Collect messages
$usSessionMessages = function_exists('parseSessionMessages') ? parseSessionMessages() : [];

$usSessionMessageClasses = [
  'err'    => 'primary',
  'msg'    => 'info',
  'genMsg' => 'dark',
  'valSuc' => 'success',
  'valErr' => 'danger',
];
?>
<style>
/* Toast notification bar styles */
.us-toast-bar {
  height: 4px;
  width: 100%;
  border-radius: 0.25rem 0.25rem 0 0;
  transition: opacity 0.3s ease;
}

.us-bar-primary {
  background: linear-gradient(90deg, var(--bs-primary) 0%, var(--bs-primary) 100%);
  box-shadow: 0 2px 4px rgba(var(--bs-primary-rgb), 0.3);
}

.us-bar-info {
  background: linear-gradient(90deg, var(--bs-info) 0%, var(--bs-info) 100%);
  box-shadow: 0 2px 4px rgba(var(--bs-info-rgb), 0.3);
}

.us-bar-dark {
  background: linear-gradient(90deg, var(--bs-dark) 0%, var(--bs-dark) 100%);
  box-shadow: 0 2px 4px rgba(var(--bs-dark-rgb), 0.3);
}

.us-bar-success {
  background: linear-gradient(90deg, var(--bs-success) 0%, var(--bs-success) 100%);
  box-shadow: 0 2px 4px rgba(var(--bs-success-rgb), 0.3);
}

.us-bar-danger {
  background: linear-gradient(90deg, var(--bs-danger) 0%, var(--bs-danger) 100%);
  box-shadow: 0 2px 4px rgba(var(--bs-danger-rgb), 0.3);
}

/* Optional: subtle animation on toast show */
.us-toast {
  border: 1px solid rgba(0, 0, 0, 0.05);
}

.us-toast.showing .us-toast-bar,
.us-toast.show .us-toast-bar {
  opacity: 1;
}
</style>
<script nonce="<?=htmlspecialchars($usespice_nonce ?? '')?>">
(function(){
  const container = document.getElementById('us-toast-container');
  const justify = container ? (container.getAttribute('data-justify') || 'left') : 'left';
  const LEFT = justify === 'left';
  
  // A randomized break token to prevent attackers from forcing breaks.
  const USERSPICE_BREAK = `---USERSPICE_BREAK-${Math.random().toString(36).substring(7)}---`;
  const MAX_MESSAGE_LENGTH = 500; // Limit message size to prevent DOM blowups.

  function userSpiceMessage(message, bootstrapType){
    const wrap = container || document.body;
    const toast = document.createElement('div');
    toast.className = 'toast us-toast ' + (LEFT ? 'us-toast-left' : '');
    toast.setAttribute('role','alert');
    toast.setAttribute('aria-live','assertive');
    toast.setAttribute('aria-atomic','true');

    const bar = document.createElement('div');
    bar.className = 'us-toast-bar ' + mapTypeToBar(bootstrapType);
    toast.appendChild(bar);

    const row = document.createElement('div');
    row.className = 'd-flex ' + (LEFT ? 'flex-row-reverse' : 'flex-row') + ' align-items-start';

    const body = document.createElement('div');
    body.className = 'toast-body flex-grow-1';

    // Sanitize and format the message, then build the nodes directly.
    buildToastBodyContent(body, String(message == null ? '' : message));

    const btn = document.createElement('button');
    btn.type = 'button';
    btn.className = 'btn-close ms-2 me-2 mt-2';
    btn.setAttribute('data-bs-dismiss','toast');
    btn.setAttribute('aria-label','Close');

    row.appendChild(body);
    row.appendChild(btn);
    toast.appendChild(row);
    wrap.appendChild(toast);

    try { new bootstrap.Toast(toast, { delay: 6000, autohide: true }).show(); } catch(e){}
  }

  function mapTypeToBar(t){
    switch(t){
      case 'primary': return 'us-bar-primary';
      case 'info': return 'us-bar-info';
      case 'dark': return 'us-bar-dark';
      case 'success': return 'us-bar-success';
      case 'danger': return 'us-bar-danger';
      default: return 'us-bar-info';
    }
  }

  /**
   * Sanitizes HTML using a safe token-replacement approach.
   * 1. Replace allowed tags with unique tokens
   * 2. Strip ALL HTML via textContent
   * 3. Restore allowed tags from tokens
   */
  function sanitizeAndFormat(html) {
    let temp = String(html).substring(0, MAX_MESSAGE_LENGTH);

    // Token storage for allowed tags
    const tokens = [];
    const TOKEN_PREFIX = USERSPICE_BREAK;

    // Allowed simple tags (self-closing or paired)
    const allowedPatterns = [
      { regex: /<\s*br\s*\/?>/gi, tag: '<br>' },
      { regex: /<\s*\/?\s*strong\s*>/gi, restore: true },
      { regex: /<\s*\/?\s*b\s*>/gi, restore: true },
      { regex: /<\s*\/?\s*em\s*>/gi, restore: true },
      { regex: /<\s*\/?\s*i\s*>/gi, restore: true },
      { regex: /<\s*\/?\s*u\s*>/gi, restore: true },
      { regex: /<\s*\/?\s*ul\s*>/gi, restore: true },
      { regex: /<\s*\/?\s*li\s*>/gi, restore: true }
    ];

    // Replace allowed tags with tokens
    allowedPatterns.forEach((pattern, pIndex) => {
      temp = temp.replace(pattern.regex, (match) => {
        const tokenIndex = tokens.length;
        // Normalize the tag (lowercase, no extra spaces)
        const normalized = pattern.tag || match.toLowerCase().replace(/\s+/g, '');
        tokens.push(normalized);
        return `${TOKEN_PREFIX}${tokenIndex}${TOKEN_PREFIX}`;
      });
    });

    // Strip ALL remaining HTML via DOMParser textContent
    const doc = new DOMParser().parseFromString(temp, 'text/html');
    let safeText = doc.body.textContent || "";

    // Restore allowed tags from tokens
    tokens.forEach((tag, index) => {
      const tokenPattern = new RegExp(`${TOKEN_PREFIX.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&')}${index}${TOKEN_PREFIX.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&')}`, 'g');
      safeText = safeText.replace(tokenPattern, tag);
    });

    return safeText;
  }

  function buildToastBodyContent(bodyElement, message) {
    const safeText = sanitizeAndFormat(String(message == null ? '' : message));
    // Now safe to use innerHTML since we've sanitized to only allowed tags
    bodyElement.innerHTML = safeText;
  }

  // Shorthand helpers
  window.usSuccess = function(msg){ userSpiceMessage(msg,'success'); };
  window.usError   = function(msg){ userSpiceMessage(msg,'danger'); };
  window.usInfo    = function(msg){ userSpiceMessage(msg,'info'); };
  window.usPrimary = function(msg){ userSpiceMessage(msg,'primary'); };
  window.usDark    = function(msg){ userSpiceMessage(msg,'dark'); };

  // Emit from PHP
  <?php if (!empty($_GET['err'])): ?>
    userSpiceMessage(<?php echo json_encode((string)$_GET['err'], JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP); ?>,'<?php echo $usSessionMessageClasses['err']; ?>');
  <?php endif; ?>
  <?php if (!empty($_GET['msg'])): ?>
    userSpiceMessage(<?php echo json_encode((string)$_GET['msg'], JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP); ?>,'<?php echo $usSessionMessageClasses['msg']; ?>');
  <?php endif; ?>
  <?php foreach (['genMsg','valSuc','valErr'] as $k): if (!empty($usSessionMessages[$k])): ?>
    userSpiceMessage(<?php echo json_encode((string)$usSessionMessages[$k], JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP); ?>,'<?php echo $usSessionMessageClasses[$k]; ?>');
  <?php endif; endforeach; ?>
})();
</script>