<?php
session_start();

  //Tratamentos para não utilização de cache
  header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
                                                       // always modified
  header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");    // Date in the past
  header("Cache-Control: no-store, no-cache, must-revalidate");  // HTTP/1.1
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");                          // HTTP/1.0


  session_unregister("login");
  session_unregister("senha");
  session_unregister("nivel_permissao_usuario");
  session_unregister("cod_grupo_usuario");
  session_unregister("nome_usuario");
  session_unregister("listfield_vetor"); 
  session_unregister("activate_filtro"); 
  session_unregister("hidefield_vetor"); 
  session_destroy();
  session_unset();
  //unset($NomeUsuario);
  //unset($NivelUsuario);
  //unset($EmailUsuario);
  if( !isset($NomeUsuario) )
  {
      ?>
          <html>
          <head>
          </head>
            <!--<body topmargin="0" onLoad="initiate()"  style="width:100%;overflow-x:hidden;overflow-y:hidden">  -->
            <body topmargin="0">
            <form action="index.php" name="frm_login" method="post">
              <table width="100%" height="100%"><tr><td align="center" valign="middle">
              <table border="0" cellpading="0" cellspacing="0" align="center" width="100%">
                <tr>
                  <td align="center" colspan="2">
                    <div align="center" class="essg"><b><i>Você foi desconectado com sucesso!</i></b></div>
                  </td>
                </tr>
              </table>

              <table border="0" cellpading="0" cellspacing="0" width="480 " align="center">
                <tr>
                  <td align="center" colspan="2">
                    <div align="center" class="essg"><b><i>Para se conectar <a href="../index.php" class="link" target="_parent">CLIQUE AQUI...</a></i></b></div>
                  </td>
                </tr>
              </table></td></tr></table>
            </form>
            </body>
          </html>
      <?php
  }


?>
