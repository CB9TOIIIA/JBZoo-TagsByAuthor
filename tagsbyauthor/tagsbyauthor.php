<?php
/**
 * @package   com_zoo
 * @author    YOOtheme http://www.yootheme.com
 * @copyright Copyright (C) YOOtheme GmbH
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

/*
	Class: ElementItemHits
		The item hits element class
*/
class ElementTagsbyauthor extends Element {

	/*
		Function: hasValue
			Checks if the element's value is set.

	   Parameters:
			$params - render parameter

		Returns:
			Boolean - true, on success
	*/

	public function hasValue($params = array()) {


			$author = $this->_item->created_by_alias;
			$user   = $this->app->user->get($this->_item->created_by);
			$authorid = $user->id;
			$authorname = $user->name;

	//	 jbdump($authorid,0,'Массив');



//jbdump($mydate,0,'mydate');



$db     = JFactory::getDBO();

$appId  = 1;

$query = $db->getQuery(true);

$query
    ->select($db->quoteName('id'))
    ->from($db->quoteName(ZOO_TABLE_ITEM))
    ->where($db->quoteName('created_by') . ' = ' . $db->quote($authorid));


$db->setQuery($query);
$itemIdsResult = $db->loadObjectList();

$querys = $db->getQuery(true);
$querys
    ->select($db->quoteName('publish_up'))
    ->from($db->quoteName(ZOO_TABLE_ITEM))
    ->where($db->quoteName('created_by') . ' = ' . $db->quote($authorid))
    ->order('created_by DESC');


$db->setQuery($querys);
$itemIdsResultsdate = $db->loadObjectList();


$itemIdsdate = array();
foreach ($itemIdsResultsdate as $itdate) {

    $itemIdsdate[] = date("m.Y", strtotime("+0 seconds", strtotime($itdate->publish_up)));

}
//    jbdump($itemIdsdate,0,'Массив статей');
$datearraydate = array_count_values($itemIdsdate);
//ksort($datearraydate);

//jbdump($datearraydate,0,'Масdfgdfgсив статей');





$countarticlesauthor = count($itemIdsResult);
//fix count (1 articles = author)
$countarticlesauthor = $countarticlesauthor - 1;
//jbdump($itemIdsResult,0,'asМассив статей автора');
//jbdump($countarticlesauthor,0,'Массив статей автора');
//$mydate = $this->_item->publish_up;



$itemIds = array();
foreach ($itemIdsResult as $it) {

    $itemIds[] = $it->id;
}



$query = "SELECT name"
    ." FROM " . ZOO_TABLE_TAG
    ." WHERE item_id IN (" . implode(', ', $itemIds) . ")";

$tagsArraycounttags = array_count_values($this->app->table->tag->database->queryResultArray($query));
$tagsArrayztags = array_unique($this->app->table->tag->database->queryResultArray($query));
ksort($tagsArraycounttags);
asort($tagsArrayztags);
//jbdump($tagsArrayztags,0,'Массив статей');

//jbdump($tagsArraycounttags,0,'Массив кол-во статей');
$currentTags = array();
$valtags = array();


echo "<p class='countarticlesauthor'>Всего статей: <b>".$countarticlesauthor."</b></p>";

echo "<div class='allinfoabout'>";
echo "<p>Статистика публикаций: </p>";
echo "<div class='tagsstat mounth'><ul class='zebra'>";
foreach ($datearraydate as $valtagdate => $valuecount )  {

echo  $datearraydate[] = '<li>'.$valtagdate. ' - '. $valuecount.'</li>';

}
echo "</ul></div>";

echo "<hr>";

if (!empty($tagsArrayztags )) {
	echo "<h3>".$authorname." использует следующие теги:</h3>";
}
else {
	echo "<h3>".$authorname." </h3>";
}

echo "<div class='tagsstat tags'><ul class='zebra'>";


foreach ($tagsArraycounttags as $valtag => $value )  {

//$valtags[] = '<a href="' . JRoute::_($this->app->route->tag($appId, $valtag)) . '">' . $valtag . '</a> - '. $value.', ';

echo  $valtags[] = '<li>'.$valtag. ' - '. $value.'</li>';

}
echo "</ul></div>";

echo "</div>";

//--------------------------------------------------------------

 }
	/*
	   Function: edit
	       Renders the edit form field.

	   Returns:
	       String - html
	*/
	public function edit() {
		return null;
	}

	/*
		Function: render
			Renders the element.

	   Parameters:
            $params - render parameter

		Returns:
			String - html
	*/
	public function render($params = array()) {
		return null;
	}

}