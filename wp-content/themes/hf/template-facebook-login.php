<?php
/* Template Name: Facebook Login */
wp_head();
?>
<script>
    jQuery(document).ready(function($) {
        var getUrlParameter = function getUrlParameter(sParam) {
            var sPageURL = decodeURIComponent(window.location.search.substring(1)), sURLVariables = sPageURL.split('&'), sParameterName, i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : sParameterName[1];
                }
            }
        };

        var code = getUrlParameter('code');
        var state = getUrlParameter('state');
        var domain_name = window.location.origin;

        if(window.location.hostname == 'localhost') {
            domain_name = domain_name + '/wpHF';
        } else if(window.location.hostname == 'dev-beta.smart-is.com' || window.location.hostname == 'dev.smart-is.com') {
            domain_name = domain_name + '/humanityfirst';
        }

        $.ajax({
            url: ajax_object.ajaxurl,
            type: "get", //send it through get method
            data: {
                action: 'fb_login_action',
                code: code,
                state: state,
                domain: domain_name
            },
            success: function(response) {
                console.log(response);
                window.location.replace(response);
            },
            error: function(xhr) {
                console.log(xhr);
            }
        });
    });

</script>
<!-- Preloader -->
<div class="preloader">
  <div class="spinner"></div>
</div>
<!-- ./Preloader -->
<?php wp_footer();?>