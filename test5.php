<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="dd" id="nestable">
	<ol class="dd-list">
		<li class="dd-item" data-id="1">
			<div class="dd-handle">Item 1</div>
		</li>
		<li class="dd-item" data-id="2">
			<div class="dd-handle">Item 2</div>
			<ol class="dd-list">
				<li class="dd-item" data-id="3"><div class="dd-handle">Item 3</div></li>
				<li class="dd-item" data-id="4"><div class="dd-handle">Item 4</div></li>
				<li class="dd-item" data-id="5">
					<div class="dd-handle">Item 5</div>
					<ol class="dd-list">
						<li class="dd-item" data-id="6"><div class="dd-handle">Item 6</div></li>
						<li class="dd-item" data-id="7"><div class="dd-handle">Item 7</div></li>
						<li class="dd-item" data-id="8"><div class="dd-handle">Item 8</div></li>
					</ol>
				</li>
			</ol>
		</li>
	</ol>
</div>
</body>
</html>

<?php 
// <div class="progress"> +
// <div class="progress-bar bg-success" role="progressbar" style="width:" + $data + %;" aria-valuenow=" + $data + '" aria-valuemin="0" aria-valuemax="100"> + $data + % +
// </div> 
// </div>';


?>
<div class="progress mb-3" role="progressbar" aria-label="Info example" aria-valuenow="<?php echo $sum?>" aria-valuemin="0" aria-valuemax="100">
<div class="progress-bar bg-info" style="width:<?php echo $sum;?>"><?php echo $sum .'%'; ?>

<div class="progress"> 
 <div class="progress-bar bg-success" role="progressbar" style="<?= $data?>" aria-valuenow="<?= $data?>" aria-valuemin="0" aria-valuemax="100"> <?= $data?></div> 
 </div>