import Templates from 'core/templates';
import Notification from 'core/notification';

/**
 * @module local_pr_graduates/components/loader
 */

let loaders = [];

export default {
    show(node, uuid = new Date().getTime()) {
        loaders.push(uuid);
        Templates.render(
            "local_pr_graduates/loader",
            {uuid: uuid}
        )
            .then(function(html, js) {
                Templates.appendNodeContents(node, html, js);
                return null;
            })
            .fail(Notification.exception);
        return uuid;
    },
    hideByUuid(uuid) {
        loaders = loaders.filter(item => item !== uuid);
        document.getElementById(uuid.toString()).remove();
    },
    hideByNode(node) {
        loaders = loaders.filter(item => item !== node.id);
        node.remove();
    }
};