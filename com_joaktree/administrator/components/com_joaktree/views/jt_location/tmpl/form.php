<?php
defined('_JEXEC') or die('Restricted access');

// are these needed
JHtml::addIncludePath(JPATH_COMPONENT.DS.'helpers'.DS.'html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');

?>

<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'location.cancel' || document.formvalidator.isValid(document.id('tree-form'))) {
			Joomla.submitform(task, document.getElementById('tree-form'));
		} else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
	function clearResultValue() {
		document.getElementById('jform_resultValue').value  = null;
		document.getElementById('jform_resultValue2').value = null;
	}

	function setResult(lat,lon,adr) {
		document.getElementById('jform_latitude').value     = lat;
		document.getElementById('jform_longitude').value    = lon;
		document.getElementById('jform_resultValue').value  = adr;
		document.getElementById('jform_resultValue2').value = adr;
	}
	function setDeleteCheckbox() {
		var El = document.getElementById('jform_indDeleted');
		if (El.checked == true) { El.value = 1; }
			else { El.value = 0; }
		clearResultValue();
	}
</script>

<form 
	action="<?php echo JRoute::_('index.php?option=com_joaktree'); ?>" 
	method="post" 
	name="adminForm" 
	id="tree-form" 
	class="form-validate form-horizontal"
>
<div class="span10 form-horizontal">
	<fieldset>
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#details" data-toggle="tab"><?php echo  $this->item->value; ?></a>
			</li>
		</ul>

		<!-- content starts here -->
		<div class="tab-content">
			<div class="tab-pane active" id="details">
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('value'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('value'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('resultValue2'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('resultValue2'); ?>
						<?php echo $this->form->getInput('resultValue'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('latitude'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('latitude'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('longitude'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('longitude'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('indDeleted'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('indDeleted'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('id'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('id'); ?>
					</div>
				</div>
			
			
			</div>
		</div>
	</fieldset>
	
	<?php if (count($this->geoCodeSet)) {?>
		<!--  table -->
		<table class="table table-striped" id="articleList">
			<thead>
				<tr>
					<th width="1%" class="nowrap center hidden-phone">
						<?php echo JText::_( 'JT_HEADING_NUMBER' ); ?>
					</th>
					<th class="nowrap hidden-phone">
						<?php echo JText::_( 'JT_LABEL_GEOCODELOCATION' ); ?>
					</th>
					<th class="nowrap hidden-phone">
						<?php echo JText::_( 'JT_LABEL_LATITUDE' ); ?>
					</th>
					<th class="nowrap hidden-phone">
						<?php echo JText::_( 'JT_LABEL_LONGITUDE' ); ?>
					</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($this->geoCodeSet as $i => $result) {
						$function = 'setResult(\''.$result->lat.'\', \''.$result->lon.'\', \''.htmlspecialchars($result->adr, ENT_QUOTES).'\');'; 
				?>
					<tr class="row<?php echo $i % 2; ?>">
						<td class="nowrap center hidden-phone"><?php echo $i+1; ?></td>
						<td class="nowrap hidden-phone">
							<a onclick="<?php echo $function; ?>" href="javascript:void(0);">
						    <?php echo $result->adr; ?>
						    </a>
						</td>
						<td class="nowrap hidden-phone"><?php echo $result->lat; ?></td>
						<td class="nowrap hidden-phone"><?php echo $result->lon; ?></td>				
					</tr>
				<?php } ?>		
			</tbody>
		</table>
	<?php } ?>	
	<div class="clearfix"></div>	

	<!-- The number of hits -->
	<?php echo $this->form->getInput('results', '', count($this->geoCodeSet)); ?>

	<input type="hidden" name="task" value="" />
	<input type="hidden" name="cid[]" value="<?php echo $this->item->id; ?>" />
	<input type="hidden" name="controller" value="jt_locations" />
	<?php echo JHtml::_('form.token'); ?>

</div>
</form>








