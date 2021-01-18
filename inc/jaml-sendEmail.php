<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_action( 'wp_footer', 'jaml_sendemail_script');

function jaml_sendemail_script() { ?>
<script type="text/javascript">
(function ($) {
  $.fn.JAMLSendEmail = function (options) {
    var settings = $.extend(
      {
        textEmailMessage: "#textEmailMessage",
        borderEmailDefault: "#ccc",
        backgroundEmailDefault: "#FFF",
        colorEmailError: "#dc3545",
        backgroundEmailErrorColor: "#fbeaec",
        messageEmailSuccess: "Email enviado com sucesso",
        messageEmailError: "Erro ao Enviar E-mail, contate o administrador!",
        toMail: "matraca.suporte@gmail.com",
        host: "Portal Matraca",
      },
      options
    );

    var JAMLFormEmail = this;

    var JAMLInputEmail = JAMLFormEmail.find(".jaml-form-control");

    JAMLInputEmail.parent("div").find(".jaml-form-phone").mask("00 000000000");
    
    var textEmailMessage = JAMLFormEmail.find(settings.textEmailMessage);

    var inputEmailError = {
      border: "1px solid " + settings.colorEmailError,
      background: settings.backgroundEmailErrorColor,
    };

    var inputEmailDefault = {
      border: "1px solid " + settings.borderEmailDefault,
      background: settings.backgroundEmailDefault,
    };

    JAMLInputEmail.css(inputEmailDefault);
    

    textEmailMessage.html("&nbsp");

    function checkEmail(inputEmail) {
      if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(inputEmail)) {
        return true;
      }
      return false;
    }

    function isEmailValidCPF(cpf) {
      if (typeof cpf !== "string") return false;
      cpf = cpf.replace(/[\s.-]*/gim, "");
      if (
        !cpf ||
        cpf.length != 11 ||
        cpf == "00000000000" ||
        cpf == "11111111111" ||
        cpf == "22222222222" ||
        cpf == "33333333333" ||
        cpf == "44444444444" ||
        cpf == "55555555555" ||
        cpf == "66666666666" ||
        cpf == "77777777777" ||
        cpf == "88888888888" ||
        cpf == "99999999999"
      ) {
        return false;
      }
      var soma = 0;
      var resto;
      for (var i = 1; i <= 9; i++) soma = soma + parseInt(cpf.substring(i - 1, i)) * (11 - i);
      resto = (soma * 10) % 11;
      if (resto == 10 || resto == 11) resto = 0;
      if (resto != parseInt(cpf.substring(9, 10))) return false;
      soma = 0;
      for (var i = 1; i <= 10; i++) soma = soma + parseInt(cpf.substring(i - 1, i)) * (12 - i);
      resto = (soma * 10) % 11;
      if (resto == 10 || resto == 11) resto = 0;
      if (resto != parseInt(cpf.substring(10, 11))) return false;
      return true;
    }

    function validateEmailForm(input) {
      JAMLInputEmail.css(inputEmailDefault);
      textEmailMessage.html("&nbsp");
      for (var i = 0; i < input.length; i++) {
        if (input.eq(i).hasClass("jaml-form-text") && input.eq(i).hasClass("jaml-form-valid") && input.eq(i).val() === "") {
          input.eq(i).css(inputEmailError);
          textEmailMessage.html(input.eq(i).siblings("small").text()).css("color", settings.colorEmailError);
          return false;
        }

        if (input.eq(i).hasClass("jaml-form-phone") && input.eq(i).hasClass("jaml-form-valid") && input.eq(i).val() === "") {
          input.eq(i).css(inputEmailError);
          textEmailMessage.html(input.eq(i).siblings("small").text()).css("color", settings.colorEmailError);
          return false;
        }

        if (input.eq(i).hasClass("jaml-form-email") && input.eq(i).hasClass("jaml-form-valid")) {
          if (!checkEmail(input.eq(i).val())) {
            input.eq(i).css(inputEmailError);
            textEmailMessage.html(input.eq(i).siblings("small").text()).css("color", settings.colorEmailError);
            return false;
          }
        }

        if (input.eq(i).hasClass("jaml-form-cpf") && input.eq(i).hasClass("jaml-form-valid")) {
          if (!isEmailValidCPF(input.eq(i).val())) {
            input.eq(i).css(inputEmailError);
            textEmailMessage.html(input.eq(i).siblings("small").text()).css("color", settings.colorEmailError);
            return false;
          }
        }
      }
      return true;
    }

    JAMLFormEmail.on("click", "button", function (e) {
      e.preventDefault();
	  var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";  

      if (validateEmailForm(JAMLInputEmail)) {
    	$.ajax(ajaxurl, {
			type: 'POST',
			data: {
				action: 'jaml_sendemail', 
				data: JAMLFormEmail.serialize(),
				toMail: settings.toMail,
				host: settings.host,				                                          
			},
			dataType: 'json',
			success: function(data) {                            
				if(data.send) {
					textEmailMessage.html('<span style="color:#198754"> ' + settings.messageEmailSuccess + "</span>");  
				}
				else {
					textEmailMessage.html(settings.messageEmailError);
				}
			},
			beforeSend: function(data) {
        JAMLInputEmail.prop( "disabled", true );
        JAMLFormEmail.find('button').prop( "disabled", true );
				textEmailMessage.html("Enviando...").css('color', '#fff');
			},
			complete: function(data) {         
				JAMLInputEmail.prop( "disabled", false );
        JAMLFormEmail.find('button').prop( "disabled", false );
        JAMLInputEmail.val('');
			}
        });
      }
    });
  };
})(jQuery);
</script>    

<?php }

function jaml_sendemail() { 
    
	sleep(2);

	$data = filter_var($_POST['data'], FILTER_SANITIZE_STRING);
    $toMail = filter_var($_POST['toMail'], FILTER_SANITIZE_STRING);
    $host = filter_var($_POST['host'], FILTER_SANITIZE_STRING);

	$arrayData = explode('&', urldecode($data));

    $html = '';

    $html .= '<table border="1" style="border-collapse: collapse">';
    for($t = 0; $t < sizeof($arrayData); $t++) {
        $temp = explode("=", $arrayData[$t]);
        $html .= '<tr>';
        $html .= '<td>  ' . $temp[0] . ' </td>';  
        $html .= '<td>  ' . $temp[1] . ' </td>';   
        $html .= '</tr>';
    }
    $html .= '</table>';

	if (!wp_mail($toMail, $host, $html, array('Content-Type: text/html; charset=UTF-8'))) {
        echo '{"send":false}';
    } else {
        echo '{"send":true}';
    }

    wp_die();
}
add_action( 'wp_ajax_nopriv_jaml_sendemail', 'jaml_sendemail' );
add_action( 'wp_ajax_jaml_sendemail', 'jaml_sendemail' );