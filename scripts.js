$( document ).ready(function() {
    $(document).on('click', '.btnSend',function(e){
        e.preventDefault();
        $(".info-message").html("");
        var errorStatus = false;
        var nameInput = $("#name");
        var emailInput = $("#email");
        var messageInput = $("#message");
        $(".error").removeClass("error");

        if(nameInput.val() == "" || nameInput.val().length < 3) {
            errorStatus = true;
            nameInput.addClass("error");
        } else errorStatus = false;

        if(!isValidEmailAddress(emailInput.val())) {
            errorStatus = true;
            emailInput.addClass("error");
        } else errorStatus = false;

        if(messageInput.val() == "" || messageInput.val().length < 3) {
            errorStatus = true;
            messageInput.addClass("error");
        } else errorStatus = false;

        if(errorStatus) {
            $(".error-message").html("Please, fill in all required fields.");
        }

        if(!errorStatus) {
            $(".info-message").html("");

            jQuery.ajax({
                type: "POST",
                url: "php/mail.php",
                data: $("#contactForm").serialize(),
                success: function(resp) {
                    nameInput.val("");
                    emailInput.val("");
                    messageInput.val("");

                    $(".info-message").html(resp);
                }
            });
        }
    });

});

function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
};
