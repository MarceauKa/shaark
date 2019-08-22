(function () {
    var url = location.href;
    var title = document.title || url;
    window.open({
    {
        route('link.create')
    }
}
    '?post=' + encodeURIComponent(url) + '&title=' + encodeURIComponent(title) + '&source=bookmarklet', '_blank', 'menubar=no,height=390,width=600,toolbar=no,scrollbars=no,status=no,dialog=1'
)
    ;
})();