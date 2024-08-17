(function () {
    const openUrls = () => {
        const pathname = window.location.pathname;
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        urlParams.append('c', 'rss');
        urlParams.append('a', 'current');

        window.open(`${pathname}?${urlParams.toString()}`, '_blank');
    };

    const registerButtonClick = () => {
        const button = document.getElementById('bringBackRssButton');
        button.addEventListener('click', () => openUrls());
        console.log('registered rss button');
    }

    if (document.readyState !== "loading") {
        registerButtonClick();
        return;
    }
    document.addEventListener("DOMContentLoaded", () => {
        registerButtonClick();
    });
}());
