import ajax from 'core/ajax';
import Notification from 'core/notification';
import Templates from 'core/templates';
import loader from 'local_pr_graduates/components/loader';

/**
 * @module local_pr_graduates/Chat
 */

class Chat {

    constructor(application, sender, objectId, interval) {
        this.timeUpdate = false;
        this.lastError = '';
        this.isLoad = false;
        // Список всех идентификаторов сообщений
        this.listMessagesIds = [];
        // Полный массив сообщений
        this.listMessages = [];
        // Идентификатор приложения для чата
        this.application = application;
        this.objectId = objectId;
        // Идентификатор отправителя
        this.sender = sender;
        // Интервал обновления чата
        this.interval = Number(interval);
        // Контейнер для интервала;
        this.intervalEvent = '';
        // Идентификатор цитируемой записи
        this.quote = '';
        // Сообщение
        this.messages = '';
        // Идентификатор загрузочного блока
        this.loaderUuid = new Date().getTime();
        // Назначение событий для отправки сообщений
        this.eventSend();
        this.getNewMessage();
    }

    // Получаем список сообщений с сервера
    getListMessages() {
        this.beforeGetListMessages();
        ajax.call([{
            methodname: 'local_pr_graduate_chat_get_messages',
            args: {
                application: this.application,
                object_id: this.objectId
            },
            done: response => this.resultGetListMessages(response),
            fail: Notification.exception,
        }]);
        this.afterGetListMessages();
    }

    // Отправляем новое сообщение
    sendMessage() {
        let args = {
            sender: this.sender,
            application: this.application,
            uid_quote: this.quote,
            object_id: this.objectId,
            message: document.getElementById('textarea-container__input').value
        };
        this.beforeSendMessage();
        ajax.call([{
            methodname: 'local_pr_graduate_chat_send_message',
            args: args,
            done: response => this.resultSendMessage(response),
            fail: Notification.exception,
        }]);
        this.afterSendMessage();
    }

    // Выполнить перед получением истории сообщений
    beforeGetListMessages() {
        if (!this.isLoad) {
            loader.show(document.querySelector('[role="main"]'), this.loaderUuid);
        }
    }

    // Результат получения списка сообщений
    async resultGetListMessages(response) {
        let promises;
        if (!response.success) {
            // Выводим ошибку полученную с сервера
            promises = this.buildError(response);
        } else {
            // Выводим список сообщений полученный с сервера
            promises = this.buildMessage(response);
        }

        await this.processAllPromises(promises);

        // Назначаем событие для цитирования сообщения
        this.eventQuote();
        // Отключаем загрузочный блок
        this.hideLoader();
        this.scrollToBottom();
        this.setLastTimeUpdate();
    }

    // Выполнить после получения истории сообщений
    afterGetListMessages() {
    }

    // Выполнить перед отправкой сообщения
    beforeSendMessage() {
    }

    // Результат отправки сообщения
    async resultSendMessage(response) {
        let promises;
        if (!response.success) {
            let message = 'Неизвестная ошибка сервера';

            if (response.errors.length) {
                message = response.errors.join('</br>');
            }
            Notification.alert('Ошибка при отправке сообщения', message, 'Закрыть');
        } else {
            promises = this.buildMessage(response);
        }
        await this.processAllPromises(promises);

        this.scrollToBottom();

    }

    // Выполнить после отправки сообщения
    afterSendMessage() {
    }

    hideLoader() {
        if (!this.isLoad) {
            let timeout = 1000;
            if (this.interval > 0 && this.interval < 1000) {
                timeout = this.interval > 0;
            }

            setTimeout(() => {
                loader.hideByUuid(this.loaderUuid);
                document.getElementById('main-messaging').classList.remove('d-none');
                this.scrollToBottom();
                this.isLoad = true;
            }, timeout);
        }
    }

