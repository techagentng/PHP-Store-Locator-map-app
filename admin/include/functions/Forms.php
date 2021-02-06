<?php

function get_post_values($fields, $post_values) {
	for($i=0; $i<count($fields); $i++) {
		$data[$fields[$i]['name']] = $_POST[$fields[$i]['name']];
	}
	return $data;
}

//display admin control
function display_forms($criteria=array()) {
	$fields = $criteria['fields'];
	$submit = $criteria['submit'];
	$form = $criteria['form'];
	
	if($submit['name']=='') $submit['name']='submit';
	if($submit['value']=='') $submit['value']='Save';
	
	echo '<form method="post" id="'.$form['id'].'" name="'.$form['name'].'">';
	
		for($i=0; $i<count($fields); $i++) {
			
			if($fields[$i]['class']!='') $fields[$i]['class'] = 'class="'.$fields[$i]['class'].'"';
			
			if($fields[$i]['type']=='select') {
				echo '<label>'.$fields[$i]['title'].'</label>';
				echo '<p><select '.$fields[$i]['class'].' name="'.$fields[$i]['name'].'" class="form-control">';
				echo '<option value=""></option>';
				foreach($fields[$i]['select_values'] as $ind=>$value) {
					if($ind==$fields[$i]['value']) echo '<option value="'.$ind.'" selected>'.$value.'</option>';
					else echo '<option value="'.$ind.'">'.$value.'</option>';
				}
				echo '</select></p>';
			}
			elseif($fields[$i]['type']=='checkbox') {
				echo '<p><label>';
				if($options[$fields[$i]['value']]=='on') $checked='checked';
				else $checked='';
				echo '<input '.$fields[$i]['class'].' type="checkbox" name="'.$fields[$i]['name'].'" '.$checked.' class="form-control">';
				echo ' '.$fields[$i]['title'];
				echo '</label></p>';
			}
			elseif($fields[$i]['type']=='textarea') {
				if($fields[$i]['rows']!='') $fields[$i]['rows'] = 'rows="'.$fields[$i]['rows'].'"';
				echo '<label>'.$fields[$i]['title'].'</label>';
				echo '<p><textarea '.$fields[$i]['class'].' name="'.$fields[$i]['name'].'" style="width:100%" '.$fields[$i]['rows'].' class="form-control">'.$fields[$i]['value'].'</textarea></p>';
			}
			elseif($fields[$i]['type']=='hidden') {
				echo '<input type="hidden" id="'.$fields[$i]['name'].'" name="'.$fields[$i]['name'].'" value="'.$fields[$i]['value'].'">';
			}
			else {
				echo '<label>'.$fields[$i]['title'].'</label>';
				echo '<p><input '.$fields[$i]['class'].' type="text" id="'.$fields[$i]['name'].'" name="'.$fields[$i]['name'].'" class="form-control" value="'.$fields[$i]['value'].'"></p>';
			}
		}
		
		echo '<p class="submit">';
		echo '<input type="submit" name="'.$submit['name'].'" id="'.$submit['id'].'" value="'.$submit['value'].'" class="btn btn-primary">';
		echo '</p>';
	
	echo '</form>';
}

?>