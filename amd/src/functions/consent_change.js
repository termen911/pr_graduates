import ajax from 'core/ajax';
import Notification from 'core/notification';

/**
 * @module local_pr_graduates/functions/consent_change
 */

let consent;
let consentLink = document.getElementById('consent_link');
const event = () => {
    if (consentLink) {
        consentLink.addEventListener('click', function (e) {
            e.preventDefault();
            consent = Number(this.dataset.consent);
            change();
        });
    }
};

const init = () => {
    event();
};

const change = () => {
    ajax.call([{
        methodname: 'local_pr_graduate_consent',
        args: {
            consent: consent
        },
        done: successAjax,
        fail: Notification.exception,
    }]);
};

const successAjax = () => {
    let message = '';
    if (Number(consent)) {
        consentLink.innerHTML = "Отозвать согласие на обработку персональных данных";
        consentLink.dataset.consent = '0';
        message = 'Ваше согласие успешно дано';
    } else {

        consentLink.innerHTML = "Дать согласие на обработку персональных данных";
        consentLink.dataset.consent = '1';
        message = 'Ваше согласие успешно отозвано';
    }
    Notification.alert('Согласие на обработку', message, 'Закрыть');
};

export default {init};