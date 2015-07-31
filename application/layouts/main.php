<!DOCTYPE html>
<html>
	<head>
		<?php $this->block($this->blocks['head']) ?>
	</head>
	<body>
		<header>
			<?php $this->block($this->blocks['header']) ?>
		</header>
        
		<div class="content">
        
			<?php $this->content() ?>
		</div>
        
        <div class="footer">
			<?php $this->block($this->blocks['footer']) ?>
		</div>
        

            <?php $this->block($this->blocks['modal']) ?>

        
	</body>
</html>