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

// Requête confirmation de la réservation envoyée par le client et retrait de l'affichage
function onClickBtnConfirm(event) {
    event.preventDefault();
    const url = this.href;
    const loader = this.querySelector('span')
    const icone = this.querySelector('i')
    $.confirm({
        title: 'Confirmation',
        content: this.querySelector('i.mail') ? 'Confirmer avec l\'envoi d\'un mail au client ?' : 'Confirmer sans l\'envoi d\'un mail au client ?',
        buttons: {
            confirm: {
                text: 'Oui',
                btnClass: 'btn-green',
                action: function () {
                    icone.classList.add('d-none')
                    loader.classList.remove('d-none')
                    axios.get(url).then(function (response) {
                        const liId = 'reservation-' + response.data.reservationId
                        $("#" + liId).remove()
                    }).catch(function () {
                        icone.classList.remove('d-none')
                        loader.classList.add('d-none')
                    })
                }
            },
            cancel: {
                text: 'Non',
                action: function () {
                    icone.classList.remove('d-none')
                    loader.classList.add('d-none')
                }
            }
        }
    })
}

// Requête pour changer l'état annulée ou non de la réservation et modification dans l'affichage
function onClickBtnCancel(event) {
    event.preventDefault();

    const url = this.href;
    const icone = this.querySelector('i')
    const button = this
    const loader = this.querySelector('span')
    icone.classList.add('d-none')
    loader.classList.remove('d-none')

    axios.get(url).then(function (response) {

        if (button.classList.contains('btn-danger')) {
            icone.classList.replace('fa-ban', 'fa-check')
            button.classList.replace('btn-danger', 'btn-success')
        } else {
            icone.classList.replace('fa-check', 'fa-ban')
            button.classList.replace('btn-success', 'btn-danger')
        }
    }).then(function () {
        loader.classList.add('d-none')
        icone.classList.remove('d-none')
    }).catch(function () {
        icone.classList.remove('d-none')
        loader.classList.add('d-none')
    })
}

// Requête annulation de la réservation et retrait dans l'affichage
function onClickBtnCancelDay(event) {
    event.preventDefault()
    const url = this.href
    const loader = this.querySelector('span')
    const icone = this.querySelector('i')
    $.confirm({
        title: 'Annulation',
        content: 'Confirmer l\'annulation de la réservation ?',
        buttons: {
            confirm: {
                text: 'Oui',
                btnClass: 'btn-red',
                action: function () {
                    icone.classList.add('d-none')
                    loader.classList.remove('d-none')
                    axios.get(url).then(function (response) {
                        const liId = 'reservation-' + response.data.reservationId
                        $("#" + liId).remove()
                    }).catch(function () {
                        icone.classList.remove('d-none')
                        loader.classList.add('d-none')
                    })
                }
            },
            cancel: {
                text: 'Non',
                action: function () {
                    icone.classList.remove('d-none')
                    loader.classList.add('d-none')
                }
            }
        }
    })
}

// Requête Ajax supprimer la réservation et retrait dans l'affichage
function onClickBtnRemove(event) {
    event.preventDefault()
    const url = this.href
    const loader = this.querySelector('span')
    const icone = this.querySelector('i')
    $.confirm({
        title: 'Supprimer',
        content: 'Confirmer la suppréssion de la réservation ?',
        buttons: {
            confirm: {
                text: 'Oui',
                btnClass: 'btn-red',
                action: function () {
                    icone.classList.add('d-none')
                    loader.classList.remove('d-none')
                    axios.get(url).then(function (response) {
                        const liId = 'reservation-' + response.data.reservationId
                        $("#" + liId).remove()
                    }).catch(function () {
                        icone.classList.remove('d-none')
                        loader.classList.add('d-none')
                    })
                }
            },
            cancel: {
                text: 'Non',
                action: function () {
                    icone.classList.remove('d-none')
                    loader.classList.add('d-none')
                }
            }
        }
    })
}

// Requête pour changer l'état de la réservation si client arrivé ou non et modification dans l'affichage
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


