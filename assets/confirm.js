/**
 * Dokumentation: siehe /docs/Resources/Confirm.md
 */
import $ from 'jquery';
import swal from 'sweetalert2';

(function ( $, swal ) {
    $('.swal-confirm').click(function (e) {
        e.preventDefault();
        let $button = $(this);
        let url = $button.attr('href');

        let label = $button.data('label');
        if (!label) {
            label = 'Eintrag';
        }

        let action = $button.data('action');
        if (!action) {
            action = 'löschen';
        }

        let title = $button.data('title');
        if (!title) {
            title = label + " " + action + "?";
        }

        let text = $button.data('text');
        if (!text) {
            text = "Diese Aktion kann nicht rückgängig gemacht werden.";
        }

        let cancelButtonText = $button.data('cancel-button-text');
        if (!cancelButtonText) {
            cancelButtonText = 'Abbrechen';
        }

        let confirmButtonText = $button.data('confirm-button-text');
        if (!confirmButtonText) {
            confirmButtonText = "Ja, " + action + "!"
        }

        let footer = $button.data('footer');
        let inputType = $button.data('input');
        let inputLabel = $button.data('input-label');

        swal.fire({
            title: title,
            text: text,
            icon: "question",
            footer: footer,
            input: inputType,
            inputLabel: inputLabel,
            showCancelButton: true,
            cancelButtonText: cancelButtonText,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: confirmButtonText
        }).then(function (result) {
            if (result.value) {
                if (url) {
                    let $form = $('<form/>').hide();
                    $form.attr({
                        'action': url,
                        'method': 'POST'
                    });
                    $('body').append($form);
                    $form.submit();
                } else {
                    let $form = $button.closest('form');
                    $form.submit();
                }
            }
        });
    });
}( $, swal ));
