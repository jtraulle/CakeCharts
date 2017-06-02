<?php
/**
 * Copyright 2017, Jean Traullé <jtraulle@users.noreply.github.com>
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2017, Jean Traullé <jtraulle@users.noreply.github.com>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 *
 */

/** @var string $id HTML identifier of div where chart will be drawed */
?>
<div class="text-danger font-weight-bold"
     style="padding:10px; margin: 10px; background-color: rgba(248,195,200,0.57)">
        <p style="font-size: large;">
            ✘ CakeCharts ERROR - unable to draw <?= $id ?> because of the following error:
        </p>
        <ul>
            <li><strong><?= $error; ?></strong></li>
        </ul>

</div>