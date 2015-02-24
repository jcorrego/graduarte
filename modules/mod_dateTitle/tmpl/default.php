<?php // no direct access
defined('_JEXEC') or die('Restricted access');
global $mainframe;
$document =& JFactory::getDocument();
$date = $params->get( 'dateFormat', "1" );

// Date Variables
if ($date=="0") {
      $dateFormat="<span class='dtDay'>%d</span> <span class='dtMonth'>%b</span>, <span class='dtYear'>%y</span>";
}
elseif ($date=="1") {
      $dateFormat="<span class='dtMonth'>%b</span> <span class='dtDay'>%d</span>, <span class='dtYear'>%y</span>";
}
elseif ($date=="2") {
      $dateFormat="<span class='dtMonth'>%B</span> <span class='dtDay'>%d</span>, <span class='dtYear'>%y</span>";
}
elseif ($date=="3") {
      $dateFormat="<span class='dtDay'>%d</span> <span class='dtMonth'>%B</span>, <span class='dtYear'>%y</span>";
}
elseif ($date=="4") {
      $dateFormat="<span class='dtMonth'>%B</span> <span class='dtDay'>%d</span>, <span class='dtYear'>%Y</span>";
}
elseif ($date=="5") {
      $dateFormat="<span class='dtDay'>%d</span> <span class='dtMonth'>%B</span>, <span class='dtYear'>%Y</span>";
}
elseif ($date=="6") {
      $dateFormat="<span class='dtDay'>%d</span>/<span class='dtMonth'>%m</span>/<span class='dtYear'>%y</span>";
}
elseif ($date=="7") {
      $dateFormat="<span class='dtDayName'>%A</span> <span class='dtDay'>%d</span> <span class='dtMonth'>%B</span>, <span class='dtYear'>%Y</span>";
}
elseif ($date=="8") {
      $dateFormat="<span class='dtDayName'>%a</span> <span class='dtDay'>%d</span> <span class='dtMonth'>%b</span>, <span class='dtYear'>%y</span>";
}
elseif ($date=="9") {
      $dateFormat="<span class='dtMonth'>%b</span> <span class='dtDay'>%d</span> ";
}
elseif ($date=="10") {
      $dateFormat="<span class='dtDay'>%d</span> <span class='dtMonth'>%b</span>";
}


 ?>
<div class="dateTitle">

<?php foreach ($list as $item) :  ?>
	<span class="dateTitleDate small"><?php echo JHTML::Date($item->date, "$dateFormat"); ?></span>
	
	<span class="dateTitleSpan">
		<a href="<?php echo $item->link; ?>">
			<?php echo $item->text; ?></a>
	</span>
	<div class="dateTitleClear"></div>
<?php endforeach; ?>

</div>