const identifiant = document.querySelector("form #identifiant"),
email = document.querySelector("form #mail"),
counter_id = document.querySelector("form .chiffre_id"),
counter_mail = document.querySelector("form .chiffre_mail"),
maxLength_id = identifiant.getAttribute("maxlength"),
maxLength_email = email.getAttribute("maxlength");

identifiant.onkeyup = () => {
    counter_id.innerText = maxLength_id - identifiant.value.length;  
}
email.onkeyup = () => {
    counter_mail.innerText = maxLength_email - email.value.length;  
}

$(document).ready(function() {
    $('#fetchval').on('change', function() {
        var value = $(this).val();
        //alert(value);
        $.ajax({
            url: 'filtre.php',
            type: 'POST',
            data: 'request=' + value,
            beforeSend:function() {
                $(".list-produit").html("<span> En cours... </span>");
            },
            success: function(data) {
                $(".list-produit").html(data);
            }
        });
    });
});