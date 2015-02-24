<?php
/**
 * @package		Joomla Bamboo Zen Grid Framework
 * @version		v1.0
 * @author		Joomal Bamboo http://www.joomlabamboo.com
 * @copyright 	Copyright (C) 2007 - 2010 Joomla Bamboo
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * The Zen Grid Framework is a templating framework that uses the Joomla Content Manament System (http://www.joomla.org)
 * This file is called if the banner layout override is enabled and is placed in the templates/[your template name]/layout folder. 
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted index access' );
?>

<!-- Banner Wrapper -->
<div class="outerWrapper bannerRow">
		<div class="container <?php echo $position ?>" style="width:<?php echo $tWidth ?>px;<?php echo $containerOffset?>">
				<div class="containerBG">
						<div class="innerContainer" style="width:<?php echo $contentWidth ?>px;margin-left:<?php echo $gutter ?>px">
																
								
								<div id="banner" style="width:100%">
										<jdoc:include type="modules" name="banner" style="xhtml" />
								</div> 								
							
																
						</div>
				</div>
		</div>
</div>
<!-- Banner Wrapper -->