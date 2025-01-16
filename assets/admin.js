import './main';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/admin.scss';

$(".release-check").each(function (index) {
    $(this).on("click", function () {
        let data = {released: 0};
        if ($(this).prop("checked")) {
            data = {released: 1};
        }
        let url = $(this).data('url');
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            dataType: 'json',
            success: function (data, textStatus) {
                console.log("Success");
            }
        });
    });
});