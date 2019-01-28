<?
/////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////// functions pdf/////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////	
require_once ("../lib/fpdf17/fpdf.php");	
			
class PDF extends FPDF{
 	  var $widths;
      var $aligns;
	  var $fields = array();
	  var $header_cell_width = array();
	  
	  // Page header
	  function Header(){
		  $connect = new InfoSystem;
		  // Logo
		  $this->Image('../images/brasao.jpg',5,5,0,13,'','');
		  $this->SetFont('Arial','',9);
		  // Arial bold 15
		  $this->Cell(8,4,"",0,0);
		  $this->Cell(150,4,InfoSystem::titulo ,0,0);
		  $this->SetFont('Arial','',9);
		  // Move to the right
 		  $this->SetFont('Courier','',9); 
          $this->Cell(100,4,'Relatório emitido em: '.date("d/m/Y")." às ".date("H:i")."h",0,1,'R');		    
		  //Segunda Linha
		  $this->Cell(8,4,"",0,0);
		  $this->Cell(250,4,InfoSystem::subtitulo,0,1);  
		  
		  $this->SetFont('Arial','',10);
		  $this->SetFillColor(15,80,112);
		  $this->SetTextColor(255);
		  $this->SetDrawColor(255,255,255);
		  $this->SetLineWidth(.3);
		  $this->SetFont('','B');
		  // Header
		 
		  for($i=0;$i<count($this->fields);$i++){
			  $this->Cell($this->header_cell_width[$i],5,$this->fields[$i],1,0,'C',true);	
		  }
		  $this->Ln();
		  // Color and font restoration
		  $this->SetFillColor(224,235,255);
		  $this->SetTextColor(0);
		  $this->SetFont('');		  

		  $this->Ln(2);       
		  //Line break
	  }
	  
	  function SetField($array){
	  	$this -> fields = $array;
	  }
	  
	  function SetHeaderCell($array){
	  	$this -> header_cell_width = $array;
	  }
	    	  
	  // Page footer
	  function Footer(){
		  // Position at 1.5 cm from bottom
		  $this->SetY(-15);
		  // Arial italic 8
		  $this->SetFont('Arial','I',8);
		  $this->SetTextColor(128);
		  // Page number
		  $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	  }
	  
	  function SetWidths($w){
		 //Set the array of column widths
		 $this->widths=$w;
	   }
	  
	   function SetAligns($a){
		 //Set the array of column alignments
		 $this->aligns=$a;
	   }
	  
	   function Row($data,$fill){
		 //Calculate the height of the row
		 $nb=0;
		 for($i=0;$i< count($data);$i++)
			 $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
		 $h=3*$nb;
		 //Issue a page break first if needed
		 $this->CheckPageBreak($h);
		 //Draw the cells of the row
		 for($i=0;$i< count($data);$i++){
			 $w=$this->widths[$i];
			 $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
			 //Save the current position
			 $x=$this->GetX();
			 $y=$this->GetY();
			 //Draw the border
			 $this->Rect($x,$y,$w,$h,$fill);
			 //Print the text
			 $this->MultiCell($w,3,$data[$i],0,$a,$fill);
			 //Put the position to the right of the cell
			 $this->SetXY($x+$w,$y);
		 }
		 //Go to the next line
		 $this->Ln($h-2);
	   }
	  
	   function CheckPageBreak($h){
		 //If the height h would cause an overflow, add a new page immediately
		 if($this->GetY()+$h>$this->PageBreakTrigger)
			 $this->AddPage($this->CurOrientation);
	   }
	  
	   function NbLines($w,$txt){
		 //Computes the number of lines a MultiCell of width w will take
		 $cw=&$this->CurrentFont['cw'];
		 if($w==0)
			 $w=$this->w-$this->rMargin-$this->x;
		 $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
		 $s=str_replace("\r",'',$txt);
		 $nb=strlen($s);
		 if($nb>0 and $s[$nb-1]=="\n")
			 $nb--;
		 $sep=-1;
		 $i=0;
		 $j=0;
		 $l=0;
		 $nl=1;
		 while($i<$nb){
			 $c=$s[$i];
			 if($c=="\n"){
				 $i++;
				 $sep=-1;
				 $j=$i;
				 $l=0;
				 $nl++;
				 continue;
			 }
			 if($c==' ')
				 $sep=$i;
			 $l+=$cw[$c];
			 if($l>$wmax){
				 if($sep==-1){
					 if($i==$j)
						 $i++;
				 }else{
					 $i=$sep+1;
				 }
				 $sep=-1;
				 $j=$i;
				 $l=0;
				 $nl++;
			 }else{
				 $i++;
			 }
		 }
		 return $nl;
	   }



	  
	  // Colored table

	  function FancyTable($data,$header,$cell_width){
		  // Colors, line width and bold font
		  
		  $this->SetFont('Arial','',10);
		 // $this->SetFillColor(15,80,112);
		 // $this->SetTextColor(255);
		  $this->SetDrawColor(255,255,255);
		  $this->SetLineWidth(.3);
		 // $this->SetFont('','B');
		  // Header
		 
		 
		 // for($i=0;$i<count($header);$i++){
			  //$this->Cell($cell_width[$i],5,$header[$i],1,0,'C',true);			 
		//  }
		  
		 // $this->Ln();
		  // Color and font restoration
		  $this->SetFillColor(224,235,255);
		  $this->SetTextColor(0);
		  $this->SetFont('');
		  // Data
		  $fill = false;
		  $this->SetFont('Times','',8);		  
		  
		  $this->SetWidths($cell_width);//CADA VALOR DESTE ARRAY SERÁ A LARGURA DE CADA COLUNA
		  srand(microtime()*1000000);		  
		 
		  foreach($data as $row){
			 // for ($x=0;$x<count($header);$x++){				  
			   //	$this->Cell($cell_width,6,$row[$x],0,0,'L',$fill);					
		  	 // }
			  $this->Row($row,$fill);
			  $this->Ln();
			  $fill = !$fill;
		  }
		 
		  // Closing line
		  @$this->Cell(array_sum($w),0,'','T');
	  }
}
		 

/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////



?>