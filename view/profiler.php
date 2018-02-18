<?php $this->layout('layout', ['title' => $title]) ?>

<h1 class="fdsport-category-title"><?= $title ?></h1>

<div id="profiler-graph" class="fdsport-wrapper"></div>

<script>
    function reload() {
        // AJAX call to reload profiling data
        $.ajax({
            url: "<?= BASE_URL . '/profiler/data' ?>",
            type: "POST",
            data: {},
            success: function() {
                sigma.parsers.json("<?= $productsFilename ?>", s);
                s.refresh();

                setTimeout(reload, 1000);
            }
        });
    }

    $(function () {
        s = new sigma("profiler-graph");
        s.settings({
            defaultNodeColor: "#ec5148"
        });

        sigma.parsers.json("<?= $productsFilename ?>", s);

        setTimeout(reload, 1000);
    });
</script>