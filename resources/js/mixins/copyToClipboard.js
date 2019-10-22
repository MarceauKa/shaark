module.exports = {
    methods: {
        copyToClipboard($event, value) {
            let original = $event.target.innerHTML;
            $event.target.innerHTML = this.__('Copied');

            let timeout = setTimeout(() => {
                $event.target.innerHTML = original;
            }, 1000);

            const el = document.createElement('textarea');
            let storeContentEditable = el.contentEditable;
            let storeReadOnly = el.readOnly;

            el.value = value;
            el.contentEditable = true;
            el.readOnly = false;
            el.setAttribute('readonly', false); // Make it readonly false for iOS compatability
            el.setAttribute('contenteditable', true); // Make it editable for iOS
            el.style.position = 'absolute';
            el.style.left = '-9999px';
            document.body.appendChild(el);

            const selected = document.getSelection().rangeCount > 0 ? document.getSelection().getRangeAt(0) : false;

            el.select();
            el.setSelectionRange(0, 999999);
            document.execCommand('copy');
            document.body.removeChild(el);

            if (selected) {
                document.getSelection().removeAllRanges();
                document.getSelection().addRange(selected);
            }

            el.contentEditable = storeContentEditable;
            el.readOnly = storeReadOnly;
        },
    },
};
