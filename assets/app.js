/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
import $ from 'jquery';

function onClickBtnConfirm(event) {
    event.preventDefault();

    const url = this.href;

    axios.get(url).then(function (response) {
        const liId = 'reservation-' + response.data.reservationId
        $("#" + liId).remove()
    })
}

function onClickBtnCancel(event) {
    event.preventDefault();

    const url = this.href;
    const icone = this.querySelector('i')
    const button = this

    axios.get(url).then(function (response) {
        if (button.classList.contains('btn-danger')) {
            icone.classList.replace('fa-ban', 'fa-check')
            button.classList.replace('btn-danger', 'btn-success')
        } else {
            icone.classList.replace('fa-check', 'fa-ban')
            button.classList.replace('btn-success', 'btn-danger')
        }
    })
}

function onClickBtnCancelDay(event) {
    event.preventDefault()
    if (confirm("Confirmer l'annulation de la réservation ?")) {
        const url = this.href

        axios.get(url).then(function (response) {
            const liId = 'reservation-' + response.data.reservationId
            $("#" + liId).remove()
        })
    }
}

function onClickBtnRemove(event) {
    event.preventDefault()
    if (confirm("Confirmer la suppréssion de la réservation ?")) {
        const url = this.href

        axios.get(url).then(function (response) {
            const liId = 'reservation-' + response.data.reservationId
            $("#" + liId).remove()
        })
    }
}

function onClickBtnArrived(event) {
    event.preventDefault();

    const url = this.href;
    const spanResa = this.querySelector('span.js-reservation-state')
    const button = this

    axios.get(url).then(function (response) {
        if (button.classList.contains('btn-secondary')) {
            button.classList.replace('btn-secondary', 'btn-success')
            spanResa.textContent = response.data.message
        } else {
            button.classList.replace('btn-success', 'btn-secondary')
            spanResa.textContent = response.data.message
        }
    })
}

$('.js-confirm').on('click', onClickBtnConfirm)

$('.js-arrived').on('click', onClickBtnArrived)

$('.js-cancel').on('click', onClickBtnCancel)

$('.js-cancel-day').on('click', onClickBtnCancelDay)

$('.js-remove').on('click', onClickBtnRemove)

$('.card').on('click', function () {
    console.log('clique')
    $(this).css('background-color', '#0275d8')
    $(this).css('color', 'white')
})

console.log('Hello Webpack Encore! Edit me in assets/app.js');


