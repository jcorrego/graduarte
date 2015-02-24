<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted index access' );
?>

<div class="outerWrapper footerRow">
		<div class="container <?php echo $position ?>" style="width:<?php echo $tWidth ?>px;<?php echo $containerOffset?>">
			<div class="containerBG  width<?php echo $tWidth ?>">
				<div class="innerContainer" style="width:<?php echo $contentWidth ?>px;margin-left:<?php echo $gutter ?>px">
					
					
					
					<div id="footer" class="<?php echo $backgroundContrast ?>">
							<div id="footerLeft" style="width:<?php echo $nine; ?>px;margin-right: <?php echo $gutter ?>px">
									<jdoc:include type="modules" name="footer" style="xhtml" />
							</div>
									
							<!-- Copyright -->				
<div id="footerRight">
				<a href="http://www.joomlabamboo.com"><img class="jbLogo" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/jb<?php echo $backgroundContrast ?>.png" alt="Joomla Bamboo" /></a><div style="display:none"><a href="http://uniq-themes.ru/">joomla templates</a></div>
</div>			
					</div>
					
						
	
					</div> <!-- innerContainer -->
				</div>	<!-- containerBG -->					
		</div> <!-- Container -->
</div>
