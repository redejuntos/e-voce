
<table style="margin:10px 10px 0 10px;">
  <tr >
    <td   ><div align="right" style="width:50px;">Login </div></td>
    <td colspan="5"><input name="login" type="text" class="x-form-text x-form-field" id="login" style="width:200px;" value=""  maxlength="20"   />
      &nbsp;&nbsp;Nível de Acesso &nbsp;
      <?= grupo_options(''); ?>
      &nbsp;&nbsp;</td>
  </tr>
  <tr nowrap="nowrap">
    <td nowrap="nowrap"   ><div align="right">Nome</div></td>
    <td colspan="5" nowrap="nowrap" style="width:100%;"><input name="nome_usuario" type="text" class="x-form-text x-form-field" id="nome_usuario" style="width:100%;"  maxlength="80"  /></td>
  </tr>
  <tr nowrap="nowrap">
    <td nowrap="nowrap"   ><div align="right">E-mail</div></td>
    <td colspan="5" nowrap="nowrap"><input name="email" type='text' maxlength="80" style='width:100%;text-transform:lowercase;width:100%; '   class="x-form-field" onblur="check_mail(this.name);" autocomplete="off"></td>
  </tr>
  <tr nowrap="nowrap">
    <td nowrap="nowrap"   ><div align="right">Senha</div></td>
    <td colspan="5" nowrap="nowrap"><input name="senha" type='password' value='' maxlength="32" class='x-form-field' style='width:200px;' id="senha" autocomplete="off">
      &nbsp; Confirmar Senha
      <input name="confirmar_senha" type='password' value='' maxlength="32" class="x-form-text x-form-field" id="confirmar_senha" style="width:200px;"    /></td>
  </tr>

