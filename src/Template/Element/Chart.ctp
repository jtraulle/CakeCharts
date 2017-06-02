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

/** @var \CakeCharts\Utility\Traces $data */
/** @var string $layout JSON formatted plotly.js compliant layout options object */
/** @var string $configuration JSON formatted plotly.js compliant configuration options object */
/** @var string $id HTML identifier of div where chart will be drawed */

$this->start('cakeChartsLibrary'); ?>
<script type="text/javascript" src="https://cdn.plot.ly/plotly-latest.min.js"></script>
<?php $this->end(); ?>

<?php $this->append('cakeChartsDefinition'); ?>
<!--suppress JSUnusedAssignment -->
<script type="text/javascript">
    var data = <?= $data ?>;
    var layout = <?= $layout ?>;
    var configuration = <?= $configuration ?>

    Plotly.newPlot('<?= $id ?>', data, layout, configuration);
</script>
<?php $this->end(); ?>

<div id="<?= $id ?>" >
    <?php if ($data->getError() !== null) : ?>
        <?= $this->element('CakeCharts.Error', [
            'id' => $id,
            'error' => $data->getError()->getMessage()
        ]); ?>
    <?php endif; ?>
</div>
