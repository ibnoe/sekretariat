<link rel="stylesheet" type="text/css" href="style.css">
<script language="JavaScript" src="inc/Calendar/calendar_db.js"></script>
	<link rel="stylesheet" href="inc/Calendar/calendar.css">
<?php


global $key,$key_word;
 if (isset($_REQUEST['act'])){
    if ($_REQUEST['act']=="new"){
       $key   = "";
       $page = 1;
    }else{
       $key   = $_REQUEST['key'];
       $page  = $_REQUEST['page'];
	}
}else{
    $key   = "";
    $page = 1;
}
include('include/classpaging.php');
$sql = "SELECT * FROM dokumen";

	if($key!=''){
		$sql .= " AND (nama_dokumen like '%$key%')";
		
	}
	
	
	$sql .=" order by dokumen_id DESC";

	$link = 'index.php?_mod=sekretariat&task=admin_dokumen&act=go&key='.$key;
	//echo $sql;
	$row_perpage=10;
	$jml=mysql_num_rows(mysql_query($sql));
	$pager = new PS_Pagination($conn,$sql,$row_perpage,5,$link);
	$rs = $pager->paginate();
//echo "Cari Dokumen >> </br></br>";


$send_url = "index.php?_mod=$_mod&task=admin_surat";
?>

<div class="content-non-title">
    <form action="index.php" method="get" name="form">
        <div class="row-fluid">
            <div class="span24">
                <fieldset>
                    <div class="nav nav-tabs">
                        <h3> Daftar Dokumen yang Diproses</h3>
                    </div>

                    <div class="control-group">
                        <label class="control-label span4">Nama Dokumen</label>
                        <div class="controls span17">
                            <input type="text" name="key" value="" size="35"/>
                        </div>
                    </div>

<!--                    <div class="control-group">-->
<!--                        <label class="control-label span7">Tanggal Terima</label>-->
<!--                        <div class="controls span17">-->
<!--                            <input type="text" id="date" name="tgl_terima" value="" size="10"/>-->
<!--                            <script language="JavaScript">-->
<!--                                $(function(){-->
<!--                                    $('#date').datepicker({-->
<!--                                        inline:true,-->
<!--                                        showOtherMonths: true,-->
<!--                                        altField: "#date",-->
<!--                                        altFormat: "yy-mm-dd",-->
<!--                                        dateFormat: "yy-mm-dd",-->
<!--//                                changeMonth: true,-->
<!--//                                changeYear: true,-->
<!--                                        onSelect: function(dateText){-->
<!--                                            $('#date').html(dateText);-->
<!--                                        }-->
<!--                                    });-->
<!--                                });-->
<!--                            </script>-->
<!--                        </div>-->
<!--                    </div>-->

                    <div class="control-group">
                        <label class="control-label span4"></label>
                        <div class="controls span17">
                            <input class="btn btn-primary" type="submit" name="submit" value="Proses"/>
                        </div>
                    </div>



                </fieldset>
            </div>

        </div>

        <!--<div class="form-actions">-->

        <input type="hidden" name="act" value="go">
        <input type="hidden" name="page" value="1">
        <!--</div>-->

    </form>
</div>
<hr>
<!--<table border=0 width="100%" style="border:1px solid #cccccc"><tr><td>-->
<!--<form action="--><?php //echo $send_url;?><!--" method="post" name="form">-->
<!--	<table>-->
<!--		   <tr><td width="150px">Nama Dokumen</td><td><input type="text" name="key" value="" size="35"/></td></tr>-->
<!--			<tr><td><input class="button" type="submit" name="submit" value="Proses"/></td></tr>-->
<!--			<input type="hidden" name="act" value="go">-->
<!--			<input type="hidden" name="page" value="1">-->
<!--	</table>-->
<!--</form>-->
<!--</td></tr>-->
<!--</table>-->
<?php
extract($_POST);
?>

<!--<h2 align="center">DAFTAR DOKUMEN YANG DIPROSES</h2>-->
<?php