    eventQuote() {
        if (!this.isLoad) {
            document.body.addEventListener('click', (event) => {
                if (event.target.classList.contains('add-quote')) {
                    this.clearQuote();
                    let quoteId = event.target.dataset.quoteId;
                    this.quote = quoteId;
                    let message = this.listMessages.filter(value => {
                        return quoteId === value.uid_message;
                    }).shift();
                    Templates.render("local_pr_graduates/components/chat/quote", message)
                        .then((html, js) => {
                            Templates.appendNodeContents(document.getElementById('main-messaging-quote'), html, js);
                            document.getElementById('textarea-container__quote-delete').addEventListener('click', () => {
                                this.clearQuote();
                            });
                            return null;
                        })
                        .fail(Notification.exception);
                }
            });
        }
    }

    eventSend() {
        document.getElementById('textarea-container__input').addEventListener('keydown', (event) => {
            if ((event.ctrlKey) && ((event.keyCode === 0xA) || (event.keyCode === 0xD))) {
                this.sendMessage();
                this.clearSend();
                this.clearQuote();
            }
        });

        document.getElementById('textarea-container__btn').addEventListener('click', () => {
            this.sendMessage();
            this.clearSend();
            this.clearQuote();
        });
    }

    clearSend() {
        document.getElementById('textarea-container__input').value = '';
    }

    clearQuote() {
        document.getElementById('main-messaging-quote').innerHTML = "";
        this.quote = '';
    }

    buildError(response) {
        let promises = [];
        if (response.errors.join("\n") === this.lastError) {
            return promises;
        }
        this.lastError = response.errors.join("\n");
        response.errors.forEach((item) => {
            promises.push(Templates.renderForPromise("local_pr_graduates/components/chat/error", {error: item}));
        });
        this.stopGetNewMessage();
        return promises;
    }

    buildMessage(response) {
        let promises = [],
            template;
        response.data.forEach((item) => {
            if (!this.listMessagesIds.includes(item.uid_message)) {
                this.listMessagesIds.push(item.uid_message);
                this.listMessages.push(item);
                if (item.uid_quote) {
                    item.quote_message = this.messageGetQuote(item.uid_quote);
                }

                item.date = this.convertDate(item.date);

                if (item.sender === this.sender) {
                    template = "local_pr_graduates/components/chat/incoming";
                } else {
                    template = "local_pr_graduates/components/chat/outgoing";
                }
                promises.push(Templates.renderForPromise(template, item));
            }
        });
        if (document.querySelector('.main-messaging-container__error')) {
            document.querySelector('.main-messaging-container__error').innerHTML = '';
        }
        return promises;
    }

    messageGetQuote(uidQuote) {
        return this.listMessages.filter((value) => {
            return uidQuote === value.uid_message;
        });
    }

    async processAllPromises(promises) {
        if (typeof promises !== "undefined") {
            (await Promise.all(promises)).forEach(({html, js}) => {
                Templates.appendNodeContents(document.getElementById('main-messaging-container'), html, js);
            });
        }
    }

    scrollToBottom() {
        let messageBlock = document.getElementById('main-messaging-container');
        messageBlock.scrollTop = messageBlock.scrollHeight;
    }

    getNewMessage() {
        if (this.interval > 0) {
            this.intervalEvent = setInterval(() => {
                this.getListMessages();
            }, this.interval);
        } else {
            this.stopGetNewMessage();
        }
    }

    stopGetNewMessage() {
        clearInterval(this.intervalEvent);
    }

    convertDate(date) {
        let newDate = new Date(date);
        let day = newDate.getDate() < 10 ? '0' + newDate.getDate() : newDate.getDate();
        let month = (newDate.getMonth() + 1) < 10 ? '0' + (newDate.getMonth() + 1) : newDate.getMonth();
        let hour = newDate.getHours() < 10 ? '0' + newDate.getHours() : newDate.getHours();
        let minute = newDate.getMinutes() < 10 ? '0' + newDate.getMinutes() : newDate.getMinutes();
        let second = newDate.getSeconds() < 10 ? '0' + newDate.getSeconds() : newDate.getSeconds();
        return `${day}.${month}.${newDate.getFullYear()} ${hour}:${minute}:${second}`;
    }

    setLastTimeUpdate() {
        document.getElementById('time-update-container').classList.remove('d-none');
        document.getElementById('time-update').innerHTML = " " + this.convertDate(new Date());
    }
}

export const init = (application, sender, objectId, interval) => {
    new Chat(application, sender, objectId, interval).getListMessages();
};