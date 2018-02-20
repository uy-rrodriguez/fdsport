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
                sigma.parsers.json("<?= $filename ?>", s);
                s.refresh();

                setTimeout(reload, 500);
            }
        });
    }

    $(function () {
        s = new sigma("profiler-graph");
        s.settings({
            defaultNodeColor: "#ec5148"
        });

        sigma.parsers.json("<?= $filename ?>", s);

        setTimeout(reload, 500);
    });
</script>