echo "<table border=0 width=100%>";
	echo "<td><input class='btn btn-primary' type=button onClick=\"location.href='index.php?_mod=sekretariat&task=input_dokumen&act=new'\" value='Tambah Dokumen'> </td><td align=right>";
	if ($jml!=0){
	//echo "Page ";
	echo $pager->renderFullNav();	}
	echo "</td></tr>";
	echo "</table>";	
	?>
 <table class=table cellpadding=2 cellspacing=1  width=100%>
	<tr class=\"bodystyle\" bgcolor='#757575' align=center height="3">
        <td class="table-menu" align="center" valign="top" width="2%"><b>No</b></td>
        <td class="table-menu" align="center" valign="top" width="10%"><b>Tanggal</b></td>
        <td class="table-menu" align="center" valign="top" width="20%"><b>Nama Dokumen</b></td>
        <td class="table-menu" align="center" valign="top" width="10%"><b>Yang Menyerahkan</b></td>
        <td class="table-menu" align="center" valign="top" width="10%"><b>Keperluan</b></td>
        <td class="table-menu" align="center" valign="top" width="10%"><b>Tujuan Dokumen</b></td>
        <td class="table-menu" align="center" valign="top" width="10%"><b>Tanggal Keluar (dari Karo)</b></td>
        <td class="table-menu" align="center" valign="top" width="5%"><b>Penerima</b></td>
        <td class="table-menu" align="center" valign="top" width="15%"><b>Ket</b></td>
        <td class="table-menu" align="center" valign="top" width="13%"><b>Aksi</b></td>
    </tr>
	<?php

	$no=$row_perpage*($page-1)+1;
	while ($row=mysql_fetch_array($rs)){
	     $tgl_msk=date("d-M-Y", strtotime($row['tgl_masuk']));
		 if ($row['tgl_keluar']==NULL){
		    $tgl_keluar="";
		 }else{
		$tgl_keluar=date("d-M-Y", strtotime($row['tgl_keluar']));
		}
		switch ($row['keperluan']) {
    case 1:
        $keperluan="Tanda Tangan Karo";
        break;
    case 2:
        $keperluan="Paraf Karo";
        break;
    case 3:
       $keperluan="Tanda Tangan & Paraf Karo";
        break;
}
		if ($row[9]==0){$bg="#99CCFF";} else {$bg="#CCCCCC";}
		if ($row[9]==0){$imgdel="images/delete_blue.gif";} else {$imgdel="images/deletegrey.gif";}
		if ($row[9]==0){$imgedit="images/ico.edit.blue.gif";} else {$imgedit="images/ico_edit_grey.gif";}
		
		echo "
		<tr bgcolor=$bg>
		    <td align=\"center\"valign=\"top\"><p>$no</p></td>
		    <td align=\"center\" valign=\"top\"><p>$tgl_msk</p></td>
		    <td align=\"left\" valign=\"top\">$row[2]</td>
		    <td valign=\"top\"><p>$row[3]</p></td>
		    <td valign=\"top\"><p>$keperluan</p></td>
		    <td valign=\"top\"><p>$row[5]</p></td>
		    <td valign=\"top\"><p>$tgl_keluar</p></td>
		    <td valign=\"top\"><p>$row[7]</p></td>
		    <td valign=\"top\"><p>$row[8]</p></td>";?>
		    <td valign="top">
                <a href="index.php?_mod=sekretariat&task=input_dokumen&act=edit&id=<?php echo $row[0];?>"><img border=0 src="<?php echo $imgedit;?>"></a>&nbsp;&nbsp;<a href="index.php?_mod=sekretariat&task=delete_dokumen&id=<?php echo $row[0];?>" onclick="return confirm('Are you sure you want to delete <?php echo $row[1];?> ?')"><img border=0 src="<?php echo $imgdel;?>"></a></td>
	    </tr>
		<?php
		$no++;
	}
	?>
</table>	
	