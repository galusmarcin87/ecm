<?php
echo shell_exec('svn update ../');
echo '<br>';
echo shell_exec('php70 ../yii.php migrate --interactive=0');

