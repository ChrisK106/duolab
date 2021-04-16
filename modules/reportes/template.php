<?php

require '../../plugins/fpdf/fpdf.php';

class PDF extends FPDF
{
	var $headerTitle="";

	function SetHeaderTitle($title)
    {
        $this->headerTitle = $title;
    }

    function HeaderTitle()
    {
    	return $this->headerTitle;
    }

	function Header()
	{
		$this->Image('../../img/duolabgroup_logo.png', 5, 5, 22);
		$this->SetFont('Arial','B',14);
		//$this->Cell(30);
		$this->Cell(0,10, $this->HeaderTitle(), 0,0,'C');
		$this->Ln(20);
	}
	
	function Footer()
	{
		$this->SetY(-15);
		$this->SetFont('Arial','I', 8);
		$this->Cell(0,10, utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
	}		
}