<?php
/**
* @version		$Id: helper.php 10079 2008-02-28 13:39:08Z ircmaxell $
* @package		Joomla
* @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once (JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');

class mod_slideshow3Helper
{
	function getList(&$params)
	{
		global $mainframe;

		$db			=& JFactory::getDBO();
		$user		=& JFactory::getUser();
		$userId		= (int) $user->get('id');
		$stripTags = $params->get(	'striptags','yes');
		$tags	= $params->get( 'tags', '<p><a><ul><li><div><h1><h2><h3><h4><h5><h6><b><em><i><strong><blockquote><dd><dt><small><u><br><br />' );
		$count		= (int) $params->get('count', 5);
		$catid		= $params->get('catid');
		$artid		= $params->get('artid');
		$show_front	= $params->get('show_front', 1);
		$aid		= $user->get('aid', 0);
		$articleSource = $params->get('article_source','cat');
		
		$linkTarget = $params->get('linkTarget','article');

		$contentConfig = &JComponentHelper::getParams( 'com_content' );
		$access		= !$contentConfig->get('shownoauth');

		$nullDate	= $db->getNullDate();

		$date =& JFactory::getDate();
		$now = $date->toMySQL();

		$where		= 'a.state = 1'
			. ' AND ( a.publish_up = '.$db->Quote($nullDate).' OR a.publish_up <= '.$db->Quote($now).' )'
			. ' AND ( a.publish_down = '.$db->Quote($nullDate).' OR a.publish_down >= '.$db->Quote($now).' )'
			;

		// User Filter
		switch ($params->get( 'user_id' ))
		{
			case 'by_me':
				$where .= ' AND (created_by = ' . (int) $userId . ' OR modified_by = ' . (int) $userId . ')';
				break;
			case 'not_me':
				$where .= ' AND (created_by <> ' . (int) $userId . ' AND modified_by <> ' . (int) $userId . ')';
				break;
		}

		// Ordering
		switch ($params->get( 'ordering' ))
		{
			case 'm_dsc':
				$ordering		= 'a.modified DESC, a.created DESC';
				break;
			case 'c_dsc':
			default:
				$ordering		= 'a.created DESC';
				break;
				case 'mostread':
				$ordering		= 'a.hits DESC';
				break;
				case 'item_order':
				$ordering		= 'a.ordering ASC ';
				break;
				case 'alpha' :
				$ordering 		= 'a.title ';
				break;
			case 'ralpha' :
				$ordering 		= 'a.title DESC ';
				break;
		}
		
		

		if ($artid)
		{
			
			$artid		= preg_split("/[\s,]+/", $artid);
			JArrayHelper::toInteger( $artid );
			$artCondition = ' AND (a.id=' . implode( ' OR a.id=', $artid ) . ')';
		}
		
		if ($catid)
		{
			if (is_array($catid))
			{
				JArrayHelper::toInteger( $catid );
				$catCondition = ' AND (cc.id=' . implode( ' OR cc.id=', $catid ) . ')';
				if($articleSource == 'catart'){
					$catCondition = ' OR (cc.id=' . implode( ' OR cc.id=', $catid ) . ')';
				}
			}
			else
			{
				$ids = explode( ',', $catid );
				JArrayHelper::toInteger( $ids );
				$catCondition = ' AND (cc.id=' . implode( ' OR cc.id=', $ids ) . ')';
				if($articleSource == 'catart'){
					$catCondition = ' OR (cc.id=' . implode( ' OR cc.id=', $ids ) . ')';
				}
			}			
		}
		
		if($articleSource == 'cat'){
			$artCondition = '';
		}elseif ($articleSource == 'art'){
			$catCondition = '';
		}
		
		
		$jbIntroText	= $params->get( 'jbIntroText', 1 );

		
		// Content Items only
		$query = 'SELECT a.*, ' .
			' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,'.
			' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug'.
			' FROM #__content AS a' .
			($show_front == '0' ? ' LEFT JOIN #__content_frontpage AS f ON f.content_id = a.id' : '') .
			' INNER JOIN #__categories AS cc ON cc.id = a.catid' .
			' INNER JOIN #__sections AS s ON s.id = a.sectionid' .
			' WHERE '. $where .' AND s.id > 0' .
			($access ? ' AND a.access <= ' .(int) $aid. ' AND cc.access <= ' .(int) $aid. ' AND s.access <= ' .(int) $aid : '').
			($artid ? $artCondition : '').
			($catid ? $catCondition : '').
			($show_front == '0' ? ' AND f.content_id IS NULL ' : '').
			' AND s.published = 1' .
			' AND cc.published = 1' .
			' ORDER BY '. $ordering;
		$db->setQuery($query, 0, $count);
		$rows = $db->loadObjectList();

		$i		= 0;
		$lists	= array();
		foreach ( $rows as $row )
		{
			if($linkTarget == 'article') $lists[$i]->link = JRoute::_(ContentHelperRoute::getArticleRoute($row->slug, $row->catslug, $row->sectionid));
			if($linkTarget == 'default') $lists[$i]->link = JRoute::_(ContentHelperRoute::getCategoryRoute($row->catslug, $row->sectionid).'&layout=default');
			if($linkTarget == 'blog') $lists[$i]->link = JRoute::_(ContentHelperRoute::getCategoryRoute($row->catslug, $row->sectionid).'&layout=blog');
			$lists[$i]->title = $row->title;
			$lists[$i]->firstimage = $row->introtext;
			if ($stripTags == 'yes'){
				$lists[$i]->text = strip_tags( $row->introtext, ''.$tags.''  );
			}else{
				$lists[$i]->text = $row->introtext;
			}
			$i++;
		}

		return $lists;
	}
}

//Class modified from K2 Content Module helper
class modSSK2ContentHelper {

  function getList(&$params) {
  
    jimport('joomla.filesystem.file');
    $limit = $params->get('countK2', 5);
    $cid = $params->get('k2catid', NULL);
	$itemid = $params->get('itemid','');
    $ordering = $params->get('orderingK2');
    $limitstart = JRequest::getInt('limitstart');
	$stripTags = $params->get(	'striptags','yes');
	$tags	= $params->get( 'tags', '<p><a><ul><li><div><h1><h2><h3><h4><h5><h6><b><em><i><strong><blockquote><dd><dt><small><u><br><br />' );
	$linkTarget = $params->get('linkTarget','article');
    
    $user = &JFactory::getUser();
    $aid = $user->get('aid');
    $db = &JFactory::getDBO();
    
    $jnow = &JFactory::getDate();
    $now = $jnow->toMySQL();
    $nullDate = $db->getNullDate();
    
    $query = "SELECT i.*, c.name AS categoryname,c.id AS categoryid, c.alias AS categoryalias, c.params AS categoryparams";
    if ($ordering == 'best')
      $query .= ", (r.rating_sum/r.rating_count) AS rating";
      
    $query .= " FROM #__k2_items as i LEFT JOIN #__k2_categories c ON c.id = i.catid";
    
    if ($ordering == 'best')
      $query .= " LEFT JOIN #__k2_rating r ON r.itemID = i.id";
      
    $query .= " WHERE i.published = 1 AND i.access <= {$aid} AND i.trash = 0 AND c.published = 1 AND c.access <= {$aid} AND c.trash = 0";
    
    $query .= " AND ( i.publish_up = ".$db->Quote($nullDate)." OR i.publish_up <= ".$db->Quote($now)." )";
    $query .= " AND ( i.publish_down = ".$db->Quote($nullDate)." OR i.publish_down >= ".$db->Quote($now)." )";
    
    if($params->get('itemFilter') != 'item'){
		if (!is_null($cid)) {
	        if (is_array($cid)) {
	         if ($params->get('getChildren')) {

	           require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'models'.DS.'itemlist.php');
	           $allChildren = array();
	           foreach ($cid as $id) {
	             $categories = K2ModelItemlist::getCategoryChilds($id);
	             $categories[] = $id;
	             $categories = @array_unique($categories);
	             $allChildren = @array_merge($allChildren, $categories);
	           }

	           $allChildren = @array_unique($allChildren);
	           $sql = @implode(',', $allChildren);
	           $query .= " AND i.catid IN ({$sql})";

	         } else {
	           $query .= " AND i.catid IN(".implode(',', $cid).")";
	         }

	       } else {
	         if ($params->get('getChildren')) {
	           require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'models'.DS.'itemlist.php');
	           $categories = K2ModelItemlist::getCategoryChilds($cid);
	           $categories[] = $cid;
	           $categories = @array_unique($categories);
	           $sql = @implode(',', $categories);
	           $query .= " AND i.catid IN ({$sql})";
	         } else {
	           $query .= " AND i.catid={$cid}";
	         }

	       }
	     }
	}
	
    if($params->get('itemFilter') == 'item'){
		$itemid		= preg_split("/[\s,]+/", $itemid);
		JArrayHelper::toInteger( $itemid );
		$query .= ' AND (i.id=' . implode( ' OR i.id=', $itemid ) . ')';
	}
	
	if($params->get('itemFilter') == 'catitem'){
		$itemid		= preg_split("/[\s,]+/", $itemid);
		JArrayHelper::toInteger( $itemid );
		$query .= ' OR (i.id=' . implode( ' OR i.id=', $itemid ) . ')';
	}
 
    if ($params->get('itemFilter') == 'feat')
      $query .= " AND i.featured = 1";
      
    switch ($ordering) {
    
      case 'date':
        $orderby = 'i.created ASC';
        break;
        
      case 'rdate':
        $orderby = 'i.created DESC';
        break;
        
      case 'alpha':
        $orderby = 'i.title';
        break;
        
      case 'ralpha':
        $orderby = 'i.title DESC';
        break;
        
      case 'order':
        if ($params->get('itemFilter') == 'feat')
          $orderby = 'i.featured_ordering';
        else
          $orderby = 'i.ordering';
        break;
        
      case 'hits':
        $orderby = 'i.hits DESC';
        break;
        
      case 'rand':
        $orderby = 'RAND()';
        break;
        
      case 'best':
        $orderby = 'rating DESC';
        break;
        
      default:
        $orderby = 'i.id DESC';
        break;
    }
    
    $query .= " ORDER BY ".$orderby;
    $db->setQuery($query, 0, $limit);
    $items = $db->loadObjectList();
	
	require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'route.php');
	require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'models'.DS.'item.php');
	$model = new K2ModelItem;
    
    if (count($items)) {
    
      	$k2ImageSource = $params->get('content_image','k2content');
		foreach ($items as $item) {
      
        //Images
		if($k2ImageSource == "k2item")
		{
			if (JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'src'.DS.md5("Image".$item->id).'.jpg'))
	            $item->imageOriginal = 'media/k2/items/src/'.md5("Image".$item->id).'.jpg';
			
			if (JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_XS.jpg'))
	            $item->imageXSmall = 'media/k2/items/cache/'.md5("Image".$item->id).'_XS.jpg';

          if (JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_S.jpg'))
            $item->imageSmall = 'media/k2/items/cache/'.md5("Image".$item->id).'_S.jpg';

          if (JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_M.jpg'))
            $item->imageMedium = 'media/k2/items/cache/'.md5("Image".$item->id).'_M.jpg';

          if (JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_L.jpg'))
            $item->imageLarge = 'media/k2/items/cache/'.md5("Image".$item->id).'_L.jpg';

          if (JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_XL.jpg'))
            $item->imageXLarge = 'media/k2/items/cache/'.md5("Image".$item->id).'_XL.jpg';

          if (JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_Generic.jpg'))
            $item->imageGeneric = 'media/k2/items/cache/'.md5("Image".$item->id).'_Generic.jpg';

          $image = 'image'.$params->get('itemImageSize');
          if (isset($item->$image))
            $item->firstimage = $item->$image;
		}
		elseif($k2ImageSource == "k2content")
		{
			$item->firstimage = $item->introtext;
		}

			
            
        
        
        //Read more link
        if($linkTarget == 'article'){$item->link = urldecode(JRoute::_(K2HelperRoute::getItemRoute($item->id.':'.urlencode($item->alias), $item->catid.':'.urlencode($item->categoryalias))));
}else{
$item->link = urldecode(JRoute::_(K2HelperRoute::getCategoryRoute($item->catid.':'.urlencode($item->categoryalias))));
}
        
		//K2 Comment Count
        $item->numOfComments = $model->countItemComments($item->id);
        
        // Introtext
		$item->text .= $item->introtext;
		
		if ($stripTags == 'yes'){
			$item->text = strip_tags( $item->text, ''.$tags.''  );
		}
		
        
        $rows[] = $item;
      }
      
      return $rows;
      
    }
    
  }
  
}
