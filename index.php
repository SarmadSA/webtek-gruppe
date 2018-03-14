<?php
include 'templates/header_template.php';
?>
<nav class="secondNav">
    <ul>
        <li class="hoverNav active"><a href="index.php">New</a></li>
        <li class="hoverNav"><a href="index.php?cat=hot">Hot</a></li>     
    </ul>
</nav>
<div id="content"></div>
<br>
<button id="loadMore">Load More</button>
<script type="text/javascript">

    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = decodeURIComponent(window.location.search.substring(1)),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;
        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');
            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : sParameterName[1];
            }
        }
    };
    var cat = getUrlParameter('cat');

    var range = "";
    var click = 0;
    window.onload = function () {
        if ((typeof cat !== "undefined") && (cat.includes('hot'))) {
            range = "rating";
            loadMore();
            $("#loadMore").click(function () {
                click += 5;
                loadMore();
            });
        } else {
            loadMore();
            $("#loadMore").click(function () {
                click += 5;
                loadMore();
            });
        }
    };

    loadMore = function ()
    {
        $.ajax({
            url: 'loadPosts.php',
            type: 'POST',
            dataType: "html",
            data: {
                sort: range,
                posts: click
            },
            success: function (result)
            {
                $("#content").append(result);
            },
            error: function () {
                console.log(error);
            },
            async: true
        });
    };
</script>
<?php
include 'templates/footer_template.php';

