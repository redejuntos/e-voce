<?php
session_start();

echo '<script src="../js/dropdown.js" type="text/javascript"></script>';

if ($sql_order){
$sql.=$sql_order;
}


  
$query = return_query($sql);
$query1 = return_query($sql);

echo mysql_error();

$num_row = numrows($sql);




//exit($num_row);
?>

      <form method="post" name="textOrdenationForm" action="<?=$action?>">
      <input type="hidden" name="Valor" value="">
      <input type="hidden" name="bloco" value="<?=$bloco?>">
    
                <table border="0" align="center" cellpadding="0" celsspacing="0" cellspacing="0" id="ordenar_anexo"  style="display:none;" >
                      <tr>
                        <td>
                          <select name="ordenacao" size="12" style="width:350px;background-color:#FFF" width="350px"  multiple>
                        <?
							$x=1;
                          while ($rs = mysql_fetch_array($query)){
                            echo "<option value=\"".$rs["$campo_value"]."\">$x - $rs[$campo_name]</option>\n";
							$x++;
                          }?>
                          </select>

                        <?
                          while ($rs1 = mysql_fetch_array($query1)){
                            echo"<input type=\"hidden\" name=\"ordenations\" value=\"\">\n";
                          }?>

                        </td>
                        <td valign="top">
                          <table border="0">
                            <tr>
                              <td> <a href="javascript:cima();"> <img src="../images/bt_cima.gif" border="0" alt="Mover para cima" title="Mover para cima" width="16" height="16">
                                </a> </td>
                            </tr>
                            <tr>
                              <td> <a href="javascript:baixo();"> <img src="../images/bt_baixo.gif" border="0" alt="Mover para baixo" title="Mover para baixo" width="16" height="16" onClick="">
                                </a> </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
					  <tr><td> 
					    <div align="right">
					      <input type="button" style="float:right;"  value="Ordenar" onClick="javascript:ordena();"  class="botao" onMouseOver="this.className='botao_hover'" onMouseOut="this.className='botao'" >
				        </div></td><td></td></tr>
                    </table>
             
   
        
                   
                         
                       
   
      </form>

