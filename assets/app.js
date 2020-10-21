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

$('.js-confirm').on('click', onClickBtnConfirm)

console.log('Hello Webpack Encore! Edit me in assets/app.js');


