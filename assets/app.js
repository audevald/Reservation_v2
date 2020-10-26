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
        console.log(response)
        window.location.reload() // TODO ajouter une mise à jour des données automatique
    })
}

function onClickBtnCancel(event) {
    event.preventDefault();

    const url = this.href;
    const icone = this.querySelector('i')
    const button = this
    
    axios.get(url).then(function (response) {
        if(button.classList.contains('btn-danger')) {
            icone.classList.replace('fa-ban', 'fa-check')
            button.classList.replace('btn-danger', 'btn-success')
        } else {
            icone.classList.replace('fa-check', 'fa-ban')
            button.classList.replace('btn-success', 'btn-danger')
        }
    })
}

function onClickBtnArrived(event) {
    event.preventDefault();

    const url = this.href;
    const icone = this.querySelector('i')
    const spanResa = document.querySelector('span.js-reservation-state')

    axios.get(url).then(function (response) {
        if (icone.classList.contains('text-dark')) {
            icone.classList.replace('text-dark', 'text-success')
            spanResa.textContent = response.data.message
            spanResa.classList.replace('text-dark', 'text-success')
        } else {
            icone.classList.replace('text-success', 'text-dark')
            spanResa.textContent = response.data.message
            spanResa.classList.replace('text-success', 'text-dark')
        }
    })
}

$('.js-confirm').on('click', onClickBtnConfirm)

$('.js-arrived').on('click', onClickBtnArrived)

$('.js-cancel').on('click', onClickBtnCancel)

console.log('Hello Webpack Encore! Edit me in assets/app.js');


