## PLUGINS PARA ENVIAR EMAIL

### Obs: vocé precisa instalar e configurar o plugin `SMTP Mailer`

### Modelo HTML
```HTML
<style>
  #container-form-email {
    background-color: #392466;
    padding: 16px 32px;
    border-radius: 16px;
  }

  #container-form-email button {
    background: #ff3352;
    color: #ffffff;
  }
</style>

<div id="container-form-email" class="m-5">
  <h2 class="text-center font-weight-bold">Entre em contato conosco</h2>
  <form id="formHomeEmail">
    <div class="form-row">
      <div class="form-group col-md-12">
        <input type="text" name="nome" class="form-control jaml-form-control jaml-form-valid jaml-form-text" placeholder="Seu nome" />
        <small class="form-text text-danger d-none">Nome obrigatório</small>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-6">
        <input type="text" name="telefone" class="form-control jaml-form-control jaml-form-valid jaml-form-phone" placeholder="Seu Telefone" />
        <small class="form-text text-danger d-none">Telefone obrigatório. Somente números</small>
      </div>

      <div class="form-group col-md-6">
        <input type="text" name="email" class="form-control jaml-form-control jaml-form-valid jaml-form-email" placeholder="Seu Email" />
        <small class="form-text text-danger d-none">E-mail obrigatório e/ou inválido</small>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-6">
        <input type="text" name="estado" class="form-control jaml-form-control jaml-form-valid jaml-form-text" placeholder="Seu Estado" />
        <small class="form-text text-danger d-none">Estado obrigatório</small>
      </div>

      <div class="form-group col-md-6">
        <input type="text" name="cidade" class="form-control jaml-form-control jaml-form-valid jaml-form-text" placeholder="Sua cidade" />
        <small class="form-text text-danger d-none">Cidade obrigatória</small>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-12">
        <textarea name="mensagem" class="form-control jaml-form-control jaml-form-valid jaml-form-text" placeholder="Sua Mensagem"></textarea>
        <small class="form-text text-danger d-none">Messagem obrigatória</small>
      </div>
    </div>
    <p id="textEmailMessage" class="text-center">&nbsp;</p>
    <button type="submit" class="btn mb-3 py-2 btn-block font-weight-bold">Enviar</button>
  </form>
</div>

<script>
  jQuery(document).ready(function ($) {
    /*
    textEmailMessage: "#textEmailMessage",
    borderEmailDefault: "#ccc",
    backgroundEmailDefault: "#FFF",
    colorEmailError: "#dc3545",
    backgroundEmailErrorColor: "#fbeaec",
		messageEmailSuccess: "Email enviado com sucesso",
		toMail: "matraca.suporte@gmail.com",
		host: "Portal Matraca",
       */
    $("#formHomeEmail").JAMLSendEmail();
  });
</script>
```
