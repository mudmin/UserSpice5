<script nonce="<?=htmlspecialchars($usespice_nonce ?? '')?>" type="text/javascript" src="<?= $us_url_root ?>users/js/pagination/datatables.min.js"></script>
<script nonce="<?=htmlspecialchars($usespice_nonce ?? '')?>" type="text/javascript">
  $(document).ready(function() {
    $('[data-toggle="popover"]').popover();

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    });


    function messages(data) {
      console.log(data.msg);
      console.log("messages found");
      $('#messages').removeClass();
      $('#message').text("");
      $('#messages').show();
      if (data.success == "true") {
        $('#messages').addClass("sufee-alert alert with-close alert-success alert-dismissible fade show");
      } else {
        $('#messages').addClass("sufee-alert alert with-close alert-success alert-dismissible fade show");
      }

      $('#message').html(data.msg);
      $('#messages').delay(3000).fadeOut('slow');

    }

    $(".toggle").change(function() {
      var value = $(this).prop("checked");
      $(this).prop("checked", value);

      var field = $(this).attr("id"); //the id in the input tells which field to update
      var desc = $(this).attr("data-desc"); //For messages
      var table = $(this).attr("data-table");
      var formData = {
        'value': value,
        'field': field,
        'desc': desc,
        'table': table,
        'type': 'toggle',
        'token': "<?= Token::generate() ?>",
      };

      $.ajax({
          type: 'POST',
          url: 'parsers/admin_settings.php',
          data: formData,
          dataType: 'json',
        })

        .done(function(data) {
          messages(data);
        })
    });

    $("#force_user_pr").click(function(data) {
      console.log("clicked");
      var formData = {
        'type': 'resetPW',
        'token': "<?= Token::generate() ?>",
      };
      $.ajax({
          type: 'POST',
          url: 'parsers/admin_settings.php',
          data: formData,
          dataType: 'json',
          encode: true
        })
        .done(function(data) {
          messages(data);
        })
    });

    $(".ajxnum").change(function() {
      var value = $(this).val();
      // console.log(value);

      var field = $(this).attr("id"); //the id in the input tells which field to update
      var desc = $(this).attr("data-desc"); //For messages
      var table = $(this).attr("data-table");
      var formData = {
        'value': value,
        'field': field,
        'desc': desc,
        'table': table,
        'type': 'num',
        'token': "<?= Token::generate() ?>",
      };

      $.ajax({
          type: 'POST',
          url: 'parsers/admin_settings.php',
          data: formData,
          dataType: 'json',
        })

        .done(function(data) {
          messages(data);
        })
    });

    $(".ajxtxt").change(function() {
      var value = $(this).val();
      console.log(value);

      var field = $(this).attr("id"); //the id in the input tells which field to update
      var desc = $(this).attr("data-desc"); //For messages
      var table = $(this).attr("data-table");
      var formData = {
        'value': value,
        'field': field,
        'desc': desc,
        'table': table,
        'type': 'txt',
        'token': "<?= Token::generate() ?>",
      };

      $.ajax({
          type: 'POST',
          url: 'parsers/admin_settings.php',
          data: formData,
          dataType: 'json',
        })

        .done(function(data) {
          console.log(data);
          if (data.api != "") {
            $("#APIKeyMessage").html(data.api);
          }
          messages(data);
        })
    });


    // hide cards
    $('.collapseCard').on('click', function() {
      let card = $(this).attr('data-card');
      $('#' + card + '-card-body').toggle();
      if ($('#' + card + '-card-body').is(':visible')) {
        $('#' + card + '-caret').html(`<i class="fa fa-caret-down"></i>`);
        localStorage.setItem("<?= INSTANCE ?>" + card, "true");
      } else {
        $('#' + card + '-caret').html(`<i class="fa fa-caret-right"></i>`);
        localStorage.setItem("<?= INSTANCE ?>" + card, "false");
      }

    });
    // Toggle menu
    $('#menuToggle').on('click', function() {
      $('body').toggleClass('open');
      $(".dropdown-toggle").dropdown('toggle');

    });

    $('.search-trigger').on('click', function() {
      $('.search-trigger').parent('.header-left').addClass('open');
    });

    $('.search-close').on('click', function() {
      $('.search-trigger').parent('.header-left').removeClass('open');
    });

    $('.paginate').DataTable({
      "pageLength": 25,
      "stateSave": true,
      "aLengthMenu": [
        [25, 50, 100, -1],
        [25, 50, 100, 250, 500]
      ],
      "aaSorting": []
    });
  });
</script>