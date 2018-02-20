<?php $this->layout('layout', ['title' => $title]) ?>

<h1 class="fdsport-category-title"><?= $title ?></h1>

<form>
    <div class="fdsport-wrapper">
        <label for="product">Visiter un produit :</label>
        <div class="d-flex justify-content-start fdsport-wrapper">
            <input id="product" type="number" class="form-control" style="width: 150px; height: 50px;" placeholder="Ex.: 29">
            <button id="btn-submit" type="submit" class="btn btn-success">OK</button>
            <button id="btn-reset" type="button" class="btn btn-secondary">Reset</button>
            <div id="request-result" style="padding: 10px;"></div>
        </div>
    </div>
    <div id="last-products" class="d-flex justify-content-start fdsport-wrapper">
        <button id="last-product-btn" type="button" class="btn btn-primary d-none" style="margin: 0px 5px;"></button>
    </div>
</form>

<script>
    function visitProduct(product) {
        if (product === undefined || product <= 0) {
            product = $("#product").val();
        }

        var res = $("#request-result");

        // AJAX call to imitate user action
        $.ajax({
            url: "<?= BASE_URL . '/profiler/updateUser/' ?>" + product,
            type: "POST",
            data: {},

            beforeSend: function () {
                res.html("Wait...");
                res.fadeIn();
            },

            success: function () {
                console.log("Visit OK");
                res.html("Visit OK");
                res.fadeOut(2000);

                // Clean form
                $("#product").val("");

                // Search if a button exists for this product
                if ($("#last-products").find("#btn-product-" + product).length <= 0) {

                    // Create new button for this product
                    var btnProduct = $("#last-product-btn").clone();
                    btnProduct.attr("id", "btn-product-" + product);
                    btnProduct.removeClass("d-none");
                    btnProduct.html(product);
                    btnProduct.click(function (evt) {
                        evt.preventDefault();
                        visitProduct(product);
                    });

                    // If there are too much product buttons, remove the first
                    if ($("#last-products").find("button").length >= 10) {
                        $("#last-products").find("button:first-child").remove();
                    }

                    // Append new button
                    $("#last-products").append(btnProduct);
                }
            },

            error: function () {
                console.log("Visit product ERROR");
                res.html("Visit product ERROR");
                res.fadeOut(2000);
            }
        });
    }

    function resetProfiler() {
        var res = $("#request-result");

        // AJAX call to reset profiling data
        $.ajax({
            url: "<?= BASE_URL . '/profiler/reset' ?>",
            type: "POST",
            data: {},
            beforeSend: function () {
                res.html("Wait...");
                res.fadeIn();
            },
            success: function () {
                console.log("Reset OK");
                res.html("Reset OK");
                res.fadeOut(2000);
            },
            error: function () {
                console.log("Reset ERROR");
                res.html("Reset ERROR");
                res.fadeOut(2000);
            }
        });
    }

    $(function () {
        $("#btn-submit").click(function (evt) {
            evt.preventDefault();
            visitProduct();
        });

        $("#btn-reset").click(function (evt) {
            evt.preventDefault();
            resetProfiler();
        });
    });
</script>