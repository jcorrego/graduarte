	

<?php

  require_once('pclzip.lib.php');
  $archive = new PclZip('JB_Grid2_Quickstart_J1.5.18_v1.0.2.zip');
  if ($archive->extract() == 0) {
    die("Error : ".$archive->errorInfo(true));
  }

?> 	

