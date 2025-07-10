import './bootstrap';

import Alpine from 'alpinejs';
import $ from 'jquery';
import * as bootstrap from 'bootstrap';

window.bootstrap = bootstrap;
window.Alpine = Alpine;

Alpine.start();

$(document).ready(() => {
    $('#js-tasks-order').on('change', function (){
        const order = $(this).val();
        const url = new URL(window.location.href);

        url.searchParams.set('order', order);
        window.location.href = url.toString();
    })

    const actionModal = new bootstrap.Modal('#js-action-modal');

    let modalAction = null
    let modalMethod = null
    let modalActionFeedback = null

    // Clear variables after modal close.
    const actionModalElement = document.getElementById('js-action-modal')
    if (actionModalElement) {
        actionModalElement.addEventListener('hide.bs.modal', e => {
            modalAction = null;
            modalMethod = null;
            modalActionFeedback = null;
        })
    }

    const modalConfirmElement = $('#js-action-modal-confirm')

    // Handle destroy actions
    $('#js-destroy-action').on('click', function (e) {
        e.preventDefault();

        if (!actionModal) {
            console.error('Missing modal element')
            return;
        }

        const action = $(this).attr('data-js-action');
        const actionFeedBack = $(this).attr('data-js-action-feedback');
        const content = $(this).attr('data-js-action-content');
        const confirm = $(this).attr('data-js-action-confirm');

        if (action === undefined || action === '') {
            modalAction = null;

            console.error('Missing modal action')
            return;
        }

        if (content !== undefined && content !== '') {
            $('#js-action-modal-body').html(content);
        }

        if (confirm !== undefined && confirm !== '') {
            modalConfirmElement.html(confirm);
        }

        modalAction = action

        // TODO: Handle other methods POST/PUT etc..
        modalMethod = 'DELETE'
        modalActionFeedback = actionFeedBack

        actionModal.show();
    })

    // Set event on confirm modal action
    modalConfirmElement.on('click', function (e) {
        e.preventDefault();
        if (modalAction !== null && modalMethod !== null) {
            const csrf = $('meta[name="csrf-token"]').attr('content');
            if (csrf === undefined || csrf === '') {
                console.error('Missing csrf token')
            }

            fetch(modalAction, {
                method: modalMethod,
                credentials: 'same-origin',
                headers: {
                    "X-CSRF-TOKEN": csrf,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            }).then(response => {
                console.log(response)
                if (response.ok) {
                    if (modalActionFeedback) {
                        // redirect to modal action feedback.
                        window.location.href = modalActionFeedback
                    } else {
                        // TODO: handle default action.
                    }
                }
            }).finally(() => {
                actionModal.hide()
            })
        }
    })

    // Share task handler.
    $('#js-share-form').on('click', function (e) {
        e.preventDefault();
        $(this).prop('disabled', true)

        const form = $(this).parents('form');
        const formData = new FormData(form.get(0))

        const actionModal = new bootstrap.Modal('#share-task-modal');
        fetch(form.attr('action'), {
            method: 'POST',
            body: formData,
            credentials: 'same-origin',
            headers: {
                "X-CSRF-TOKEN": formData.get('_token'),
                'Accept': 'application/json'
            }
        })
        .then(async response => {
            const data = await response.json();
            if (!response.ok) {
                $('#js-share-form-error').html(data?.message || 'Something went wrong. Please try again later.');
            } else {

                // New dynamic shared task list element.
                const element = `
                    <div class="shared-task">
                        <a href="${data.url}" target="_blank" class="btn btn-secondary">Open</a>
                        <div class="ms-auto">
                            ${data.formatted_date}
                        </div>
                    </div>
                `

                $('#js-shared-task-list').append(element)
            }
        }).finally(() => {
            $(this).prop('disabled', false)
        })
    })
})
