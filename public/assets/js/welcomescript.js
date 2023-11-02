$(document).ready(function () {
  AOS.init();
  $('a[href^="#"]').on("click", function (e) {
    var target = this.hash,
      $target = $(target);

    $("html, body")
      .stop()
      .animate(
        {
          scrollTop: $target.offset().top - 50,
        },
        500,
        "swing",
        function () {
          window.location.hash = target;
        }
      );
  });
});

$(document).ready(function() {
    $("#subscribe_form").validate({
        rules: {
            email: {
                required: true,
                email: true,
            },
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});