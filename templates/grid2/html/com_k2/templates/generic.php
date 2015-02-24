<?php
/**
 * @version		$Id: generic.php 329 2010-01-15 19:39:21Z joomlaworks $
 * @package		K2
 * @author    JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2010 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

?>

<!-- Start K2 Generic Layout -->
<div class="k2generic">

	<?php if($this->params->get('show_page_title')): ?>
	<!-- Page title -->
	
		<div class="userfeedTitle">
			<span class="pagetitle"><?php echo $this->escape($this->params->get('page_title')); ?></span>
			
			<?php if($this->params->get('userFeed')): ?>
		
			<!-- RSS feed icon -->
			<div class="k2FeedIcon">
				<a href="<?php echo $this->feed; ?>" title="<?php echo JText::_('Subscribe to this RSS feed'); ?>">
					<span></span>
				</a>
				<div class="clr"></div>
			</div>
		<?php endif; ?>
		
		</div>
		
		
	
	<?php endif; ?>

	

	<?php if(count($this->items)): ?>
	<div class="catItemList">
		<?php foreach($this->items as $item): ?>

		<!-- Start K2 Item Layout -->
		<div class="catItemView">
			<div class="k2Meta">
		<div class="sectitemTitle">
			<div class="catItemHeader">
				<?php if($item->params->get('genericItemDateCreated')): ?>
				<!-- Date created -->
				<div class="k2Createdate">
					<?php echo JHTML::_('date', $item->created , JText::_('<span class="datemonth">%b</span><span class="dateday">%d</span><span class="dateyear">%Y</span>')); ?>
				</div>
				<?php endif; ?>
				
				<div class="titleWrapper <?php if (!($this->params->get('genericItemDateCreated'))) : ?>full<?php endif; ?>">
				<?php if($item->params->get('genericItemTitle')): ?>
			  <!-- Item title -->
			  <h2 class="catItemTitle">
			  	<?php if ($item->params->get('genericItemTitleLinked')): ?>
					<a href="<?php echo $item->link; ?>">
			  		<?php echo $item->title; ?>
			  	</a>
			  	<?php else: ?>
			  	<?php echo $item->title; ?>
			  	<?php endif; ?>
			  </h2>
			  <?php endif; ?>
			
	
				<?php if($item->params->get('genericItemCategory')): ?>
			<!-- Item category name -->
			<div class="catItemCategory">
				<span class="catItemCategory <?php if($item->params->get('genericItemDateCreated')): ?>dateheading<?php endif; ?>"><?php echo JText::_('Published in'); ?></span>
				<a href="<?php echo $item->category->link; ?>"><?php echo $item->category->name; ?></a>
			</div>
			<?php endif; ?>
			
			  </div>
		  </div>
</div></div>
		  <div class="catItemBody">
			  <?php if($item->params->get('genericItemImage') && !empty($item->imageGeneric)): ?>
			  <!-- Item Image -->
			  <div class="catItemImageBlock">
				  <span class="catItemImage">
				    <a href="<?php echo $item->link; ?>" title="<?php if(!empty($item->image_caption)) echo $item->image_caption; else echo $item->title; ?>">
				    	<img src="<?php echo $item->imageGeneric; ?>" alt="<?php if(!empty($item->image_caption)) echo $item->image_caption; else echo $item->title; ?>" style="width:<?php echo $item->params->get('itemImageGeneric'); ?>px; height:auto;" />
				    </a>
				  </span>
				  <div class="clr"></div>
			  </div>
			  <?php endif; ?>
			  
			  <?php if($item->params->get('genericItemIntroText')): ?>
			  <!-- Item introtext -->
			  <div class="catItemIntroText">
			  	<?php echo $item->introtext; ?>
			  </div>
			  <?php endif; ?>

			  <div class="clr"></div>
		  </div>
		  
		  <div class="clr"></div>
		  
		  <?php if($item->params->get('genericItemExtraFields') && count($item->extra_fields)): ?>
		  <!-- Item extra fields -->  
		  <div class="catItemExtraFields">
		  	<h4><?php echo JText::_('Additional Info'); ?></h4>
		  	<ul>
				<?php foreach ($item->extra_fields as $key=>$extraField): ?>
				<li class="<?php echo ($key%2) ? "odd" : "even"; ?> type<?php echo ucfirst($extraField->type); ?> group<?php echo $extraField->group; ?>">
					<span class="catItemExtraFieldsLabel"><?php echo $extraField->name; ?></span>
					<span class="catItemExtraFieldsValue"><?php echo $extraField->value; ?></span>
					<br class="clr" />		
				</li>
				<?php endforeach; ?>
				</ul>
		    <div class="clr"></div>
		  </div>
		  <?php endif; ?>
		  
			
			
			<?php if ($item->params->get('genericItemReadMore')): ?>
			<!-- Item "read more..." link -->
			<div class="catItemReadMore">
				<a class="k2ReadMore" href="<?php echo $item->link; ?>">
					<?php echo JText::_('Read more...'); ?>
				</a>
			</div>
			<?php endif; ?>

			<div class="clr"></div>
		</div>
		<!-- End K2 Item Layout -->
		
		<?php endforeach; ?>
	</div>

	<!-- Pagination -->
	<?php if($this->pagination->getPagesLinks()): ?>
	<div class="k2Pagination">
		<?php echo $this->pagination->getPagesLinks(); ?>
		<div class="clr"></div>
		<?php echo $this->pagination->getPagesCounter(); ?>
	</div>
	<?php endif; ?>

	<?php endif; ?>
	
</div>
<!-- End K2 Generic Layout -->

