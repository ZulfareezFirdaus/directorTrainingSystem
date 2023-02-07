<?php                
    session_start();
    include("./system/dbconn.php");
    include('./tcpdf_6_2_13/tcpdf/tcpdf.php');
    mysqli_select_db($dbconn_directorTraining, 'directorTraining');

$action_ID = $_POST['actions'];
echo $_POST['ID_director'];

$inv_mst_query = "SELECT director.*, organiser.*, TrainingProgram.* FROM TrainingProgram
    INNER JOIN director ON director.ID_director = TrainingProgram.ID_director
    INNER JOIN organiser ON organiser.ID_organiser = TrainingProgram.ID_organiser
    WHERE director.ID_director = '".$_POST['ID_director']."' 
    ORDER BY TrainingProgram.StartDate_trainingProgram ASC ";

$inv_mst_results = mysqli_query($dbconn_directorTraining,$inv_mst_query);   
$count = mysqli_num_rows($inv_mst_results);  
if($count>0) 
{
	//----- Code for generate pdf
	$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->SetCreator(PDF_CREATOR);  
	//$pdf->SetTitle("Export HTML Table data to PDF using TCPDF in PHP");  
	$pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
	$pdf->SetDefaultMonospacedFont('helvetica');  
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
	$pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
	$pdf->setPrintHeader(false);  
	$pdf->setPrintFooter(false);  
	$pdf->SetAutoPageBreak(TRUE, 10);  
	$pdf->SetFont('helvetica', '', 12);  
	$pdf->AddPage(); //default A4
	//$pdf->AddPage('P','A5'); //when you require custome page size 
	
	$content = ''; 

	$content .= '
	<style type="text/css">
        table{
            font-size:10px;
            font-family: "Gothic A1", sans-serif;
            color:black;
            letter-spacing:0.5px;
            text-align: justify;
  text-justify: inter-word;
            
        }
        
        .height{
            line-height: 20.5px !important;
        }
        
        .bg-color{
            background-color:grey !important;
        }
        
        .padding{
            margin-bottom:20px !important;
        }
	</style> 
    
	<table cellpadding="0" cellspacing="0" style="width:100%;">
        <table style="width:100%;" >
            <tr >
                <td colspan="5" align="center"><img width="110px" src="../../../system/images/pnb.png"></td>
            </tr>
	       <tr><td colspan="5">&nbsp;</td></tr>
            <tr class="height bg-color padding" >
                <td colspan="5" align="center"><b >ACKNOWLEDGEMENT RECEIPT FORM</b></td>
            </tr>
            <tr>
                <td colspan="5"></td>
            </tr>
            <tr>
                <td align="left" width="60px">&nbsp;&nbsp;To</td>
                <td align="center" width="60px">:</td>
                <td align="left" width="530px">Head, Company Secretary Department<br>Permodalan Nasional Berhad</td>
            </tr>
            <tr>
                <td colspan="5"></td>
            </tr>
            <tr>
                <td align="left" width="60px">&nbsp;&nbsp;From</td>
                <td align="center" width="60px">:</td>
                <td align="left" width="220px">'.ucwords($inv_mst_data_row['name_owner']).'</td>
                <td align="left" width="40px">Date :</td>
                <td align="left" width="110px">'.$dateAssign.'</td>
            </tr>
            <tr>
                <td colspan="5"></td>
            </tr>
            <tr>
                <td align="left" width="60px"><b>&nbsp;&nbsp;RE</b></td>
                <td align="center" width="60px">:</td>
                <td align="left" width="530px"><b>ACKNOWLEDGEMENT OF RECEIPT - IPAD</b></td>
            </tr>
            <tr>
                <td colspan="5"></td>
            </tr>
            <tr>
                <td colspan="5" width="510px"><hr></td>
            </tr>
            
            <tr>
                <td align="left" width="50px">&nbsp;&nbsp;1.</td>
                <td align="left" width="460px"><p style="text-align: justify;text-justify: inter-word;" >I hereby acknowledge that I have received the following device and its accessories in good condition:</p></td>
            </tr>
            <tr>
                <td colspan="5"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <table width="495px" >
                        <tr>
                            <th align="center" colspan="3" style="border: 0.5px solid black;" ><b>Hardware Profile</b></th>
                            <th align="center" style="border: 0.5px solid black;" ><b>Serial No</b></th>
                            <th align="center" style="border: 0.5px solid black;"><b>PNB Tag No</b></th>
                        </tr>
                        <tr>
                            <td align="center" width="20px" style="border: 0.5px solid black;" >a.</td>
                            <td align="left" style="border: 0.5px solid black;" width="76px">Device</td>
                            <td align="left" style="border: 0.5px solid black;" width="201px" >One (1) '.ucwords($inv_mst_data_row['assetType_ipad']).'</td>
                            <td rowspan="2" align="center" style="border: 0.5px solid black;" ><div style="line-height:60px;">'.strtoupper($inv_mst_data_row['serialNo_ipad']).'</div></td>
                            <td rowspan="2" align="center" style="border: 0.5px solid black;" ><div style="line-height:60px;">700'.ucwords($inv_mst_data_row['rfidno_ipad']).'0000</div></td>
                        </tr>
                        <tr>
                            <td align="center" style="border: 0.5px solid black;" >b.</td>
                            <td align="left" style="border: 0.5px solid black;" >Model</td>
                            <td align="left" style="border: 0.5px solid black;" >'.ucwords($inv_mst_data_row['modelType_ipad']).'</td>
                        </tr>
                        <tr>
                            <td align="center" style="border: 0.5px solid black;" >b.</td>
                            <td align="left" style="border: 0.5px solid black;" >Accessories</td>
                            <td colspan="3" align="left" style="border: 0.5px solid black;" >'.$box.'<br>'.$cable.'<br>'.$adapter.'<br>'.$casing.'<br>'.$sim.'</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="left" width="40px">&nbsp;&nbsp;</td>
                <td align="left" width="490px">(collectively, the “Assets”)	</td>
            </tr>
            <tr>
                <td colspan="5"></td>
            </tr>
            <tr>
                <td align="left" width="50px">&nbsp;&nbsp;2.</td>
                <td align="left" width="460px" ><p style="text-align: justify;text-justify: inter-word;" >I understand that the Assets are loaned to me and are the property of Permodalan Nasional Berhad (“PNB”).  I am expected to exercise due care in my use of the Assets and to utilize the Assets mainly <u>for BoardPac usages only</u>.</p> </td>
            </tr>
            <tr>
                <td colspan="5"></td>
            </tr>
            <tr>
                <td align="left" width="50px">&nbsp;&nbsp;3.</td>
                <td align="left" width="460px"><p style="text-align: justify;text-justify: inter-word;" >Negligence in the care and use will be considered as a cause for me to replace the Assets to PNB.  If the Assets are damaged, lost (police report would be required) or stolen (police report would be required) due to my negligence, I shall be responsible to pay back or compensate PNB based on the following:</p> </td>
            </tr>
            <tr>
                <td colspan="5"></td>
            </tr>
            <tr>
                <td width="95px"></td>
                <td colspan="2">
                    <table width="405px" >
                        <tr>
                            <th align="center" style="border: 0.5px solid black;" width="25px"><b>No</b></th>
                            <th align="center" style="border: 0.5px solid black;" ><b>Incident</b></th>
                            <th align="center" style="border: 0.5px solid black;" width="195px"><b>Amount to be compensated</b></th>
                        </tr>
                        <tr>
                            <td align="center" style="border: 0.5px solid black;" >1</td>
                            <td align="left" style="border: 0.5px solid black;" >First incident</td>
                            <td align="left" style="border: 0.5px solid black;" >50% of the net book value*</td>
                        </tr>
                        <tr>
                            <td align="center" style="border: 0.5px solid black;" >2</td>
                            <td align="left" style="border: 0.5px solid black;" >Second incident</td>
                            <td align="left" style="border: 0.5px solid black;" >50% of the net book value*</td>
                        </tr>
                        <tr>
                            <td align="center" style="border: 0.5px solid black;" >3</td>
                            <td align="left" style="border: 0.5px solid black;" >Third incident</td>
                            <td align="left" style="border: 0.5px solid black;" >50% of the net book value*</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="left" width="110px">&nbsp;&nbsp;</td>
                <td align="left" width="490px"><i>* As determined at the sole discretion of PNB	</i></td>
            </tr>
            <tr>
                <td colspan="5"></td>
            </tr>
            <tr>
                <td align="left" width="50px">&nbsp;&nbsp;4.</td>
                <td align="left" width="460px"><p style="text-align: justify;text-justify: inter-word;" >I also understand that the Assets must be returned to the Company Secretary Department of PNB, following my resignation/retirement or when it is requested in writing by the Company Secretary Department for whatever reason(s).  If the Assets are not returned, I shall be responsible to pay back or compensate PNB at 100% of the net book value of the Assets, as determined at the sole discretion of PNB.</p> </td>
            </tr>
            <tr>
                <td colspan="5"></td>
            </tr>
            <tr>
                <td colspan="5"></td>
            </tr>
            <tr>
                <td colspan="5"></td>
            </tr>
            <tr>
                <td align="left" width="100px">&nbsp;&nbsp;Signature</td>
                <td align="left" width="150px">:<hr> </td>
            </tr>
            <tr>
                <td colspan="5"></td>
            </tr>
            <tr>
                <td align="left" width="100px">&nbsp;&nbsp;Name</td>
                <td align="left" width="260px">: '.ucwords($inv_mst_data_row['name_owner']).' </td>
            </tr>
            <tr>
                <td colspan="5"></td>
            </tr>
            <tr>
                <td colspan="5"></td>
            </tr>
            <tr>
                <td align="left" width="100px">&nbsp;&nbsp;Date</td>
                <td align="left" width="260px">:  </td>
            </tr>
            
        </table>
    </table>'; 
    
$pdf->writeHTML($content);

$file_location = "/home/fbi1glfa0j7p/public_html/examples/generate_pdf/uploads/"; //add your full path of your server
//$file_location = "/opt/lampp/htdocs/examples/generate_pdf/uploads/"; //for local xampp server

$datetime=date('dmY_hms');
$file_name = "acknowledgement_Receipt_".ucwords($inv_mst_data_row['name_owner']).".pdf";
ob_end_clean();

if($_POST['ACTION']=='VIEW') 
{
	$pdf->Output($file_name, 'I'); // I means Inline view
} 
else if($_POST['ACTION']=='DOWNLOAD')
{
	$pdf->Output($file_name, 'D'); // D means download
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
else if($_POST['ACTION']=='UPLOAD')
{
$pdf->Output($file_location.$file_name, 'F'); // F means upload PDF file on some folder
echo "Upload successfully!!";
}

//----- End Code for generate pdf
	
}
else
{
	echo 'Record not found for PDF.';
}

?>